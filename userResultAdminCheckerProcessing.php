<?php

try {
    if (!isset($_SESSION["user"]) || $_SESSION["user"]["permissionIndex"] != 1) {
        header("Location: profile.php");
        exit();
    }

    $user = $_SESSION["user"];

    if (!isset($_GET['id'])) {
        header("Location: profile.php");
        exit();
    }

    $resultFile = "database/usersResults.csv";
    $usersResults = readCvs($resultFile);
    $maxScore = maxScore($usersResults, $permission = $_GET["id"]);
    



    $correctAnswerCount = $uncorrectUserAnswer = $correctPercent = $uncorrectPercent = $date = null; // Ініціалізуємо змінні

    $csvData = readCvs($resultFile);

    foreach ($csvData as $row) {
        if ($row[0] == $_GET['id']) {
            $correctAnswerCount = $row[1];
            $uncorrectUserAnswer = $row[2];
            $correctPercent = $row[3];
            $uncorrectPercent = $row[4];
            $date = $row[5];
            $errorForeach = false;
            break;
        }
    }

    if ($correctAnswerCount === null) {
        header("Location: profile.php");
        exit();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}
