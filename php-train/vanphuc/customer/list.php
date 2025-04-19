<?php
require_once '../models/customer.php';
$customer = new customer();
$customers = [];

$searchQuery = $_GET['search'] ?? '';
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

require_once('../views/customer/list.php');
?>