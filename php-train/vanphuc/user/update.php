<?php
require_once ('../models/user.php');
$user = new User();

$indexData = $_GET['id'] ?? 0;
$userData = $user->findRowByIndex($indexData);
require_once('../views/user/update.php')
;
