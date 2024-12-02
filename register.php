<?php
$file = 'database/users.csv';
session_start();

if ($_POST) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];



    if (empty($email) && empty($phone)) {
        $error = "Будь ласка, введіть або телефон, або email!";
    } else if (!empty($email) && !preg_match('/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,6}$/', $email)) {
        $error = "Неправильний формат email!";
    } else if (!empty($phone) && !preg_match('/^\+?\d{10,15}$/', $phone)) {
        $error = "Неправильний формат номера телефону!";
    } else if ($password !== $confirm_password) {
        $error = "Паролі не співпадають!";
    } else {
        $confirm_password = false;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
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
                    "permissionIndex" => $data[5],
                    "registrationDate" => $data[6],
                    "completedTest" => $data[7],

                ];
            }
            fclose($csvFile);
        }

        $userExists = false;
        foreach ($users as $user) {
            if (($user['email'] === $email && $email !== '') || ($user['phone'] === $phone && $phone !== '')) {
                $userExists = true;
                break;
            }
        }

        if ($userExists) {
            $error = "Користувач з таким email або телефоном вже існує!";
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
                    $error = "Файл завеликий. Максимальний розмір — 4 МБ.";
                } elseif ($fileType !== 'image/jpeg' && $fileType !== 'image/png') {
                    $error = "Файл має бути у форматі .jpg або .png.";
                } elseif ($imageInfo[0] !== 512 || $imageInfo[1] !== 512) {
                    $error = "Розмір фото має бути 512x512 пікселів.";
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
                        // $error = "Не вдалося завантажити файл.";
                    }
                    echo $error;
                }
            } else {
                $avatarkaExist = null;
            }
            if (isset($avatarkaExist) || $avatarkaExist == null) {
                $csvFile = fopen($file, 'a');
                fputcsv($csvFile, $newUser);
                fclose($csvFile);



                header("Location: index.php");
                exit();
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>Реєстрація</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/loginisation.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/wrapper430.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper borderWrapper">
        <h1 class="title">Реєстрація</h1>
        <form class="form" action="register.php" method="post" enctype="multipart/form-data">
            <div class="form-field">
                <input type="text" name="username" id="username" required>
                <label for="username" class="label">Юзернейм</label>
            </div>
            <div class="form-field">
                <input type="email" name="email" id="email">
                <label for="email" class="label">Email</label>
            </div>
            <div class="form-field">
                <input type="text" name="phone" id="phone">
                <label for="phone" class="label">Телефон</label>
            </div>
            <div class="form-field password">
                <div>
                    <input type="password" name="password" id="password" required>
                    <label for="password" class="label">Пароль</label>
                </div>
                <div>
                    <input type="button" id="oko" onclick="togglePasswordVisibility('password', 'confirm_password')">
                </div>
            </div>
            <div class="form-field">
                <input type="password" name="confirm_password" id="confirm_password" required>
                <label for="confirm_password" class="label">Повторіть пароль</label>
            </div>
            <div class="form-field">
                <input type="file" name="ava" id="ava" value="Виберіть аватарку">
            </div>
            <div class="form-field">
                <button type="submit" class="btn whiteText btn-submit">Зареєструватись</button>
            </div>
            <?php if (isset($error)) { ?>
                <p class="error"><?= $error ?></p>
            <?php } ?>
        </form>
        <div class="hyperlinks">
            <a href="index.php">Вхід</a>
        </div>
    </div>
    <script src="js/scripts.js"></script>
    <script src="js/loginisation.js"></script>
    <script src="js/theme.js"></script>
</body>

</html>