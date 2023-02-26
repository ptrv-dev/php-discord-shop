<?php
session_start();
if (!$_SESSION['auth']) return header('Location: /admin/login.php');

require_once('../vendor/db.php');

$id = trim(htmlspecialchars($_GET['id']));

echo $id;
