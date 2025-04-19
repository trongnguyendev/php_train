<?php
require_once('../models/Employee.php');
$idUpdate = $_GET['index'];
$datas = new Employee();
$datas->readDeleteCus($idUpdate);

