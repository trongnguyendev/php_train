<?php
require_once '../models/user.php';
$user = new User();
$users = $user->all();
require_once '../views/user/list.php';