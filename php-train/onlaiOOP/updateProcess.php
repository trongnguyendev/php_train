<?php
require_once('./class/Employee.php');
$name =$_POST['name'];
$email =$_POST['email'];
$birthday =$_POST['birthday'];
$salary =$_POST['salary'];
$idUpdate = $_POST['indexUpdate'];
$datas = [
    'name' => $name,
    'email' => $email,
    'birthday' => $birthday,
    'salary' => $salary
];
$update = new Employee();
$update->update($idUpdate,$datas);

// $file = fopen("data.txt", "r");
// if ($file) {
//     while (($line = fgets($file)) !== false) { // Đọc từng dòng
//        if($idUpdate == $id){
//         $datas  .= "$name,$email,$birthday,$salary\n";
//        }else{
//         $datas .= $line;
//        } $id++;
//     }
//     fclose($file);
// } else {
//     echo "Lỗi: Không thể mở file.";
// }

// $file = fopen("data.txt", "w+"); // Mở file với chế độ ghi (xóa dữ liệu cũ)
// fwrite($file, "$datas");
// fclose($file);


// header("Location: list.php");