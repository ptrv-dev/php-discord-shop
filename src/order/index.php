<?php
session_start();
require_once('../vendor/db.php');

$id = trim(htmlspecialchars($_GET['id']));

$product = $pdo->query("SELECT * FROM `products` WHERE `id`='$id'")->fetch(PDO::FETCH_ASSOC);
$product_count = $pdo->query("SELECT COUNT(`id`) FROM `products_data` WHERE `product_id` = '{$product['id']}'")->fetch(PDO::FETCH_NUM)[0];

if (intval($product_count) < intval($product['min_buy'])) $product['min_buy'] = $product_count;

if (!$product) {
    header('HTTP/1.0 404 Not Found');
    die;
}

if (!empty($_POST)) {
    $api_key = 'pMu9opKQiSHAhjsmQLRCMNziw4LLpi5pw4wJbE6O1hEoEAd1HNi7zIPpDwwRerYt';
    $return_url = 'http://localhost:3000/order/complete.php';

    $email = trim(htmlspecialchars($_POST['email']));
    $quantity = trim(htmlspecialchars($_POST['quantity']));

    $curl = curl_init('https://dev.sellix.io/v1/payments');

    $headers = ['Content-type: application/json', 'Authorization: Bearer ' . $api_key];

    $payload = [
        'title' => $product['title'],
        'email' => $email,
        'currency' => 'USD',
        'quantity' => $quantity,
        'value' => $product['price'],
        'return_url' => $return_url,
    ];

    $curl_array = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => json_encode($payload)
    ];

    curl_setopt_array($curl, $curl_array);

    $response = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($response, true);

    $pdo->query("INSERT INTO `orders` (`unique_id`, `email`, `product_id`, `quantity`, `total_price`) VALUES ('{$response['data']['uniqid']}','$email','{$product['id']}','$quantity','{$response['log']['taxes']['total']}')");

    $_SESSION['unique_id'] = $response['data']['uniqid'];

    return header("Location: {$response['data']['url']}");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make order | Discord-Shop &mdash; The best place to buy discord accounts</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.min.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
</head>

<body>
    <div class="wrapper">
        <?php require_once('../includes/navbar.php') ?>
        <div class="order container order__container">
            <div class="order-warning">
                <svg class="order-warning__icon" width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30.0005 5.00061C16.2155 5.00061 5.00049 16.2206 5.00049 30.0006C5.00049 43.7906 16.2155 55.0006 30.0005 55.0006C43.7855 55.0006 55.0005 43.7906 55.0005 30.0006C55.0005 16.2206 43.7855 5.00061 30.0005 5.00061ZM30.0005 16.8806C30.4109 16.8806 30.8172 16.9614 31.1964 17.1185C31.5755 17.2755 31.92 17.5057 32.2102 17.7959C32.5004 18.0861 32.7306 18.4306 32.8876 18.8097C33.0447 19.1889 33.1255 19.5952 33.1255 20.0056C33.1255 20.416 33.0447 20.8224 32.8876 21.2015C32.7306 21.5806 32.5004 21.9251 32.2102 22.2153C31.92 22.5055 31.5755 22.7357 31.1964 22.8927C30.8172 23.0498 30.4109 23.1306 30.0005 23.1306C29.1717 23.1306 28.3768 22.8014 27.7908 22.2153C27.2047 21.6293 26.8755 20.8344 26.8755 20.0056C26.8755 19.1768 27.2047 18.382 27.7908 17.7959C28.3768 17.2099 29.1717 16.8806 30.0005 16.8806V16.8806ZM37.5005 42.5006H22.5005V37.5006H27.5005V30.0006H25.0005V25.0006H30.0005C30.6635 25.0006 31.2994 25.264 31.7683 25.7328C32.2371 26.2017 32.5005 26.8376 32.5005 27.5006V37.5006H37.5005V42.5006Z" fill="currentColor" />
                </svg>
                <p class="order-warning__text">Please provide a valid email address and your order will be sent to this address</p>
            </div>
            <form method="POST" class="order-form">
                <h3 class="order-form__title">Order</h3>
                <div class="order-form__item order-form__item_dark">
                    Product
                    <strong><?= $product['title'] ?></strong>
                </div>
                <div class="order-form__row">
                    <div class="order-form__item">
                        Minimal order
                        <strong data-minBuy><?= $product['min_buy'] ?></strong>
                    </div>
                    <div class="order-form__item">
                        In stock
                        <strong data-inStock><?= $product_count ?></strong>
                    </div>
                    <div class="order-form__item">
                        Price per piece
                        <strong data-price><?= $product['price'] ?> $</strong>
                    </div>
                </div>
                <hr>
                <label for="email" class="order-form__label">Your Email address <i>*</i></label>
                <div class="order-form__input">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.5 12C16.5 13.1935 16.0259 14.3381 15.182 15.182C14.3381 16.0259 13.1935 16.5 12 16.5C10.8065 16.5 9.66194 16.0259 8.81802 15.182C7.97411 14.3381 7.5 13.1935 7.5 12C7.5 10.8065 7.97411 9.66193 8.81802 8.81802C9.66194 7.9741 10.8065 7.5 12 7.5C13.1935 7.5 14.3381 7.9741 15.182 8.81802C16.0259 9.66193 16.5 10.8065 16.5 12ZM16.5 12C16.5 13.657 17.507 15 18.75 15C19.993 15 21 13.657 21 12C21 9.9178 20.278 7.90003 18.957 6.29048C17.6361 4.68093 15.7979 3.57919 13.7557 3.17299C11.7136 2.76679 9.5937 3.08126 7.75737 4.06282C5.92104 5.04437 4.48187 6.63228 3.68506 8.55599C2.88825 10.4797 2.78311 12.6202 3.38756 14.6127C3.992 16.6052 5.26863 18.3265 6.99992 19.4833C8.73121 20.6401 10.81 21.1608 12.8822 20.9567C14.9544 20.7526 16.8917 19.8363 18.364 18.364M16.5 12V8.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    <input type="email" required placeholder="example@email.com" name="email" id="email">
                </div>
                <label for="quantity" class="order-form__label">Quantity <i>*</i></label>
                <div class="order-form__input order-form__input_p">
                    <input type="number" min="<?= $product['min_buy'] ?>" max="<?= $product_count ?>" required value="<?= $product['min_buy'] ?>" name="quantity" id="quantity">
                </div>
                <div class="order-form__total">
                    Total price <strong>$0.0</strong>
                </div>
                <button type="submit" class="btn">Proceed to pay</button>
            </form>
        </div>
        <?php require_once('../includes/footer.php') ?>
    </div>
    <script src="../js/order.min.js"></script>
    <script src="../js/app.min.js"></script>
</body>

</html>