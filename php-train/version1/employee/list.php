
<?php
require_once '../models/employee.php';
$employee = new Employee();
$employees = [];


$searchQuery = $_GET['content_search'] ?? '';
$searchType = $_GET['type_option'] ?? '';

if(!empty($searchQuery)) {
    $employees = $employee->findRowByType($searchQuery, $searchType);

}else {
    $employees = $employee->all();
}

$oldSearch  = $_SESSION['old_search'] ?? [
    'search_content' => '',
    'search_type' => '',
];

unset(
    $_SESSION['old_search']
);

function oldInput($field, $oldInput){
    return htmlspecialchars($oldInput[$field] ?? '');
}

$pageTitle = 'Danh Sách Nhân Viên';
$content = '../views/employee/list.php';

require_once '../views/layouts/default.php';