<?php
session_start();
$unique_id = $_SESSION['unique_id'];

if (!$unique_id) return header('Location: /');

require_once('../vendor/db.php');

$order = $pdo->query("SELECT * FROM `orders` WHERE `unique_id` = '$unique_id'")->fetch(PDO::FETCH_ASSOC);

if (intval($order['status']) === 0) {
    echo "<h1>GOOD</h1>";
    $order_data = $pdo->query("SELECT * FROM `products_data` WHERE `product_id` = '{$order['product_id']}' LIMIT {$order['quantity']}")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($order_data as $order_row) {
        $pdo->query("INSERT INTO `orders_data` (`order_id`,`data`) VALUES ('{$order['id']}','{$order_row['data']}')");
        $pdo->query("DELETE FROM `products_data` WHERE `id` = '{$order_row['id']}'");
    }
    $pdo->query("UPDATE `orders` SET `status`='1' WHERE `id` = '{$order['id']}'");
} else {
    $order_data = $pdo->query("SELECT * FROM `orders_data` WHERE `order_id` = '{$order['id']}'")->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_GET['download'])) {
    $path = $_SERVER['DOCUMENT_ROOT'] . '/tmp/order.txt';
    $file = fopen($path, 'w');
    foreach ($order_data as $row) {
        fwrite($file, $row['data']);
    }
    fclose($file);

    $file_name = $unique_id . '.txt';

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $file_name);
    readfile($path);
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order completed</title>
</head>

<body>
    <h1>Order completed :)</h1>
    <a href="/order/complete.php?download" target="_blank">Download order</a>
</body>

</html>