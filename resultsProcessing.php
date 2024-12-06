<?php
session_start();

$resultFile = "database/usersResults.csv";
$usersFile = "database/users.csv";
require_once "functions.php";
$questions = $_SESSION["questions"];

$userAnswer = $_POST["userAnswer"] ?? [];
$user = $_SESSION["user"];
$correctAnswerCount = 0;
try {
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

    if ($scoreOutOf10 == 0) {
        $scoreOutOf10 = 1;
    }

    $csvFile = fopen($resultFile, "a");
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
    $usersResults = readCvs($resultFile);
    $userResults = [];
    foreach ($usersResults as $result) {
        if ($result[0] == $_SESSION["user"]["id"]) {
            $userResults[] = $result;
        }
    }

    $users = getUsers();
    $userFound = false;
    foreach ($users as &$existingUser) {
        if ($existingUser['id'] == $user["id"]) {
            $existingUser["completedTest"] = 'true';
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

    $csvFile = fopen($usersFile, "w");
    foreach ($users as $userRow) {
        fputcsv($csvFile, $userRow);
    }
    fclose($csvFile);
    $_SESSION["maxScore"] = maxScore($userResults, $_SESSION["user"]["id"]);
    $_SESSION["userResult"] = $userResults;
    // echo $_SESSION["questionsCount"];
    // foreach($userResult as $result){
    //     echo $result . "<br>";
    // }
    header("Location: result.php");
} catch (Exception $e) {
    $error = $e->getMessage();
}
