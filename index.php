<?php
require_once __DIR__ . '/include/functions.php';
$recipes = all_recipes();
$categories = categories_list();
include __DIR__ . '/header.php';
?>
<section class="hero">
    <div class="wrap hero-grid">
        <div>
            <p class="label">Збірка перевірених рецептів</p>
            <h1>Кулінарна книга для домашньої кухні</h1>
            <p>На сайті зібрані страви для сніданку, обіду, вечері та десерту. Кожен рецепт має список інгредієнтів, покрокове приготування і реальне фото.</p>
            <form class="search" action="search.php" method="get">
                <input type="text" name="q" placeholder="Пошук рецепта або інгредієнта">
                <button type="submit">Знайти</button>
            </form>
        </div>
        <div class="hero-card">
            <?= recipe_image('img/borscht.svg', 'Український борщ') ?>
        </div>
    </div>
</section>
<section class="wrap section">
    <h2>Категорії</h2>
    <div class="chips">
        <?php foreach ($categories as $category): ?>
            <a href="category.php?name=<?= urlencode($category) ?>"><?= escape_text($category) ?></a>
        <?php endforeach; ?>
    </div>
</section>
<section class="wrap section">
    <h2>Нові рецепти</h2>
    <div class="cards">
        <?php foreach ($recipes as $recipe): ?>
            <article class="card">
                <div class="photo"><?= recipe_image($recipe['image'], $recipe['title']) ?></div>
                <div class="card-body">
                    <span class="tag"><?= escape_text($recipe['category']) ?></span>
                    <h3><?= escape_text($recipe['title']) ?></h3>
                    <p><?= escape_text($recipe['intro']) ?></p>
                    <div class="meta">
                        <span><?= escape_text($recipe['time']) ?></span>
                        <span><?= escape_text($recipe['difficulty']) ?></span>
                    </div>
                    <a class="btn" href="recipe.php?id=<?= (int)$recipe['id'] ?>">Детальніше</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php include __DIR__ . '/footer.php'; ?>