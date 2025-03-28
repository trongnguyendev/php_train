<?php
$content = file_get_contents("dataa.txt");
echo "Đã nhập thành công";
echo nl2br(htmlspecialchars($content));
?>
<a href = "index.php">Form</a>