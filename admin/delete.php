<?php
require_once __DIR__ . '/_guard.php';
delete_recipe($_GET['id'] ?? 0);
header('Location: index.php');
?>
