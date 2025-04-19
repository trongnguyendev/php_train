<?php
  require_once ('../models/Employee.php');
  $customer = new Employee();
  $datas = $customer->getCustomer();
  // $datas = $Employee->index(); dùng return;

  // $datas = $Employee->datas;
?>
<table border = "1">
  <tr>
    <th>Tên Khách Hàng</th>
    <th>Email</th>
    <th>Ngày Sinh</th>
    <th>Loại Khách Hàng</th>
    <th>Trạng Thái</th>
  </tr>
        <?php foreach($datas as $key=>$data):?>
  <tr>
    <td><?php echo $data[0];?></td>
    <td><?php echo $data[1];?></td>
    <td><?php echo $data[2];?></td>
    <td><?php echo $data[3];?></td>
    <td><a href="update.php?index=<?php echo $key +1; ?>">Update</a></td>
    <td><a href="delete.php?index=<?php echo $key +1; ?>">Xóa</a></td>
  </tr>
        <?php endforeach;?>
        </table>
<a href="index.php">Thêm Thông Tin</a>