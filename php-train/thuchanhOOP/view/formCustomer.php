<?php
$action = 'process.php';
if(isset($idUpdate['id_update']) && $idUpdate['id_update']){
    $action = 'updateProcess.php';
}
?>
<form action=<?php echo $action;?> method="POST">
    <label for="name">Tên Khách Hàng</label>
    <input type="text" name="name" value="<?php echo $data[0] ?? '';?>" required>
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" value="<?php echo $data[1] ?? '';?>" required>
    <br>
    <label for="birthday">Ngày Sinh</label>
    <input type="date" name="birthday" value="<?php echo $data[2] ?? '';?>" >
    <br>
    <label for="address">Địa Chỉ</label>
    <input type="text" name="address" value="<?php echo $data[3] ?? '';?>" >
    <br>
    <label for="typecustomer">Loại Khách Hàng</label>
    <input type="text" name="typecustomer" value="<?php echo $data[4] ?? '';?>">
    <br>
    <?php if (isset($idUpdate) && $idUpdate['id_update']): ?>
    <input type="hidden" name="indexUpdate" value="<?php echo $id;?>">
    <?php endif; ?>
    <button type="submit">Nhập Thông Tin</button>
</form>
