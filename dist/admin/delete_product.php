<?php
session_start();
if (!$_SESSION['auth']) return header('Location: /admin/login.php');

require_once('../vendor/db.php');

$id = trim(htmlspecialchars($_GET['id']));

$category_id = $pdo->query("SELECT `category_id` FROM `products` WHERE `id`='$id'")->fetch(PDO::FETCH_ASSOC)['category_id'];

$pdo->query("UPDATE `categories` SET `count` = count - 1 WHERE `id` = '$category_id'");

$pdo->query("DELETE FROM `products` WHERE `id` = '$id'");
$pdo->query("DELETE FROM `products_data` WHERE `product_id` = '$id'");

header('Location: /admin');
