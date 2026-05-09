<?php
require_once __DIR__ . '/_guard.php';
$recipe = recipe_by_id($_GET['id'] ?? 0);
if (!$recipe) {
    header('Location: index.php');
    exit;
}
include __DIR__ . '/add.php';
