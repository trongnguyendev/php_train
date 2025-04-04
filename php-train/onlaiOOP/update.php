<?php
require_once('./class/Employee.php');
$idUpdate = $_GET['index'];
$datas = new Employee();
$data = $datas->readFileUp($idUpdate);
?>
<form action="updateProcess.php" method="POST">
    <label for="name">Tên Nhân Viên</label>
    <input type="text" name="name" value="<?php echo $data[0];?>" required>
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" value="<?php echo $data[1];?>"required>
    <br>
    <label for="birthday">Ngày Sinh</label>
    <input type="date" name="birthday"value="<?php echo $data[2];?>">
    <br>
    <label for="salary">Tiền Lương</label>
    <input type="number" name="salary" value="<?php echo intval($data[3]);?>">
    <br>
    <button type="submit">Nhập Thông Tin</button>
    <input type="hidden" name="indexUpdate" value="<?php echo $idUpdate;?>">
</form>