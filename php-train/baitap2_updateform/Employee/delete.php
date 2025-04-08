<?php
$idDelete = $_GET['index'];
$id = 1;
$datas = '';
$file = fopen("dulieu.txt", "r");

if ($file) {
    while (($line = fgets($file)) !== false) { // Đọc từng dòng
        if($id != $idDelete){
            $datas .= $line;
        }
        $id++;
    }
    fclose($file);
} else {
    echo "Lỗi: Không thể mở file.";
}
$file = fopen("dulieu.txt", "w+"); // Mở file với chế độ ghi (xóa dữ liệu cũ)
fwrite($file, $datas);
fclose($file);
    // Hiệu quả khi đọc file lớn vì đọc từng dòng.

header("Location: show.php");
