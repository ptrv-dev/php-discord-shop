<?php
$navigation_items = [
    [
        "text" => "Товары",
        "url" => "/admin",
    ],
    [
        "text" => "Категории",
        "url" => "/admin/categories.php",
    ],
];
?>
<div class="header">
    <div class="container header__container">
        <a href="/admin" class="header__logo">
            <img src="../../img/logo.svg" alt="Logo">
            Discord Shop
        </a>
        <nav class="header__nav nav">
            <ul class="nav__list">
                <?php
                foreach ($navigation_items as $item) { ?>
                    <li class="nav__item">
                        <a href="<?= $item['url'] ?>" class="nav__link"><?= $item['text'] ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>