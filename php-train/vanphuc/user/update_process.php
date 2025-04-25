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
    'password' => $_POST['password'],
];

$idUpdate = $user->update($indexUpdate, $dataUpdate);



if($idUpdate){
    header('Location: list.php');
    exit;
}else {
    header('Location: Update.php');
}

