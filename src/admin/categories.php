<?php
session_start();
if (!$_SESSION['auth']) return header('Location: /admin/login.php');

require_once('../vendor/db.php');

$categories = $pdo->query("SELECT * FROM `categories`");
if ($categories) {
    $categories = $categories->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Категории | Панель администратора | Discord-Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin.min.css">
</head>

<body>
    <?php require_once('../includes/admin/navbar.php') ?>
    <div class="categories">
        <div class="container categories__container">
            <div class="categories__header">
                <h2>Категории</h2>
                <a href="/admin/create_category.php" class="btn">Создать новую категорию</a>
            </div>
            <div class="categories__table">
                <table class="table">
                    <thead>
                        <th style="width: 4rem;">ID</th>
                        <th>Дата создания</th>
                        <th>Заголовок</th>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) { ?>
                            <tr onclick="window.location.href = '<?= "/admin/edit_category.php?id={$category['id']}" ?>'">
                                <td><?= $category['id'] ?></td>
                                <td><?= $category['created_at'] ?></td>
                                <td><?= $category['title'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>