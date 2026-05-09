<?php
require_once __DIR__ . '/include/functions.php';
$name = trim($_GET['name'] ?? '');
$recipes = $name ? recipes_by_category($name) : all_recipes();
include __DIR__ . '/header.php';
?>
<section class="wrap section">
    <h1><?= escape_text($name ?: 'Усі категорії') ?></h1>
    <div class="cards">
        <?php foreach ($recipes as $recipe): ?>
            <article class="card">
                <div class="photo"><?= recipe_image($recipe['image'], $recipe['title']) ?></div>
                <div class="card-body">
                    <span class="tag"><?= escape_text($recipe['category']) ?></span>
                    <h3><?= escape_text($recipe['title']) ?></h3>
                    <p><?= escape_text($recipe['intro']) ?></p>
                    <a class="btn" href="recipe.php?id=<?= (int)$recipe['id'] ?>">Відкрити рецепт</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php include __DIR__ . '/footer.php'; ?>