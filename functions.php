<?php
function readCvs($fileName, $mode = "r")
{
    $data = [];
    if (file_exists($fileName)) {
        $cvsFile = fopen($fileName, $mode);
        while (($row = fgetcsv($cvsFile)) !== false) {
            $data[] = $row;
        }
        fclose($cvsFile);
    } else {
        throw new Exception("Помилка читання файлу");
    }
    return $data;
}

function writeCvs($fileName, $data, $mode = "a")
{
    $result = false;
    try {
        if (file_exists($fileName)) {
            $cvsFile = fopen($fileName, $mode);
            fputcsv($cvsFile, $data);
            fclose($cvsFile);
            $result = true;
        } else {
            throw new Exception("Помилка запису файлу");
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        return $error;
    }
    return $result;
}

function getUsers($file = "database/users.csv")
{
    $users = [];
    $csvFile = readCvs($file);
    foreach ($csvFile as $data) {
        $users[] = [
            'id' => $data[0],
            'username' => $data[1],
            'email' => $data[2],
            'phone' => $data[3],
            'password' => $data[4],
            'permissionIndex' => $data[5],
            'registrationDate' => $data[6],
            'completedTest' => $data[7],
        ];
    }
    return $users;
}


function maxScore($usersResults, $permission = null)
{
    if ($permission === null) {
        $permission = $_SESSION["user"]["id"];
    }
    $maxScore = 0;
    foreach ($usersResults as $result) {
        if ($result[7] > $maxScore) {
            $maxScore = $result[7];
        }
    }
    return $maxScore;
}
