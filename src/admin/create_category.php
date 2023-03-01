<?php
session_start();
if (!$_SESSION['auth']) return header('Location: /admin/login.php');

require_once('../vendor/db.php');

if (!empty($_POST)) {
    $title = trim(htmlspecialchars($_POST['title']));

    $query = $pdo->prepare("INSERT INTO `categories` (`title`) VALUES (:title)");
    $query->execute(["title" => $title]);

    header('Location: /admin/categories.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование категории | Панель администратора | Discord-Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin.min.css">
</head>

<body>
    <?php require_once('../includes/admin/navbar.php') ?>
    <div class="categories">
        <div class="container categories__container">
            <h2 style="text-align: center;">Создание новой категории</h2>
            <form method="POST" class="categories__form">
                <input type="text" class="input" placeholder="Название категории..." name="title">
                <div class="row">
                    <button type="submit" class="btn">Создать</button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>