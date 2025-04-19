<?php
require_once ('../models/user.php');
$user = new User ();
$users = [];
if($user){
    $users = $user->all();
}

require_once('../views/user/list.php');