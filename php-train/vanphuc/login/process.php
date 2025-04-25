<?php
require_once '../models/login.php';
session_start();
$login = new Login();
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$dataLogin = [
    'username' => $username,
    'password' => $password,
];

$logins = $login->Authentication($username, $password);
if ($logins) {
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
