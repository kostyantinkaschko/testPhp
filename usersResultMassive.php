<?php
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
        if ($result[0] === $_SESSION["user"]["id"] && $result[7] > $maxScore) {
            $maxScore = $result[7]; 
        }
    }
