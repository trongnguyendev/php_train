<?php
require_once('./class/Employee.php');
$idUpdate = $_GET['index'];
$datas = new Employee();
$datas->readDelete($idUpdate);

