<?php
require_once('../models/User.php');

$userModel = new User();

$searchQuery = trim($_GET['search'] ?? '');
$searchType = $_GET['type'] ?? '';

$users = !empty($searchQuery)
    ? $userModel->findRowByType($searchQuery, $searchType)
    : $userModel->all();

$oldInput = $_SESSION['old_search'] ?? [
    'search_content' => '',
    'search_type' => '',
];

unset($_SESSION['old_search']);

function oldInput(string $field, array $data): string
{
    return htmlspecialchars($data[$field] ?? '');
}

// Render layout
$pageTitle = 'Tạo mới user';
$content = '../views/user/list.php';
require_once('../views/layouts/default.php');