<?php
require_once ('../models/user.php');
$user = new User();

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$firstname = $_POST['firstname'] ?? '';
$verified = $_POST['verified'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

$dataStore = [
    'username' => $username,
    'email' => $email, 
    'lastname' => $lastname, 
    'firstname' => $firstname, 
    'verified' => $verified, 
    'password' => password_hash($password, PASSWORD_DEFAULT),
    'role' => $role
];

$store = $user->store($dataStore);

if($store){
    header("Location: list.php");
    exit;
}else {
    header("Location: create.php");
}