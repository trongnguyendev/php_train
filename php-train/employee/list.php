<?php
require_once '../models/Employee.php';
$employee = new Employee();
$employees = [];

$searchQuery = $_GET['tags_search'] ?? '';
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

$pageTitle = 'Danh sách nhân viên';
$content = '../views/employee/list.php';
require_once('../views/layouts/default.php');

?>