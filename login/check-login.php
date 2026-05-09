<?php
require_once __DIR__ . '/../include/functions.php';
$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';
if ($login === 'admin' && $password === 'VadymRECIPEBOOK') {
    $_SESSION['admin'] = true;
    header('Location: ../admin/index.php');
    exit;
}
header('Location: index.php');
?>
