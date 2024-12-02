<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$user_email_or_phone = $_SESSION['user']['email'] ?? $_SESSION['user']['phone'];
$file_path = 'accounts.json';

if (file_exists($file_path)) {
    $file_content = file_get_contents($file_path);
    $accounts = json_decode($file_content, true);
} else {
    echo "File not found.";
    $accounts = [];
}

foreach ($accounts as $i => $account) {
    if ($account["username"] === $_SESSION['user']['username']) {
        unset($accounts[$i]);
        break; 
    }
}

file_put_contents($file_path, $accounts);

session_destroy();

header("Location: index.php");
exit();
?>
