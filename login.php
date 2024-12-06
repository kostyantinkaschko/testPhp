<?php
require_once "functions.php";
$file = 'database/users.csv';
$error = '';
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: profile.php");
}



try {
    if (isset($_POST['email_or_phone'])) {
        $email_or_phone = $_POST['email_or_phone'];
        $password = $_POST['password'];

        $users = getUsers($file);


        $userExist = false;

        foreach ($users as $user) {
            if (($user['email'] === $email_or_phone || $user['phone'] === $email_or_phone) && password_verify($password, $user['password'])) {
                $userExist = true;


                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                    'password' => $user["password"],
                    'permissionIndex' => $user['permissionIndex'],
                    'registrationDate' => $user['registrationDate'],
                    'completedTest' => $user['completedTest']
                ];
                header("Location: profile.php");
            }
        }

        if (!$userExist) {
            throw new Exception("Невірні дані для входу!");
        }
    }
} catch (Exception $e) {
    $error = "Сталася помилка: " . $e->getMessage();
}
