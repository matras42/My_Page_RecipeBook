<?php
require_once __DIR__ . '/include/functions.php';
$q = trim($_GET['q'] ?? '');
$recipes = search_recipes($q);
include __DIR__ . '/header.php';
?>
<section class="wrap section">
    <h1>Пошук рецептів</h1>
    <form class="search line" action="search.php" method="get">
        <input type="text" name="q" value="<?= escape_text($q) ?>" placeholder="Назва або інгредієнт">
        <button type="submit">Знайти</button>
    </form>
    <p class="found">Знайдено рецептів: <?= count($recipes) ?></p>
    <div class="cards">
        <?php foreach ($recipes as $recipe): ?>
            <article class="card">
                <div class="photo"><?= recipe_image($recipe['image'], $recipe['title']) ?></div>
                <div class="card-body">
                    <span class="tag"><?= escape_text($recipe['category']) ?></span>
                    <h3><?= escape_text($recipe['title']) ?></h3>
                    <p><?= escape_text($recipe['intro']) ?></p>
                    <a class="btn" href="recipe.php?id=<?= (int)$recipe['id'] ?>">Детальніше</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php include __DIR__ . '/footer.php'; ?>