<?php
require_once __DIR__ . '/_guard.php';
$recipes = all_recipes();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адмін-панель</title>
    <link rel="stylesheet" href="../css/main.css?v=3">
</head>
<body>
<header class="top">
    <div class="wrap nav">
        <a class="logo" href="../index.php">Кулінарна книга</a>
        <nav>
            <a href="add.php">Додати</a>
            <a href="logout.php">Вийти</a>
        </nav>
    </div>
</header>
<main class="wrap section">
    <h1>Адмін-панель</h1>
    <a class="btn" href="add.php">Додати рецепт</a>
    <div class="admin-list">
        <?php foreach ($recipes as $recipe): ?>
            <div class="admin-row">
                <span><?= escape_text($recipe['title']) ?></span>
                <span><?= escape_text($recipe['category']) ?></span>
                <div class="admin-actions">
                    <a class="small" href="edit.php?id=<?= (int)$recipe['id'] ?>">Редагувати</a>
                    <a class="small danger" href="delete.php?id=<?= (int)$recipe['id'] ?>">Видалити</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
