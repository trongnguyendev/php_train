<?php
require_once('../models/customer.php');
session_start();
$id = $_POST['indexUpdate'];
$name = $_POST['name'];
$email = $_POST['email'];
$birthday = $_POST['birthday'];
$address = $_POST['address'];
$typecustomer = $_POST['typecustomer'];
$dataUpdate = [
    'name' => $name,
    'email' => $email,
    'birthday' => $birthday,
    'address' => $address,
    'typecustomer' => $typecustomer
];
$datas = new customer();
$datas->updateFile($id,$dataUpdate);
$datas->session($dataUpdate);
header ("Location: list.php");