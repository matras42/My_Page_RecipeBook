<?php
require_once __DIR__ . '/_guard.php';
$id = save_recipe(recipe_from_post());
header('Location: ../recipe.php?id=' . $id);
?>
