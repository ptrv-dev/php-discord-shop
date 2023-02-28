<?php
session_start();
if (!$_SESSION['auth']) return header('Location: /admin/login.php');

require_once('../vendor/db.php');

$search = trim(htmlspecialchars($_GET['search']));
$display = intval(trim(htmlspecialchars($_GET['display'])));
!$display ? $display = 20 : $display = $display;
$page = intval(trim(htmlspecialchars($_GET['page'])));
!$page ? $page = 1 : $page = $page;

$products_count = $pdo->query("SELECT COUNT(*) FROM `products`")->fetch()[0];
$pages_count = ceil($products_count / $display);
$offset = $pages_count ? ($pages_count - 1) * $display : 0;

$products = $pdo->query("SELECT * FROM `products` WHERE `title` LIKE '%{$search}%' ORDER BY `id` DESC LIMIT $display OFFSET $offset");
if ($products) {
    $products = $products->fetchAll(PDO::FETCH_ASSOC);
} else {
    $products = [];
}

$categories = $pdo->query("SELECT * FROM `categories`");
$sorted_categories = [];
if ($categories) {
    $categories = $categories->fetchAll(PDO::FETCH_ASSOC);
    foreach ($categories as $category) {
        $sorted_categories[intval($category['id'])] = $category;
    }
} else {
    $categories = [];
}
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
                <a class="btn" href="/admin/create_product">Создать новый товар</a>
                <form method="get" class="products-header__form">
                    <input class="input" type="text" placeholder="Поиск..." name="search" id="search" value="<?= $search ?>">
                    <span>
                        <label for="display">Отображать по:</label>
                        <select name="display" id="display" class="select" onchange="this.form.submit()">
                            <option <?php if ($display === 10) echo 'selected'; ?> value="10">10</option>
                            <option <?php if ($display === 20) echo 'selected'; ?> value="20">20</option>
                            <option <?php if ($display === 50) echo 'selected'; ?> value="50">50</option>
                        </select>
                    </span>
                </form>
            </div>
            <div class="products-table-wrapper">
                <table class="products-table table">
                    <thead>
                        <th style="width: 2rem;">ID</th>
                        <th>Дата создания</th>
                        <th>Заголовок</th>
                        <th>Описание</th>
                        <th>Категория</th>
                        <th style="width: 6rem;">Кол-во</th>
                        <th style="width: 6rem;">Мин. пок.</th>
                        <th style="width: 6rem;">Цена</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($products as $product) {
                            $product_category = $sorted_categories[intval($product['category_id'])] ? $sorted_categories[intval($product['category_id'])]['title'] : 'Ошибка';
                            $product_count = $pdo->query("SELECT COUNT(`id`) FROM `products_data` WHERE `product_id` = '{$product['id']}'")->fetch(PDO::FETCH_NUM)[0];

                        ?>
                            <tr onclick="window.location.href = '<?= "/admin/edit_product.php?id={$product['id']}" ?>'">
                                <td title="<?= $product['id'] ?>"><?= $product['id'] ?></td>
                                <td title="<?= $product['created_at'] ?>"><?= $product['created_at'] ?></td>
                                <td title="<?= $product['title'] ?>"><?= substr($product['title'], 0, 60) ?>...</td>
                                <td title="<?= $product['description'] ?>"><?= substr($product['description'], 0, 60) ?>...</td>
                                <td title="<?= $product_category ?>"><?= $product_category ?></td>
                                <td title="<?= $product_count ?>"><?= $product_count ?></td>
                                <td title="<?= $product['min_buy'] ?>"><?= $product['min_buy'] ?></td>
                                <td title="<?= $product['price'] ?>"><?= $product['price'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="pagination">
                <?php for ($i = 1; $i <= $pages_count; $i++) { ?>
                    <a href="/admin/?<?= http_build_query(['search' => $search, 'display' => $display, 'page' => $i]) ?>" class="pagination__item <?php if ($i === $page) echo 'pagination__item_active' ?>"><?= $i ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>