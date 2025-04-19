<?php
require_once('./class/Employee.php');
$addDatas = new Employee();
$datas = $addDatas->readFile();
// $file = fopen("data.txt", "r");
// $datas = [];
// if ($file) {
//     while (($line = fgets($file)) !== false) { // Đọc từng dòng
//          $datas [] = explode("," , $line);
//     }
//     fclose($file);
// } else {
//     echo "Lỗi: Không thể mở file.";
// }
?>
<table border = 1>
<tr>
  <th>Tên Nhân Viên</th>
  <th>Email</th>
  <th>Ngày Sinh</th>
  <th>Lương</th>
  <th>Trạng Thái</th>
</tr>
<?php  foreach($datas as $key=>$data): ?>
<tr>
  <td><?php echo $data [0];?></td>
  <td><?php echo $data [1];?></td>
  <td><?php echo $data [2];?></td>
  <td><?php echo $data [3];?></td>
  <td><a href="update.php?index=<?php echo $key +1;?>">Update</td>
  <td><a href="delete.php?index=<?php echo $key +1;?>">Xóa</td>
</tr>
<?php endforeach;?>
</table>

<a href="index.php">Thêm</a>