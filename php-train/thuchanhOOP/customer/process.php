<?php
require_once('../models/Customer.php');
$name = $_POST['name'];
$email = $_POST['email'];
$birthday = $_POST['birthday'];
$address = $_POST['address'];
$typecustomer = $_POST['typecustomer'];
$infor = [
    'name'  => $name,
    'email' => $email,
    'birthday' => $birthday,
    'address' => $address,
    'typecustomer' => $typecustomer
];

$datas = new Customer();
$datas->store($infor);
header ("Location: list.php");