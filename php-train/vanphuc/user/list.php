<?php
require_once ('../models/user.php');
$user = new User ();
$users = [];

$searchQuery = $_GET['search'] ?? '';
$searchType = $_GET['type'] ?? '';

if(!empty($searchQuery)) {
    $users = $user->findRowByType($searchQuery, $searchType);
}else {
    $users = $user->all();
}

$oldSearch = $_SESSION['old_search'] ?? [
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

require_once('../views/user/list.php');