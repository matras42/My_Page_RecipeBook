<?php require_once __DIR__ . '/../include/functions.php'; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body class="login-page">
<form class="login-box" action="check-login.php" method="post">
    <h1>Вхід адміністратора</h1>
    <input type="text" name="login" placeholder="Логін" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Увійти</button>
    <a href="../index.php">Повернутися на сайт</a>
</form>
</body>
</html>
