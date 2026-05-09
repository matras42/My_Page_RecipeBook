<?php require_once __DIR__ . '/include/functions.php'; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кулінарна книга</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<header class="top">
    <div class="wrap nav">
        <a class="logo" href="index.php">Кулінарна книга</a>
        <input class="nav-toggle" type="checkbox" id="nav-toggle" aria-hidden="true">
        <label class="nav-burger" for="nav-toggle" aria-label="Відкрити меню">
            <span></span>
            <span></span>
            <span></span>
        </label>
        <nav class="menu">
            <a href="index.php">Головна</a>
            <a href="category.php?name=Українська кухня">Українська кухня</a>
            <a href="category.php?name=Десерти">Десерти</a>
            <a href="login/index.php">Адмін</a>
        </nav>
    </div>
</header>
<main>