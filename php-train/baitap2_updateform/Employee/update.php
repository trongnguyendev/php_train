<?php
// session_start();
// // require_once ('./class.php');
// // $session = new Show_Error;
// $brithday = $_SESSION['errer_brithday'] ?? '';
// unset($_SESSION['errer_brithday']);
// $salary = $_SESSION['errer_salary'] ?? '';
// unset($_SESSION['errer_salary']);
require_once('./class/Employee.php');
$idUpdate = $_GET['index'];
$dataUpdate = new Employee();
$data = $dataUpdate->getEmployee($idUpdate);
$data['is_update'] = true;

require_once './view/form.php'
?>
