<?php
session_start();
if (!$_SESSION['auth']) return header('Location: /admin/login.php');

require_once('../vendor/db.php');

$id = trim(htmlspecialchars($_GET['id']));

$pdo->query("DELETE FROM `products` WHERE `id` = '$id'");
$pdo->query("DELETE FROM `products_data` WHERE `product_id` = '$id'");

header('Location: /admin');
