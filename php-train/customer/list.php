<?php
require_once '../models/customer.php';
$customer = new customer();
$customers = [];

$searchQuery = $_GET['tags_search'] ?? '';
$searchType = $_GET['type'] ??  '';

if(!empty($searchQuery)) {
    $customers = $customer->findRowByType($searchQuery , $searchType);
}else {
    $customers = $customer->all();
}

$oldSearch  =$_SESSION['old_search'] ?? [
    'search_content' => '',
    'search_type' => '',
];

unset(
    $_SESSION['old_search']
);

function oldInput($fiels, $oldInput)
{
    return htmlspecialchars($oldInput[$field] ?? '');
}

$pageTitle = 'Danh sách khách hàng';
$content = '../views/customer/list.php';
require_once('../views/layouts/default.php');
?>