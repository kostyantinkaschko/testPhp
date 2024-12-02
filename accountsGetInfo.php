<?php 

if (!isset($_SESSION["user"]) || $_SESSION["user"]["permissionIndex"] != 1) {
    header("Location: profile.php");
    exit();
}
$file = "database/users.csv";
if (($handle = fopen($file, 'r')) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
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
    fclose($handle);
}



function avatarExist($userId){
    $firstAvatarChecker = file_exists("database/userAvatars/" . $userId . ".png");
    $secondAvatarChecker = file_exists("database/userAvatars/" . $userId . ".jpg");
    if ($firstAvatarChecker ||  $secondAvatarChecker) {
        if ($firstAvatarChecker) {
            return "database/userAvatars/" . $userId . ".png";
        } else if ($secondAvatarChecker) {
            return "database/userAvatars/" . $userId . ".jph";
        } 
    } else {
        return "img/image.png";
    }
}
