<?php
$name = $_POST['name'];
$email = $_POST['email'];
$brithday = $_POST['brithday'];
$salary = $_POST['salary'];
$indexUpdate = $_POST['indexUpdate'];

$file = fopen("dataa.txt", "r");
$datas = '';
$index = 1;
if ($file) {
    while (($line = fgets($file)) !== false) { // Đọc từng dòng
        if($index == $indexUpdate){
             $datas = $datas . "$name , $email , $brithday , $salary\n";
        }else {
            $datas = $datas . $line;
        }
        $index++;
        // echo htmlspecialchars($line) . "<br>";
    }
    fclose($file);
} else {
    echo "Lỗi: Không thể mở file.";
}
$file = fopen("dataa.txt", "w+"); // Mở file để ghi tiếp
fwrite($file,$datas);
fclose($file);

header("Location: list.php");
// Hiệu quả khi đọc file lớn vì đọc từng dòng.
?>
