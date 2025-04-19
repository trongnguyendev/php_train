<?php
$action = 'process.php';
if(isset($idUpdate['id_update']) && $idUpdate['id_update']){
    $action = 'updateProcess.php';
}
session_start();
$birthday = $_SESSION['error_birthday'] ?? '';
unset($_SESSION['error_birthday']);
$address = $_SESSION['error_address'] ?? '';
unset($_SESSION['error_address']);
?>
<form action=<?php echo $action;?> method="POST">
    <label for="name">Tên Khách Hàng</label>
    <input type="text" name="name" value="<?php echo $data[0] ?? '';?>" required>
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" value="<?php echo $data[1] ?? '';?>" required>
    <br>
    <?php if(isset($birthday)):?>
    <p><?php echo $birthday; ?></p>
    <?php endif;?>
    <label for="birthday">Ngày Sinh</label>
    <input type="date" name="birthday" value="<?php echo $data[2] ?? '';?>" >
    <br>
    <?php if(isset($address)):?>
    <p><?php echo $address; ?></p>
    <?php endif;?>
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
