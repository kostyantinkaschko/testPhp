<?php 
require_once "functions.php";

if (!isset($_SESSION["user"]) || $_SESSION["user"]["permissionIndex"] != 1) {
    header("Location: profile.php");
    exit();
}
// $file = "database/users.csv";
// $users = getUsers($file);


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
