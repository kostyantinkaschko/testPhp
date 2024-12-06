<?php
require_once "functions.php";
try {
    if (!empty($_POST['username']) && (!empty($_POST['email']) || !empty($_POST['phone'])) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];



        if (empty($email) && empty($phone)) {
            throw new Exception("Будь ласка, введіть або телефон, або email!");
        } else if (!empty($email) && !preg_match('/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,6}$/', $email)) {
            throw new Exception("Неправильний формат email!");
        } else if (!empty($phone) && !preg_match('/^\+?\d{10,15}$/', $phone)) {
            throw new Exception("Неправильний формат номера телефону!");
        } else if ($password !== $confirm_password) {
            throw new Exception("Паролі не співпадають!");
        } else {
            $confirm_password = false;
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $users = getUsers();

            $userExists = false;
            foreach ($users as $user) {
                if (($user['email'] === $email && $email !== '') || ($user['phone'] === $phone && $phone !== '')) {
                    $userExists = true;
                    break;
                }
            }

            if ($userExists) {
                throw new Exception("Користувач з таким email або телефоном вже існує!");
            } else {
                $avatarkaExist = "da";
                $userId = count($users) > 0 ? $users[count($users) - 1]['id'] + 1 : 1;

                $newUser = [
                    'id' => $userId,
                    'username' => $username,
                    'email' => empty($email) ? "null" . $userId : $email,
                    'phone' => empty($phone) ? "null" . $userId : $phone,
                    'password' => $password,
                    "permissionIndex" => 0,
                    "registrationDate" => date(format: "'l jS \of F Y h:i:s A"),
                    "completedTest" => "null",
                ];

                if (isset($_FILES['ava']) && $_FILES['ava']['error'] === UPLOAD_ERR_OK) {
                    $fileSize = $_FILES['ava']['size'];
                    $imageInfo = getimagesize($_FILES['ava']['tmp_name']);
                    $fileType = $imageInfo['mime'];

                    if ($fileSize > 4 * 1024 * 1024) {
                        throw new Exception("Файл завеликий. Максимальний розмір — 4 МБ.");
                    } else if ($fileType !== 'image/jpeg' && $fileType !== 'image/png') {
                        throw new Exception("Файл має бути у форматі .jpg або .png.");
                    } else if ($imageInfo[0] !== 512 || $imageInfo[1] !== 512) {
                        throw new Exception("Розмір фото має бути 512x512 пікселів.");
                    } else {
                        $uploadDir = __DIR__ . '/database/userAvatars';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }

                        $fileExtension = pathinfo($_FILES['ava']['name'], PATHINFO_EXTENSION);
                        $fileName = $uploadDir . '/' . $newUser['id'] . '.' . $fileExtension;

                        if (move_uploaded_file($_FILES['ava']['tmp_name'], $fileName)) {
                            $_SESSION['fileName'] = $fileName;
                            $_SESSION['fileExist'] = true;
                            $avatarkaExist = true;
                        } else {
                            throw new Exception("Не вдалося завантажити файл.");
                        }
                    }
                } else {
                    $avatarkaExist = null;
                }
                if (isset($avatarkaExist) || $avatarkaExist == null) {
                    writeCvs($file, $newUser, "a");
                    header("Location: index.php");
                    exit();
                }
            }
        }
        
    } else {
        throw new Exception("Не всі поля заповнені.");
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}
