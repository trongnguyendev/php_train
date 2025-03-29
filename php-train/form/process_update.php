<?php
session_start();

$name = $_POST['name'];
$email = $_POST['email'];
$age = $_POST['age'];
$indexData = $_POST['index'];
$error = '';

$file = fopen("data.txt", "r");
$dataUpdate = '';
$index = 1;

if ($file) {
    while (($line = fgets($file)) !== false) {
        if ($index == $indexData) {
            $dataUpdate .= "$name,$email,$age\n";
        } else {
            $dataUpdate .= $line;
        }
        $index++;
    }
    fclose($file);
}


$file = fopen("data.txt", "w+");
fwrite($file, $dataUpdate);
header("Location: list.php");