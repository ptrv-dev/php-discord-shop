<?php

require_once('./vendor/db.php');

$id = trim(htmlspecialchars($_GET['id']));

$product = $pdo->query("SELECT * FROM `products` WHERE `id`='$id'")->fetch(PDO::FETCH_ASSOC);
$product_count = $pdo->query("SELECT COUNT(`id`) FROM `products_data` WHERE `product_id` = '{$product['id']}'")->fetch(PDO::FETCH_NUM)[0];

if (!$product) {
    header('HTTP/1.0 404 Not Found');
    die;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discrod-Shop &mdash; The best place to buy discord accounts</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/main.min.css">
</head>

<body>
    <div class="wrapper">
        <?php require_once('./includes/navbar.php') ?>
        <div class="product">
            <div class="container product__container">
                <div class="product-body">
                    <h4><?= $product['title'] ?></h4>
                    <hr>
                    <p><?= $product['description'] ?></p>
                </div>
                <div class="product-details">
                    <h4>Product info</h4>
                    <div class="product-details__row">
                        <div class="product-details__item">
                            Minimal order:
                            <strong><?= $product['min_buy'] ?></strong>
                        </div>
                        <div class="product-details__item">
                            In stock:
                            <strong><?= $product_count ?></strong>
                        </div>
                    </div>
                    <div class="product-details__item">
                        Price per piece:
                        <strong><?= $product['price'] ?> $</strong>
                    </div>
                    <a href="/order?id=<?= $product['id'] ?>" class="btn">Buy <svg width="24" height="24" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.7502 11V6.5C15.7502 5.50544 15.3551 4.55161 14.6519 3.84835C13.9486 3.14509 12.9948 2.75 12.0002 2.75C11.0057 2.75 10.0518 3.14509 9.34858 3.84835C8.64532 4.55161 8.25023 5.50544 8.25023 6.5V11M19.6062 9.007L20.8692 21.007C20.9392 21.672 20.4192 22.25 19.7502 22.25H4.25023C4.09244 22.2502 3.93637 22.2171 3.79218 22.1531C3.64798 22.089 3.51888 21.9953 3.41325 21.8781C3.30763 21.7608 3.22784 21.6227 3.17908 21.4726C3.13032 21.3226 3.11368 21.1639 3.13023 21.007L4.39423 9.007C4.42339 8.73056 4.55385 8.4747 4.76048 8.28876C4.96711 8.10281 5.23526 7.99995 5.51323 8H18.4872C19.0632 8 19.5462 8.435 19.6062 9.007ZM8.62523 11C8.62523 11.0995 8.58572 11.1948 8.51539 11.2652C8.44507 11.3355 8.34969 11.375 8.25023 11.375C8.15077 11.375 8.05539 11.3355 7.98506 11.2652C7.91474 11.1948 7.87523 11.0995 7.87523 11C7.87523 10.9005 7.91474 10.8052 7.98506 10.7348C8.05539 10.6645 8.15077 10.625 8.25023 10.625C8.34969 10.625 8.44507 10.6645 8.51539 10.7348C8.58572 10.8052 8.62523 10.9005 8.62523 11ZM16.1252 11C16.1252 11.0995 16.0857 11.1948 16.0154 11.2652C15.9451 11.3355 15.8497 11.375 15.7502 11.375C15.6508 11.375 15.5554 11.3355 15.4851 11.2652C15.4147 11.1948 15.3752 11.0995 15.3752 11C15.3752 10.9005 15.4147 10.8052 15.4851 10.7348C15.5554 10.6645 15.6508 10.625 15.7502 10.625C15.8497 10.625 15.9451 10.6645 16.0154 10.7348C16.0857 10.8052 16.1252 10.9005 16.1252 11Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </div>
    <script src="./js/app.min.js"></script>
</body>

</html>