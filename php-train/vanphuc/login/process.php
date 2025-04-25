<?php
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$dataLogin = [
    'username' => $username,
    'password' => $password,
];

$filepath = '../data/user/user.txt';
if (!file_exists($filepath)) {
    die("File không tồn tại: $filepath");
}

$lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$found = false;

foreach ($lines as $line) {
    list($user, $email, $lastname, $firstname, $pass) = explode(',', trim($line));

    if ($user === $username && $pass === $password) {
        $_SESSION['user_info'] = [
            'username' => $user,
            'email' => $email,
            'fullname' => $firstname . ' ' . $lastname
        ];
        $found = true;
        break;
    }
}

if ($found) {
    header("Location: ../employee/list.php");
    exit;
} else {
    $_SESSION['errors'] = [
        'error_username' => 'Sai tên đăng nhập hoặc mật khẩu!',
    ];
    $_SESSION['old_input'] = $dataLogin;
    header("Location: login.php");
    exit;
}
