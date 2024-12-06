<?php 
session_start();
require "functions.php";
require "userResultAdminCheckerProcessing.php";
?>

<!DOCTYPE html> 
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/wrapper960.css">
    <title>Результати ID <?= $_GET['id'] ?></title>
</head>

<body>
    <div class="wrapper">
        <h1>Результати користувача <?= $_GET["username"]; ?></h1>
        <table border>
            <thead>
                <tr>
                    <td>Id:</td>
                    <td>Всього питання:</td>
                    <td>Правильні відповіді:</td>
                    <td>Неправильні відповіді:</td>
                    <td>Відсоток правильних відповідей:</td>
                    <td>Відсоток неправильних відповідей:</td>
                    <td>Дата проходження тесту:</td>
                    <td>Загальний бал:</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($usersResults as $result) {
                    if ($result[0] === $_GET['id']) {
                        $highlightClass = ($result[7] === $maxScore) ? "highlight" : "";
                ?>
                        <tr class="<?= $highlightClass ?>">
                            <?php foreach ($result as $resultMassive) { ?>
                                <td><?= $resultMassive ?></td>
                            <?php } ?>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>

        <a href="profile.php">Повернутись до профілю.</a>
        
    </div>
    <script src="js/theme.js"></script>
</body>
</html>
