<?php
session_start();
require_once '../models/Authentication.php';
$authentication = new Authentication();

$authentication->logout();

header("Location: /authenticate/login.php");