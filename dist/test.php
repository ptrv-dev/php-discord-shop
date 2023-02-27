<?php

require_once('./vendor/db.php');

$p = $pdo->prepare("SELECT * FROM `products` WHERE `id` = :id");
$p->execute(['id' => '24']);
$p = $p->fetchAll();
var_dump($p);
