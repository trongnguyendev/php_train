<?php
require_once ('../models/employee.php');
$employee = new Employee();
$employees = [];



$searchQuery = $_GET['search'] ?? '';
$searchType = $_GET['type'] ?? '';

if (!empty($searchQuery)) {
  $employees = $employee->findRowByType($searchQuery, $searchType);
} else {
  $employees = $employee->all();
}

$oldSearch = $_SESSION['old_search'] ?? [
  'search_content' => '',
  'search_type' => '',
];

unset(
  $_SESSION['old_search']
);

function oldInput($field, $oldInput)
{
  return htmlspecialchars($oldInput[$field] ?? '');
}



$content = '../views/employee/list.php';
$pageTitle = 'Thông Tin Khách Hàng';
// require_once('../views/employee/list.php');
require_once('../views/employee/list.php');
?>