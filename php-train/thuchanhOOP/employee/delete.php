<?php
require_once('../models/Employee.php');
$id = $_GET['index'];
$delete = new Employee();
$delete->deleteEmployee($id);
header ("Location: list.php");