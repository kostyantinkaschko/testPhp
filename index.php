<?php
session_start();

require_once("login.php");

?>


<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/loginisation.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/wrapper430.css">
    <title>Вхід</title>
</head>

<body>
    <div class="wrapper borderWrapper">
        <div class="form">
            <h2>Вхід</h2>
            <form class="form" method="post" action="index.php">
                <div class="form-field">
                    <input type="text" name="email_or_phone" id="email_or_phone" required>
                    <label for="email_or_phone" class="label">Email або Телефон</label>
                </div>
                <div class="form-field password">
                    <div>
                        <input type="password" name="password" id="password" required>
                        <label for="password" class="label">Пароль</label>
                    </div>
                    <div>
                        <input type="button" id="oko" onclick="togglePasswordVisibility('password')">
                    </div>
                </div>
                <div class="form-field">
                    <button type="submit" class="btn whiteText btn-submit">Увійти</button>
                </div>
                <?php if ($error) { ?>
                    <p><?= $error ?></p>
                <?php } ?>
            </form>

            <div class="hyperlinks">
                <a href="register.php">Реєстрація</a>
            </div>
        </div>
        <button id="themeToggle" class="btn">Змінити тему</button>
    </div>
    <script src="js/loginisation.js"></script>
    <script src="js/theme.js"></script>
</body>

</html>