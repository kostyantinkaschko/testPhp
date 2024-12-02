<?php


if (!isset($_SESSION["user"]) || $_SESSION["user"]["permissionIndex"] != 1) {
    header("Location: profile.php");
    exit();
}

$user = $_SESSION["user"];  

if(!isset($_GET['id'])){
   header("Location: profile.php");
   exit();
}

$resultFile = "database/usersResults.csv";
$usersResults = [];
if (file_exists($resultFile)) {
    $csvFile = fopen($resultFile, 'r');
    while (($data = fgetcsv($csvFile)) !== false) {
        $usersResults[] = $data;
    }
    fclose($csvFile);
}

$maxScore = 0;
foreach ($usersResults as $result) {
    if ($result[0] === $_GET["id"] && $result[7] > $maxScore) {
        $maxScore = $result[7]; 
    }
}


$correctAnswerCount = $uncorrectUserAnswer = $correctPercent = $uncorrectPercent = $date = null; // Ініціалізуємо змінні

$csvData = readCvs("database/usersResults.csv");

foreach ($csvData as $row) {    
    if ($row[0] == $_GET['id']) {
        $correctAnswerCount = $row[1];
        $uncorrectUserAnswer = $row[2];
        $correctPercent = $row[3];
        $uncorrectPercent = $row[4];
        $date = $row[5];
        break;
    }
}

if ($correctAnswerCount === null) {
    header("Location: profile.php");
    exit();
}