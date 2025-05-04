<?php
session_start();
require_once '../models/Authentication.php';
$authentication = new Authentication();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$dataLogin = [
    'username' => $username,
    'password' => $password,
];

$isAuthenticated = $authentication->login($username, $password);


if ($isAuthenticated) {
    header("Location: ../employee/create.php");
} else {
    header("Location: login.php");
}