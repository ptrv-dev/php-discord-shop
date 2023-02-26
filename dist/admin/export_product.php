<?php
session_start();
if (!$_SESSION['auth']) return header('Location: /admin/login.php');
require_once('../vendor/db.php');

$id = trim(htmlspecialchars($_GET['id']));
$product_data = $pdo->query("SELECT `data` FROM `products_data` WHERE `product_id`='$id'")->fetchAll(PDO::FETCH_ASSOC);


$path = $_SERVER['DOCUMENT_ROOT'] . '/tmp/tmp.txt';
$file = fopen($path, 'w');
foreach ($product_data as $row) {
    fwrite($file, $row['data']);
}
fclose($file);

$file_name = date('Y-m-d H-i-s') . '.txt';

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $file_name);
readfile($path);
