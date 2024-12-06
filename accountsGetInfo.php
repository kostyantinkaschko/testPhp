<?php 
require_once "functions.php";

if (!isset($_SESSION["user"]) || $_SESSION["user"]["permissionIndex"] != 1) {
    header("Location: profile.php");
    exit();
}
function avatarExist($userId){
    $firstAvatarChecker = file_exists("database/userAvatars/" . $userId . ".png");
    $secondAvatarChecker = file_exists("database/userAvatars/" . $userId . ".jpg");
    $result = null;
    if ($firstAvatarChecker ||  $secondAvatarChecker) {
        if ($firstAvatarChecker) {
            $result = "database/userAvatars/" . $userId . ".png";
        } else if ($secondAvatarChecker) {
            $result = "database/userAvatars/" . $userId . ".jph";
        } 
    } else {
        $result = "img/image.png";
    }
    return $result;
}
