<?php
session_start();
if (!$_SESSION['auth']) return header('Location: /admin/login.php');

require_once('../../vendor/db.php');

$categories = $pdo->query("SELECT * FROM `categories`");
$categories = $categories->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать новый товар | Панель администратора | Discord-Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/admin.min.css">
</head>

<body>
    <?php require_once('../../includes/admin/navbar.php') ?>
    <div class="product-create">
        <div class="container product-create__container">
            <h3>Создание нового товара</h3>
            <form action="/admin/create_product/create.php" method="POST" class="product-create__form" enctype="multipart/form-data">
                <input type="text" class="input" placeholder="Заголовок..." name="title" required>
                <textarea name="description" rows="10" class="input" placeholder="Описание..." required></textarea>
                <select class="input" name="category" required>
                    <option disabled>Выберите категорию:</option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                    <?php } ?>
                </select>
                <div class="row">
                    <input type="text" class="input" placeholder="Цена..." name="price" required>
                    <input type="text" class="input" placeholder="Мин. кол-во для покупки" name="min_buy" required>
                </div>
                <input type="file" name="file" accept="text/plain" required>
                <button type="submit" class="btn">Далее</button>
            </form>
        </div>
    </div>

</body>

</html>