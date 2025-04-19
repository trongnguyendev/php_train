<?php 
session_start();

$error_name = $_SESSION['error_name'] ?? '';
unset($_SESSION['error_name'] );
$error_email =$_SESSION['error_email'] ?? '';
unset($_SESSION['error_email'] );
$error_age = $_SESSION['error_age'] ?? '';
unset($_SESSION['error_age'] );
$name = $_SESSION['name'] ?? '';
unset($_SESSION['name']);


// $file = fopen("data.txt", "r"); // Mở file để đọc

// if ($file) {
//     $content = fread($file, filesize("data.txt")); // Đọc toàn bộ file
//     fclose($file); // Đóng file sau khi đọc
//     // echo nl2br($content); // Hiển thị nội dung có xuống dòng
//     // tạo biến hiển thị ở dưới
//     $show = nl2br($content);
// } else {
//     echo "Lỗi: Không thể mở file.";
// }

$file = fopen("data.txt", "r");
$mang = [];
if ($file) {
    while (($line = fgets($file)) !== false) { // Đọc từng dòng
        // echo htmlspecialchars($line) . "<br>";
        $mang [] = htmlspecialchars($line);
    }
    fclose($file);
} else {
    echo "Lỗi: Không thể mở file.";
}
?>

<!-- // Hiệu quả khi đọc file lớn vì đọc từng dòng. -->

<form action = "process.php" method="POST"> 

<?php
if(isset($error_name)):
?>
<p> <?php echo $error_name;?></p>
<?php endif;?>
<lable for="name">Tên:</lable>
<input type ="text" name= "name" value = "<?php echo $name;?>" >

<br>
<?php if(isset($error_email)): ?>
<p> <?php echo $error_email;?></p>
<?php endif;?>
<lable for="email">Mail:</lable>
<input type ="email" name="email">

<br>
<?php
if(isset($error_age)):
    ?>
<p> <?php echo $error_age;?></p>
<?php endif;?>
<lable for="age">Tuổi:</lable>
<input type="number" name="number">

<br>
<lable for="name">Gửi</lable>
<input type="submit" value="Gửi"> 
</form>
<!-- <?php echo $show; ?> -->
<?php print_r ($mang); ?>
<a href="list.php">DATA</a>
<!-- tạo 1 biến chứa mãng trước $mang = []; -->
<!-- explode là chuyển thành mảnh ( ';', bien) -->
 <!-- $vege = 'rua,cu,qua'
    explode(',',$vegr)
 -->