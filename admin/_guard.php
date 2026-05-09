<?php
require_once __DIR__ . '/../include/functions.php';
if (!is_admin()) {
    header('Location: ../login/index.php');
    exit;
}
?>
