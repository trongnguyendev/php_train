<?php
$file = fopen("text.txt", "r"); // Mở file để đọc

if ($file) {
    $content = fread($file, filesize("text.txt")); // Đọc toàn bộ file
    // filesize("filename.txt")) => dung lượng file (có thể điền số MB cụ thể)
    fclose($file); // Đóng file sau khi đọc
    echo nl2br($content); // Hiển thị nội dung có xuống dòng
} else {
    echo "Lỗi: Không thể mở file.";
}
?>
<a href="/infor/index.php"> Điền FORM </a>
// Dùng nl2br() để giữ xuống dòng đúng format.