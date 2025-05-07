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

//var_dump($data);

?>
<table border="1">
  <tr>
    <th>Tên</th>
    <th>Email</th>
    <th>Ngày sinh</th>
    <th>Lương</th>
  </tr>
  <?php foreach($data as $key => $value){ ?>
  <tr>
    <td><?php echo $value[0]; ?></td>
    <td><?php echo $value[1]; ?></td>
    <td><?php echo $value[2]; ?></td>
    <td><?php echo $value[3]; ?></td>
  </tr>
  <?php } ?>
</table>
