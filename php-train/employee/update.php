<?php
$id = $_GET['id'];
$file = fopen("dataa.txt", "r");
$datasUpdate = [];
$idUpdate = 1;
if ($file) {
    while (($line = fgets($file)) !== false) { // Đọc từng dòng
        if($id == $idUpdate ){
            $datasUpdate =explode("," ,  $line);
        }
        $idUpdate++;
        // echo htmlspecialchars($line) . "<br>";
    } 
    fclose($file);
} else {
    echo "Lỗi: Không thể mở file.";
}
// var_dump ($data);
?>

<form action="updateProcess.php" method="POST">

<label for="name">Tên Nhân Viên:</label>
<input type="text" name="name" value="<?php echo $datasUpdate[0]; ?>" required>
<br>
<label for="email">Email:</label>
<input type="email" name="email" value="<?php echo $datasUpdate[1]; ?>" required>
<label for="brithday">Ngày Sinh:</label>
<input type="date" name="brithday" value="<?php echo $datasUpdate[2]; ?>">
<label for="salary">Lương:</label>
<input type="number" name="salary" value="<?php echo intval($datasUpdate[3]); ?>">
<input type="hidden" name="indexUpdate" value="<?php echo $id;?>">
<br>
<button type="submit">Gửi</button>
</form>
<a href = "list.php"> List </a>