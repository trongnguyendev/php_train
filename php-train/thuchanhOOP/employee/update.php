<?php
require_once('../models/employee.php');
$id = $_GET['index'];
$idUpdate['id_update'] = true;
$datas = new employee();
$data = $datas->updateFile($id);
require_once('../view/formEmployee.php');
