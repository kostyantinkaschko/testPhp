<?php
session_start();
require_once "functions.php";
// echo "<pre>";
// var_dump($_SESSION["user"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>Результати</title>
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/tableStyle.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wrapper">
        <h1>Результати користувача <?= $_SESSION["user"]["username"] ?></h1>
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
                $highlightClass = "";
                foreach ($_SESSION["userResult"] as $result) {
                    if ($result[0] === $_SESSION["user"]["id"]) {
                        // var_dump($_SESSION["maxScore"]);
                        if ($result[7] === $_SESSION["maxScore"]) {
                            $highlightClass = "highlight";
                        } else {
                            $highlightClass = "";
                        }
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
        <script src="js/theme.js"></script>
    </div>
</body>

</html>