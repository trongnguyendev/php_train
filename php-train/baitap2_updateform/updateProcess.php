<?php
session_start();
$name = $_POST['name'];
$email = $_POST['email'];
$brithday = $_POST['brithday'];
$salary = $_POST['salary'];
$idUpdate = $_POST['indexUpdate'];
$id = 1;
$datas ='';

$hasProcess = true;
if($brithday == ''){
    $_SESSION['errer_brithday'] = "Chưa điền ngày sinh";
}
if($salary == ''){
    $_SESSION['errer_salary'] = "Chưa điền tiền lương";
}
if($brithday === '' || $salary === ''){
    $hasProcess = false;
    header("Location: update.php?index=$idUpdate");
    exit;
}
if($hasProcess){
     if($id == $idUpdate ){
        
     }

    // $file = fopen("dulieu.txt", "r");
    
    // if ($file) {
    //     while (($line = fgets($file)) !== false) { // Đọc từng dòng
    //       if($id == $idUpdate){
    //         $datas .= "$name,$email,$brithday,$salary\n";
    //       }else{
    //         $datas .= $line;
    //       }
    //       $id++;
    //     }
    //     fclose($file);
    // } else {
    //     echo "Lỗi: Không thể mở file.";
    // }
}
$file = fopen("dulieu.txt", "w+"); // Mở file với chế độ ghi (xóa dữ liệu cũ)
fwrite($file, $datas);
fclose($file);
    // Hiệu quả khi đọc file lớn vì đọc từng dòng.

header("Location: show.php");
