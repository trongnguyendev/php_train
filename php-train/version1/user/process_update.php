<?php
require_once '../models/user.php';
session_start();
$user = new User();
$idIndex = $_POST['index'] ?? '';

$dataUpdate = [
    'username' => $_POST['username'] ?? '',
    'email' => $_POST['email'] ?? '',
    'lastname' => $_POST['lastname'] ?? '',
    'firstname' => $_POST['firstname'] ?? '',
    'verified' => $_POST['verified'] ?? '',
    'password' => $_POST['password'] ?? '',
];

$users = $user->update($idIndex ,$dataUpdate);
if($users){
    header("Location: list.php");
    exit;
}
