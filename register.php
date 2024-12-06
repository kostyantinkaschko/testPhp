<?php
require_once "registerProcessing.php";
session_start();
?>


<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>Реєстрація</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/loginisation.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/wrapper430.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper borderWrapper">
        <h1 class="title">Реєстрація</h1>
        <form class="form" action="register.php" method="post" enctype="multipart/form-data">
            <div class="form-field">
                <input type="text" name="username" id="username">
                <label for="username" class="label">Юзернейм</label>
            </div>
            <div class="form-field">
                <input type="email" name="email" id="email">
                <label for="email" class="label">Email</label>
            </div>
            <div class="form-field">
                <input type="text" name="phone" id="phone">
                <label for="phone" class="label">Телефон</label>
            </div>
            <div class="form-field password">
                <div>
                    <input type="password" name="password" id="password">
                    <label for="password" class="label">Пароль</label>
                </div>
                <div>
                    <input type="button" id="oko" onclick="togglePasswordVisibility('password', 'confirm_password')">
                </div>
            </div>
            <div class="form-field">
                <input type="password" name="confirm_password" id="confirm_password">
                <label for="confirm_password" class="label">Повторіть пароль</label>
            </div>
            <div class="form-field">
                <input type="file" name="ava" id="ava" value="Виберіть аватарку">
            </div>
            <div class="form-field">
                <button type="submit" class="btn whiteText btn-submit">Зареєструватись</button>
            </div>
            <?php if (isset($error)) { ?>
                <p class="error"><?= $error ?></p>
            <?php } ?>
        </form>
        <div class="hyperlinks">
            <a href="index.php">Вхід</a>
        </div>
    </div>
    <script src="js/scripts.js"></script>
    <script src="js/loginisation.js"></script>
    <script src="js/theme.js"></script>
</body>

</html>