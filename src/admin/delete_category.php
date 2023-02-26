<?php
session_start();
if (!$_SESSION['auth']) return header('Location: /admin/login.php');

require_once('../vendor/db.php');

$id = trim(htmlspecialchars($_GET['id']));

$pdo->query("DELETE FROM `categories` WHERE `id` = '$id'");
$pdo->query("UPDATE `products` SET `category_id`='0' WHERE `category_id`='$id'");

header('Location: /admin/categories.php');
