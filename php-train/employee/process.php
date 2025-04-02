<?php
session_start();
$name =$_POST['name'];
$email =$_POST['email'];
$brithday =$_POST['brithday'];
$salary = $_POST['salary'];
// $name = $_POST['name'];
// $email = $_POST['email'];
// $brithday = $_POST['brithday'];
// $salary = $_POST['salary'];

// class Process {
//     public $name;
//     public $email;
//     public $brithday;
//     public $salary;

//     public function __construct ($name , $email, $brithday, $salary){
//         $this->name = $name;
//         $this->email = $email;
//         $this->brithday = $brithday;
//         $this->salary = $salary;
//     }
//     public function nameSalary (){
//         echo "Tiền Lương Tháng Này Của: " . $this->name . " là: " . $this->salary;
//     }
// }

$validate = true;
if($name == ''){
    $_SESSION['errer_name'] = "Chưa Điền Tên";
}
if($email == ''){
    $_SESSION['errer_email'] = "Chưa Điền Email";
}
if($brithday == ''){
    $_SESSION['errer_brithday'] = "Chưa Điền Ngày Sinh";
}
if($salary == ''){
    $_SESSION['errer_salary'] = "Chưa Điền Tiền Lương";
}
if($brithday =='' || $salary == ''){
    $validate = false;
    header("Location: index.php");
}

if ($validate) {
    $file = fopen("dataa.txt", "a"); // Mở file để ghi tiếp
    fwrite($file, "$name , $email , $brithday , $salary\n");
    fclose($file);

    header("Location: list.php");
}

?>