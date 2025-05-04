<?php
require_once '../models/user.php';
session_start();
$user = new User();
$idIndex = $_GET['id'] ?? '';

$errors = [
    'username' => $_SESSION['errors']['error_username'] ?? '',
    'email' => $_SESSION['errors']['error_email'] ?? '',
    'firstname' => $_SESSION['errors']['error_firstname'] ?? '',
    'password' => $_SESSION['errors']['error_password'] ?? '',
   ];
unset(
    $_SESSION['errors']
);
   function displayErrors($field, $errors){
       if(!empty($errors[$field])){
           echo "<p class='error'>" . htmlspecialchars($errors[$field]) . "</p>";
       }
   
   }

$users = $user->findRowByIndex($idIndex);
require_once '../views/user/update.php';