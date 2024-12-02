<?php 

$file = 'database/users.csv';
$error = '';

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: profile.php");
    exit();
}



if ($_POST) {
    $email_or_phone = $_POST['email_or_phone'] ?? '';
    $password = $_POST['password'] ?? '';

    $users = [];
    if (file_exists($file)) {
        $csvFile = fopen($file, 'r');
        while (($data = fgetcsv($csvFile)) !== false) {
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
        fclose($csvFile);
    }

    $userFound = false;

    foreach ($users as $user) {
        if (($user['email'] === $email_or_phone || $user['phone'] === $email_or_phone) && password_verify($password, $user['password'])) {
            $userFound = true;

            session_regenerate_id(true);

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
            exit();
        }
    }

    if (!$userFound) {
        $error = "Невірні дані для входу!";
    }
}