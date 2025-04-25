<?php

require_once ('../models/User.php');
$user = new User();

$indexData = $_GET['id'] ?? 0;
$userData = $user->findRowByIndex($indexData);

$pageTitle = 'Cập nhật user';
$content = '../views/user/update.php';
require_once('../views/layouts/default.php');