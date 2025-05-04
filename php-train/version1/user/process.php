<?php
require_once '../models/user.php';
session_start();
$user = new User();

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$verified = $_POST['verified'] ?? '';
$password = $_POST['password'] ?? '';

$dataStore = [
    'username' => $username,
    'email' => $email,
    'lastname' => $lastname,
    'firstname' => $firstname,
    'verified' => $verified,
    'password' => password_hash($password, PASSWORD_DEFAULT),
];
$dataUser = $user->store($dataStore);

if($dataUser){
    header("Location: list.php");
    exit;
}else {
    header("Location: create.php");
}

