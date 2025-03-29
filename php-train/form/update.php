<?php

$indexData = $_GET['id'] ?? 0;

$file = fopen("data.txt", "r");

$dataUpdate = [];
$index = 1;
if ($file) {
    while (($line = fgets($file)) !== false) {
        if ($index == $indexData) {
            $dataUpdate = explode(",", $line);
        }
        $index++;
    }
    fclose($file);
} else {
    echo "Lỗi: Không thể mở file.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form Example</title>
</head>
<body>
    <form action="process_update.php" method="POST">
        <label for="name">Tên:</label>
        <input type="text" name="name" id="name" value="<?php echo $dataUpdate[0]; ?>">

        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $dataUpdate[1]; ?>">
        
        <br>
        <label for="age">Tuổi:</label>
        <input type="number" name="age" value="<?php echo intval($dataUpdate[2]); ?>">
        <input type="hidden" name="index" value="<?php echo $indexData; ?>">

        <button type="submit">Gửi</button>
    </form>
    <a href="/form/list.php">Trang list</a>
</body>
</html>