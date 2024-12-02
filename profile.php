<?php 
session_start();
require_once("profileProcessing.php");
?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/wrapper430.css">
    <title>Профіль</title>
</head>

<body>
    <div class="wrapper profile borderWrapper">
        <div class="kvadratoProfile">
            <div class="avatar">
                <?php foreach ($usersAvatars as $avatar) {
                    $avatarPos =  strpos($avatar, ".");
                    $avatarName = substr($avatar, 0, $avatarPos);
                    if ($avatarName == $user["id"]) {
                ?>
                        <img src="database/userAvatars/<?= $avatar ?>" alt="kvadrato">
                    <?php
                        $avaratka = true;
                    }
                }
                if (!isset($avaratka)) { ?>
                    <img src="img/image.png" alt="ne kvadrato">
                <?php } ?>
            </div>
            <div class="info">
                <h2>Профіль:</h2>
                <p>Ім'я користувача: <?= $user['username'] ?></p>
            </div>
        </div>
        <?php if (!preg_match($regularka, $user["email"])) { ?>
            <p>Email: <?= $user['email'] ?></p>
        <?php } else { ?>
            <label for="emailChecker">Email:</label>
            <button id="emailChecker" onclick="showBlock('emailForm', 'emailChecker', 'Закрити форму')">Додати
                email</button>
            <form action="profile.php" method="post" class="form hide emailForm">
                <h2>Додати Email</h2>
                <div class="form-field">
                    <input type="email" class="whiteText" name="email" id="email" placeholder=" " required>
                    <label for="email" class="label">Email</label>
                </div>
                <div class="form-field">
                    <input type="email" class="whiteText" name="emailCheck" id="emailCheck" placeholder=" " required>
                    <label for="emailCheck" class="label">Підтвердіть Email</label>
                </div>
                <div class="form-field">
                    <input type="submit" name="addEmail" value="Send" class="btn blackText btn-submit">
                </div>
            </form>
        <?php } ?>

        <?php if (!preg_match($regularka, $user["phone"])) { ?>
            <p>Телефон: <?= $user['phone'] ?></p>
        <?php } else { ?>
            <label for="phoneChecker">Телефон</label>
            <button id="phoneChecker" onclick="showBlock('phoneForm', 'phoneChecker', 'Закрити форму')">Додати номер
                телефону</button>
            <form action="profile.php" method="post" class="form hide phoneForm">
                <h2>Додати номер телефона</h2>
                <div class="form-field">
                    <input type="text" name="phone" id="phone" required>
                    <label for="phone" class="label">Номер телефона</label>
                </div>
                <div class="form-field">
                    <input type="text" name="phoneCheck" class="whiteText" id="phoneCheck" required>
                    <label for="phoneCheck" class="label">Підтвердь номер телефона</label>
                </div>
                <div class="form-field">
                    <button type="submit" name="addPhone" class="btn whiteText btn-submit">Увійти</button>
                </div>
            </form>
        <?php }  ?>

        <?php if ($error): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>

        <div class="buttons">
            <?php if ($user["permissionIndex"] == 0) { ?>
                <a class="orangeButton" href="test.php">Пройти тестування</a>
                <?php if ($user["completedTest"] !== "null") { var_dump($user["completedTest"]);?>
                    <a class="orangeButton" href="result.php">Мої результати</a>
                <?php }
            }
            if ($user["permissionIndex"] == 1) { ?>
                <a class="orangeButton" href="accounts.php">Зареєстровані користуваі</a>
            <?php } ?>
            <a class="redButton" href="logout.php">Вийти</a>
        </div>
        <button id="themeToggle" class="btn">Змінити тему</button>
    </div>
    <script src="js/theme.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
