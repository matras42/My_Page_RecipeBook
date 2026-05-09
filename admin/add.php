<?php
require_once __DIR__ . '/_guard.php';
$recipe = $recipe ?? ['id' => 0, 'title' => '', 'category' => '', 'author' => 'Палій Вадим', 'time' => '', 'servings' => '', 'difficulty' => '', 'image' => 'img/borscht.svg', 'date' => date('Y-m-d'), 'intro' => '', 'ingredients' => [], 'steps' => []];
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма рецепта</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<header class="top">
    <div class="wrap nav">
        <a class="logo" href="index.php">Адмін-панель</a>
        <nav>
            <a href="../index.php">Сайт</a>
            <a href="logout.php">Вийти</a>
        </nav>
    </div>
</header>
<main class="wrap section">
    <h1><?= (int)$recipe['id'] ? 'Редагування рецепта' : 'Новий рецепт' ?></h1>
    <form class="editor" action="save.php" method="post">
        <input type="hidden" name="id" value="<?= (int)$recipe['id'] ?>">
        <label>Назва<input type="text" name="title" value="<?= escape_text($recipe['title']) ?>" required></label>
        <label>Категорія<input type="text" name="category" value="<?= escape_text($recipe['category']) ?>" required></label>
        <label>Автор<input type="text" name="author" value="<?= escape_text($recipe['author']) ?>" required></label>
        <label>Час<input type="text" name="time" value="<?= escape_text($recipe['time']) ?>" required></label>
        <label>Порції<input type="text" name="servings" value="<?= escape_text($recipe['servings']) ?>" required></label>
        <label>Складність<input type="text" name="difficulty" value="<?= escape_text($recipe['difficulty']) ?>" required></label>
        <label>Фото<input type="text" name="image" value="<?= escape_text($recipe['image']) ?>" required></label>
        <label>Дата<input type="date" name="date" value="<?= escape_text($recipe['date']) ?>" required></label>
        <label class="full">Опис<textarea name="intro" required><?= escape_text($recipe['intro']) ?></textarea></label>
        <label class="full">Інгредієнти<textarea name="ingredients" required><?= escape_text(implode("\n", $recipe['ingredients'])) ?></textarea></label>
        <label class="full">Кроки приготування<textarea name="steps" required><?= escape_text(implode("\n", $recipe['steps'])) ?></textarea></label>
        <button type="submit">Зберегти</button>
    </form>
</main>
</body>
</html>
