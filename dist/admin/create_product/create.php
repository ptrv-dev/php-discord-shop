<?php
session_start();
if (!$_SESSION['auth']) return header('Location: /admin/login.php');

require_once('../../vendor/db.php');

$title = trim(htmlspecialchars($_POST['title']));
$description = trim(htmlspecialchars($_POST['description']));
$category = trim(htmlspecialchars($_POST['category']));
$price = trim(htmlspecialchars($_POST['price']));
$min_buy = trim(htmlspecialchars($_POST['min_buy']));
$file = file($_FILES['file']['tmp_name']);


$pdo->query("INSERT INTO `products` (`title`, `description`, `category_id`, `min_buy`, `price`) VALUES ('$title','$description','$category','$min_buy','$price')");
$id = $pdo->lastInsertId();
$pdo->query("UPDATE `categories` SET `count`=count + 1 WHERE `id` = '$category'");

foreach ($file as $row) {
    $pdo->query("INSERT INTO `products_data` (`product_id`, `data`) VALUES ('$id', '$row')");
}

header('Location: /admin');
