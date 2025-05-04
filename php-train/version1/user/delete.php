<?php
require_once '../models/user.php';
$user = new User();
$idDelete = $_GET['id'] ?? '';
$user->delete($idDelete);
header("Location: list.php");