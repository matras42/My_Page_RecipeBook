<?php
require_once __DIR__ . '/config.php';

function db_connection() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $pdo;
    } catch (Exception $e) {
        return null;
    }
}

function load_recipes_json() {
    if (!file_exists(JSON_STORAGE)) {
        return [];
    }
    $content = file_get_contents(JSON_STORAGE);
    $items = json_decode($content, true);
    return is_array($items) ? $items : [];
}

function save_recipes_json($items) {
    file_put_contents(JSON_STORAGE, json_encode(array_values($items), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

function normalize_recipe($row) {
    foreach (['ingredients', 'steps'] as $field) {
        if (isset($row[$field]) && is_string($row[$field])) {
            $decoded = json_decode($row[$field], true);
            $row[$field] = is_array($decoded) ? $decoded : array_values(array_filter(array_map('trim', explode("\n", $row[$field]))));
        }
    }
    return $row;
}

function all_recipes() {
    $pdo = db_connection();
    if ($pdo) {
        $stmt = $pdo->query('SELECT * FROM recipes ORDER BY id DESC');
        return array_map('normalize_recipe', $stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    $items = load_recipes_json();
    usort($items, fn($a, $b) => (int)$b['id'] <=> (int)$a['id']);
    return $items;
}

function recipe_by_id($id) {
    $id = (int)$id;
    $pdo = db_connection();
    if ($pdo) {
        $stmt = $pdo->prepare('SELECT * FROM recipes WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? normalize_recipe($row) : null;
    }
    foreach (load_recipes_json() as $recipe) {
        if ((int)$recipe['id'] === $id) {
            return $recipe;
        }
    }
    return null;
}

function categories_list() {
    $items = all_recipes();
    $cats = [];
    foreach ($items as $recipe) {
        $cats[$recipe['category']] = true;
    }
    $cats = array_keys($cats);
    sort($cats, SORT_LOCALE_STRING);
    return $cats;
}

function recipes_by_category($category) {
    return array_values(array_filter(all_recipes(), fn($recipe) => mb_strtolower($recipe['category']) === mb_strtolower($category)));
}

function search_recipes($query) {
    $query = trim(mb_strtolower($query));
    if ($query === '') {
        return all_recipes();
    }
    return array_values(array_filter(all_recipes(), function($recipe) use ($query) {
        $text = mb_strtolower($recipe['title'] . ' ' . $recipe['category'] . ' ' . $recipe['intro'] . ' ' . implode(' ', $recipe['ingredients']));
        return mb_strpos($text, $query) !== false;
    }));
}

function escape_text($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function split_lines($text) {
    $lines = preg_split('/\r\n|\r|\n/', trim((string)$text));
    return array_values(array_filter(array_map('trim', $lines)));
}

function recipe_from_post() {
    return [
        'id' => isset($_POST['id']) ? (int)$_POST['id'] : 0,
        'title' => trim($_POST['title'] ?? ''),
        'category' => trim($_POST['category'] ?? ''),
        'author' => trim($_POST['author'] ?? 'Палій Вадим'),
        'time' => trim($_POST['time'] ?? ''),
        'servings' => trim($_POST['servings'] ?? ''),
        'difficulty' => trim($_POST['difficulty'] ?? ''),
        'image' => trim($_POST['image'] ?? ''),
        'date' => trim($_POST['date'] ?? date('Y-m-d')),
        'intro' => trim($_POST['intro'] ?? ''),
        'ingredients' => split_lines($_POST['ingredients'] ?? ''),
        'steps' => split_lines($_POST['steps'] ?? '')
    ];
}

function save_recipe($recipe) {
    $pdo = db_connection();
    if ($pdo) {
        if ((int)$recipe['id'] > 0) {
            $stmt = $pdo->prepare('UPDATE recipes SET title=?, category=?, author=?, time=?, servings=?, difficulty=?, image=?, date=?, intro=?, ingredients=?, steps=? WHERE id=?');
            $stmt->execute([$recipe['title'], $recipe['category'], $recipe['author'], $recipe['time'], $recipe['servings'], $recipe['difficulty'], $recipe['image'], $recipe['date'], $recipe['intro'], json_encode($recipe['ingredients'], JSON_UNESCAPED_UNICODE), json_encode($recipe['steps'], JSON_UNESCAPED_UNICODE), $recipe['id']]);
            return $recipe['id'];
        }
        $stmt = $pdo->prepare('INSERT INTO recipes (title, category, author, time, servings, difficulty, image, date, intro, ingredients, steps) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$recipe['title'], $recipe['category'], $recipe['author'], $recipe['time'], $recipe['servings'], $recipe['difficulty'], $recipe['image'], $recipe['date'], $recipe['intro'], json_encode($recipe['ingredients'], JSON_UNESCAPED_UNICODE), json_encode($recipe['steps'], JSON_UNESCAPED_UNICODE)]);
        return (int)$pdo->lastInsertId();
    }
    $items = load_recipes_json();
    if ((int)$recipe['id'] > 0) {
        foreach ($items as &$item) {
            if ((int)$item['id'] === (int)$recipe['id']) {
                $item = $recipe;
                save_recipes_json($items);
                return $recipe['id'];
            }
        }
    }
    $max = 0;
    foreach ($items as $item) {
        $max = max($max, (int)$item['id']);
    }
    $recipe['id'] = $max + 1;
    $items[] = $recipe;
    save_recipes_json($items);
    return $recipe['id'];
}

function delete_recipe($id) {
    $id = (int)$id;
    $pdo = db_connection();
    if ($pdo) {
        $stmt = $pdo->prepare('DELETE FROM recipes WHERE id = ?');
        $stmt->execute([$id]);
        return;
    }
    $items = array_values(array_filter(load_recipes_json(), fn($item) => (int)$item['id'] !== $id));
    save_recipes_json($items);
}

function is_admin() {
    return !empty($_SESSION['admin']);
}

function recipe_image($path, $alt = '') {
    $safePath = escape_text($path ?: 'img/borscht.svg');
    $safeAlt = escape_text($alt);
    return '<object class="recipe-photo" data="' . $safePath . '" type="image/svg+xml" aria-label="' . $safeAlt . '"></object>';
}
?>
