<?php
session_start();
if (!$_SESSION['auth']) return header('Location: /admin/login.php');

$search = trim(htmlspecialchars($_GET['search']));
$display = trim(htmlspecialchars($_GET['display']));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Товары | Панель администратора | Discord-Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin.min.css">
</head>

<body>
    <?php require_once('../includes/admin/navbar.php') ?>
    <div class="products">
        <div class="container products__container">
            <div class="products-header">
                <h2>Товары</h2>
                <a class="btn" href="/admin/create_product.php">Создать новый товар</a>
                <form method="get" class="products-header__form">
                    <input class="input" type="text" placeholder="Поиск..." name="search" id="search" value="<?= $search ?>">
                    <span>
                        <label for="display">Отображать по:</label>
                        <select name="display" id="display" class="select" onchange="this.form.submit()">
                            <option <?php if ($display === '10') echo 'selected'; ?> value="10">10</option>
                            <option <?php if ($display === '20') echo 'selected'; ?> value="20">20</option>
                            <option <?php if ($display === '50') echo 'selected'; ?> value="50">50</option>
                        </select>
                    </span>
                </form>
            </div>
        </div>
    </div>
</body>

</html>