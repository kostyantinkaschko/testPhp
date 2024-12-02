<?php

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$file = 'database/users.csv';
$error = '';
$user = $_SESSION['user'];

$users = [];
if (($handle = fopen($file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $users[] = [
            'id' => $data[0],
            'username' => $data[1],
            'email' => $data[2],
            'phone' => $data[3],
            'password' => $data[4],
            'permissionIndex' => $data[5],
            'registrationDate' => $data[6],
            'completedTest' => $data[7]
        ];
    }
    fclose($handle);
}

function updateUser($users, $user, $file)
{
    foreach ($users as &$u) {
        if ($u['email'] === $user['email']) {
            $u = $user;
            break;
        }
    }

    if (($handle = fopen($file, "w")) !== FALSE) {
        foreach ($users as $u) {
            fputcsv($handle, $u);
        }
        fclose($handle);
    }

    $_SESSION['user'] = $user;
}

if (isset($_POST["addEmail"])) {
    $email = $_POST["email"] ?? '';
    $emailCheck = $_POST["emailCheck"] ?? '';

    if (empty($email)) {
        $error = "Будь ласка, заповніть форму";
    } else if (!preg_match('/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,6}$/', $email)) {
        $error = "Неправильний формат email!";
    } else if ($email !== $emailCheck) {
        $error = "Email'и не збігаються";
    } else {
        $user['email'] = $email;
        updateUser($users, $user, $file);
    }
}

if (isset($_POST["addPhone"])) {
    $phone = $_POST["phone"] ?? '';
    $phoneCheck = $_POST["phoneCheck"] ?? '';

    if (empty($phone)) {
        $error = "Будь ласка, заповніть форму";
    } elseif (!preg_match('/^\+?\d{10,15}$/', $phone)) {
        $error = "Неправильний формат номера телефону!";
    } elseif ($phone !== $phoneCheck) {
        $error = "Номери телефону не збігаються";
    } else {
        $user['phone'] = $phone;
        updateUser($users, $user, $file);
    }
}

$usersAvatars = scandir("database/userAvatars");

$regularka = '/^NULL|^null$/i';