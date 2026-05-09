<?php
require_once __DIR__ . '/include/functions.php';
$recipe = recipe_by_id($_GET['id'] ?? 0);
include __DIR__ . '/header.php';
?>
<?php if (!$recipe): ?>
<section class="wrap section"><h1>Рецепт не знайдено</h1></section>
<?php else: ?>
<section class="wrap detail">
    <div class="detail-photo"><?= recipe_image($recipe['image'], $recipe['title']) ?></div>
    <div class="detail-body">
        <span class="tag"><?= escape_text($recipe['category']) ?></span>
        <h1><?= escape_text($recipe['title']) ?></h1>
        <p><?= escape_text($recipe['intro']) ?></p>
        <div class="info">
            <span>Час: <?= escape_text($recipe['time']) ?></span>
            <span>Порції: <?= escape_text($recipe['servings']) ?></span>
            <span>Складність: <?= escape_text($recipe['difficulty']) ?></span>
        </div>
    </div>
</section>
<section class="wrap columns">
    <div class="panel">
        <h2>Інгредієнти</h2>
        <ul>
            <?php foreach ($recipe['ingredients'] as $item): ?>
                <li><?= escape_text($item) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="panel">
        <h2>Приготування</h2>
        <ol>
            <?php foreach ($recipe['steps'] as $step): ?>
                <li><?= escape_text($step) ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>
<?php endif; ?>
<?php include __DIR__ . '/footer.php'; ?>
