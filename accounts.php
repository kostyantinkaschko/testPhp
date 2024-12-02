<?php
session_start();
require_once("accountsGetInfo.php");
// echo $_SESSION["user"]["permissionIndex"]
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/loginisation.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/tableStyle.css">
    <title>Users</title>
</head>

<body>
    <div class="wrapper">
        <table border>
            <thead>
                <th>Id</th>
                <th>Avatar</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Permission</th>
                <th>Account registration date:</th>
            </thead>
            <tbody>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><img class="avatarExists" src="<?= avatarExist($user["id"]); ?>" alt=""></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['phone'] ?></td>
                        <td><?= $user['permissionIndex'] ?></td>
                        <td><?= $user['registrationDate'] ?></td>
                        <td>
                            <?php if ($user['completedTest'] !== "null"): ?>
                                <a class="resultButton" href="userResultAdminChecker.php?id=<?= $user['id'] ?>&username=<?= $user["username"]?>">Переглянути результати</a>
                            <?php else: ?>
                                <button class="resultButton" disabled>Результати недоступні</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            </tbody>
        </table>
        <a href="profile.php">Назад</a>
        <script src="js/theme.js"></script>
    </div>
</body>

</html>