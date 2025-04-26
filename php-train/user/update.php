<?php

require_once '../models/User.php';
require_once '../models/Role.php';

$user = new User();
$role = new Role();

$indexData = $_GET['id'] ?? 0;
$userData = $user->findRowByIndex($indexData);

$roles = $role->all();

$pageTitle = 'Cập nhật user';
$content = '../views/user/update.php';
require_once('../views/layouts/default.php');