<?php
require_once '../models/user.php';
$user = new user();
$indexUpdate = $_POST['index'] ?? '';
$dataUpdate = [
    'username' => $_POST['username'],
    'email' => $_POST['email'],
    'lastname' => $_POST['lastname'],
    'firstname' => $_POST['firstname'],
    'verified' => $_POST['verified'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    'role' => $_POST['role'],
];

$idUpdate = $user->update($indexUpdate, $dataUpdate);



if($idUpdate){
    header('Location: list.php');
    exit;
}else {
    header('Location: Update.php');
}

