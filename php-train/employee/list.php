<?php
$file = fopen("dataa.txt", "r");
$datas = [];
if ($file) {
    while (($line = fgets($file)) !== false) { // Đọc từng dòng
            $datas [] = explode("," , $line);
        // echo htmlspecialchars($line) . "<br>";
    }
    fclose($file);
} else {
    echo "Lỗi: Không thể mở file.";
}
// var_dump ($data);
?>
<table border = "1">
  <tr>
    <th>Tên Nhân Viên</th>
    <th>Email</th>
    <th>Ngày Sinh</th>
    <th>Lương</th>
    <th>Trạng Thái</th>
  </tr>
  <?php foreach ($datas as $key=>$data):?>
  <tr>
    <td><?php echo $data[0]; ?></td>
    <td><?php echo $data[1]; ?></td>
    <td><?php echo $data[2]; ?></td>
    <td><?php echo $data[3]; ?></td>
    <td><a href= "update.php?id=<?php echo $key + 1; ?>">Cập Nhập</a></td>
  </tr>
  <?php endforeach;?>
</table>