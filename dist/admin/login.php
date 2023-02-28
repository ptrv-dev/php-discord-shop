<?php
$ADMIN_LOGIN = 'root';
$ADMIN_PASS = 'rNDjte2#6V9E';

$message = '';

session_start();
if ($_SESSION['auth']) return header('Location: /admin/');

if (!empty($_POST)) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    if ($username !== $ADMIN_LOGIN || $password !== $ADMIN_PASS) {
        $message = 'Некорректные данные для входа!';
    } else {
        $_SESSION['auth'] = true;
        return header('Location: /admin/');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация | Discord-Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.min.css">
</head>

<body>
    <div class="login">
        <div class="container login__container">
            <form method="POST" class="login__form">
                <h3>Авторизация</h3>
                <label for="username">Имя пользователя</label>
                <div class="login__field">
                    <svg width="24" height="24" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.75 6.5C15.75 7.49456 15.3549 8.44839 14.6516 9.15165C13.9484 9.85491 12.9945 10.25 12 10.25C11.0054 10.25 10.0516 9.85491 9.34833 9.15165C8.64506 8.44839 8.24998 7.49456 8.24998 6.5C8.24998 5.50544 8.64506 4.55161 9.34833 3.84835C10.0516 3.14509 11.0054 2.75 12 2.75C12.9945 2.75 13.9484 3.14509 14.6516 3.84835C15.3549 4.55161 15.75 5.50544 15.75 6.5ZM4.50098 20.618C4.53311 18.6504 5.33731 16.7742 6.74015 15.394C8.14299 14.0139 10.0321 13.2405 12 13.2405C13.9679 13.2405 15.857 14.0139 17.2598 15.394C18.6626 16.7742 19.4668 18.6504 19.499 20.618C17.1464 21.6968 14.5881 22.2535 12 22.25C9.32398 22.25 6.78398 21.666 4.50098 20.618Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <input type="text" placeholder="username" id="username" name="username" minlength="4" required>
                </div>
                <label for="password">Пароль</label>
                <div class="login__field">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.5 11V7.25C16.5 6.05653 16.0259 4.91193 15.182 4.06802C14.3381 3.22411 13.1935 2.75 12 2.75C10.8065 2.75 9.66193 3.22411 8.81802 4.06802C7.97411 4.91193 7.5 6.05653 7.5 7.25V11M6.75 22.25H17.25C17.8467 22.25 18.419 22.0129 18.841 21.591C19.2629 21.169 19.5 20.5967 19.5 20V13.25C19.5 12.6533 19.2629 12.081 18.841 11.659C18.419 11.2371 17.8467 11 17.25 11H6.75C6.15326 11 5.58097 11.2371 5.15901 11.659C4.73705 12.081 4.5 12.6533 4.5 13.25V20C4.5 20.5967 4.73705 21.169 5.15901 21.591C5.58097 22.0129 6.15326 22.25 6.75 22.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <input type="password" placeholder="••••••••" id="password" name="password" minlength="4" required>
                </div>
                <?php if ($message) echo "<p class=\"login__alert\">$message</p>"; ?>
                <button type="submit" class="btn login__btn">Войти</button>
            </form>
        </div>
    </div>
</body>

</html>