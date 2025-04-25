<?php
require_once '../models/user.php';
$user = new user();
$indexDelete = $_GET['id'];

$isDelete = $user->delete($indexDelete);

if($isDelete){
    header("Location: list.php");
    exit;
}