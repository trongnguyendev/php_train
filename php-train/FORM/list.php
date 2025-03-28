<?php
$file = fopen("data.txt", "r"); // Mở file để đọc

if ($file) {
    $content = fread($file, filesize("data.txt")); // Đọc toàn bộ file
    fclose($file); // Đóng file sau khi đọc
    echo nl2br($content); // Hiển thị nội dung có xuống dòng
} else {
    echo "Lỗi: Không thể mở file.";
}
?>
<a href="/FORM/index.php"> Điền FORM </a>
// Dùng nl2br() để giữ xuống dòng đúng format.