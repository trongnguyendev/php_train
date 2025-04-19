<?php

$file = fopen("data.txt", "r");
if ($file) {
    while (($line = fgets($file)) !== false) { // Đọc từng dòng
        echo htmlspecialchars($line) . "<br>";
    }
    fclose($file);
} else {
    echo "Lỗi: Không thể mở file.";
}
