<?php

$file = fopen("data.txt", "r");

$data = [];
if ($file) {
    while (($line = fgets($file)) !== false) { // Đọc từng dòng
        $data[] = explode(",", $line);
    }
    fclose($file);
} else {
    echo "Lỗi: Không thể mở file.";
}
?>

<table border="1">
  <tr>
    <th>Tên</th>
    <th>Email</th>
    <th>Tuổi</th>
  </tr>
  <?php foreach($data as $key => $value){ ?>
  <tr>
    <td><?php echo $value[0]; ?></td>
    <td><?php echo $value[1]; ?></td>
    <td><?php echo $value[2]; ?></td>
    <td><a href="/form/update.php?id=<?php echo $key+1; ?>">Cập nhật</a></td>
  </tr>
  <?php } ?>
</table>

<a href="/form/index.php">Tạo mới</a>