<?php
session_start();
// require_once "functions.php";

$resultFile = "database/usersResults.csv";
$usersFile = "database/users.csv";
$questions = $_SESSION["questions"];
$userAnswer = $_POST["userAnswer"] ?? [];
$user = $_SESSION["user"];
$correctAnswerCount = 0;

foreach ($questions as $i => $question) {
    if ($question["QuestionType"] === 0) {
        if (isset($userAnswer[$i]) && $userAnswer[$i] == $question['answer']) {
            $correctAnswerCount++;
        }
    } else if ($question["QuestionType"] === 1) {
        $correctAnswers = $question['answer'];
        $userAnswers = $userAnswer[$i] ?? [];
        $matchedAnswers = array_intersect($userAnswers, $correctAnswers);

        if (count($matchedAnswers) === count($correctAnswers) && count($userAnswers) === count($correctAnswers)) {
            $correctAnswerCount++;
        }
    }
}

$uncorrectUserAnswer = $_SESSION["questionsCount"] - $correctAnswerCount;
$scoreOutOf10 = round(($correctAnswerCount / $_SESSION["questionsCount"]) * 10, 2);
$_SESSION["correctUserAnswer"] = $correctAnswerCount;
$_SESSION["uncorrectUserAnswer"] = $uncorrectUserAnswer;
$_SESSION["correctPercent"] = round(($correctAnswerCount / $_SESSION["questionsCount"]) * 100, 2);
$_SESSION["uncorrectPercent"] = 100 - $_SESSION["correctPercent"];
$_SESSION["userAnswer"] = $userAnswer;
$_SESSION["correctAnswerCount"] = $correctAnswerCount;
$_SESSION["user"]["completedTest"] = true;
$_SESSION["date"] = date("l jS \of F Y h:i:s A");

if($scoreOutOf10 === 0){
    $scoreOutOf10 = 1;
}

if (file_exists($resultFile)) {
    $csvFile = fopen($resultFile, 'a+');
    $userResult = [
        "id" => $_SESSION["user"]["id"],
        "questionsCount" => $_SESSION["questionsCount"],
        "correctAnswerCount" => $_SESSION["correctAnswerCount"],
        "uncorrectUserAnswer" => $_SESSION["uncorrectUserAnswer"],
        "correctPercent" => $_SESSION["correctPercent"],
        "uncorrectPercent" => $_SESSION["uncorrectPercent"],
        "date" => $_SESSION["date"],
        "scoreOutOf10" => $scoreOutOf10
    ];

    fputcsv($csvFile, $userResult);
    fclose($csvFile);
}

$users = [];

if (file_exists($usersFile)) {
    $csvFile = fopen($usersFile, 'r');
    while (($data = fgetcsv($csvFile)) !== false) {
        $users[] = [
            'id' => $data[0],
            'username' => $data[1],
            'email' => $data[2],
            'phone' => $data[3],
            'password' => $data[4],
            "permissionIndex" => $data[5],
            "registrationDate" => $data[6],
            "completedTest" => $data[7],
        ];
    }
    fclose($csvFile);

    $userFound = false;
    foreach ($users as &$existingUser) {
        if ($existingUser['id'] == $user["id"]) {
            $existingUser["completedTest"] = 'true';
            $existingUser["registrationDate"] = $_SESSION["date"];
            $userFound = true;
            break;
        }
    }


    if (!$userFound) {
        $users[] = [
            $user["id"],
            $user["username"],
            $user["email"],
            $user["phone"],
            $user["password"],
            $user["permissionIndex"],
            $_SESSION["date"],
            'true',
        ];
    }

    $csvFile = fopen($usersFile, 'w');
    foreach ($users as $userRow) {
        fputcsv($csvFile, $userRow);
    }
    fclose($csvFile);
}


// echo $_SESSION["questionsCount"];
// foreach($userResult as $result){
//     echo $result . "<br>";
// }
header("Location: result.php");
exit();
