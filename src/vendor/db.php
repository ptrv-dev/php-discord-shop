<?php

$MYSQL_HOST = 'localhost';
$MYSQL_DB = 'discord-shop';

$MYSQL_USER = 'root';
$MYSQL_PASS = '';

$pdo = new PDO("mysql:host=$MYSQL_HOST;dbname=$MYSQL_DB", $MYSQL_USER, $MYSQL_PASS);
