<?php
session_start();
if (!$_SESSION['auth']) return header('Location: /admin/login.php');

require_once('../vendor/db.php');

$id = trim(htmlspecialchars($_GET['id']));
$product = $pdo->query("SELECT * FROM `products` WHERE `id` = '$id'")->fetch(PDO::FETCH_ASSOC);

$categories = $pdo->query("SELECT * FROM `categories`");
if ($categories) {
    $categories = $categories->fetchAll(PDO::FETCH_ASSOC);
} else {
    $categories = [];
}

if (!empty($_POST)) {
    $title = trim(htmlspecialchars($_POST['title']));
    $description = trim(htmlspecialchars($_POST['description']));
    $category = trim(htmlspecialchars($_POST['category']));
    $price = trim(htmlspecialchars($_POST['price']));
    $min_buy = trim(htmlspecialchars($_POST['min_buy']));

    $pdo->query("UPDATE `products` SET `title`='$title',`description`='$description',`category_id`='$category',`min_buy`='$min_buy',`price`='$price' WHERE `id` = $id");

    if (!empty($_FILES['file']['name'])) {
        $file = file($_FILES['file']['tmp_name']);
        $file_rows = 0;

        foreach ($file as $row) {
            $file_rows++;
            $pdo->query("INSERT INTO `products_data` (`product_id`, `data`) VALUES ('$id','$row')");
        }

        $new_count = $product['count'] + $file_rows;

        $pdo->query("UPDATE `products` SET `count`='$new_count' WHERE `id` = '$id'");
    }
    header('Location: /admin');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование товара | Панель администратора | Discord-Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin.min.css">
</head>

<body>
    <?php require_once('../includes/admin/navbar.php') ?>
    <div class="product-create">
        <div class="container product-create__container">
            <h3>Редактирование товара</h3>
            <form method="POST" class="product-create__form" enctype="multipart/form-data">
                <input type="text" class="input" placeholder="Заголовок..." name="title" required value="<?= $product['title'] ?>">
                <textarea name="description" rows="10" class="input" placeholder="Описание..." required><?= $product['description'] ?></textarea>
                <select class="input" name="category" required>
                    <option disabled>Выберите категорию:</option>
                    <?php foreach ($categories as $category) { ?>
                        <option <?php if ($product['category_id'] === $category['id']) echo 'selected' ?> value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                    <?php } ?>
                </select>
                <div class="row">
                    <input type="text" class="input" placeholder="Цена..." name="price" required value="<?= $product['price'] ?>">
                    <input type="text" class="input" placeholder="Мин. кол-во для покупки" name="min_buy" required value="<?= $product['min_buy'] ?>">
                </div>
                <div>
                    <p>Добавить товар: (оставьте это поле пустым если добавление товара не требуется)</p>
                    <input type="file" name="file" accept="text/plain">
                </div>
                <div class="actions">
                    <button type="submit" class="btn">Сохранить</button>
                    <a class="btn btn_danger" href="/admin/delete.php?id=<?= $id ?>">Удалить</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>