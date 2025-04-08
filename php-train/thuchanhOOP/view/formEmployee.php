<?php
$action = 'process.php';
if(isset($idUpdate['id_update']) && $idUpdate['id_update']){
    $action = 'updateProcess.php';
}
session_start();
$birthday = $_SESSION['error_birthday'] ?? '';
unset($_SESSION['error_birthday']);
$salary = $_SESSION['error_salary'] ?? '';
unset($_SESSION['error_salary']);
?>

<form action=<?php echo $action;?> method="POST">
    <label for="name">Tên Nhân Viên</label>
    <input type="text" name="name" value="<?php echo $data[0] ?? '';?>" required>
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" value="<?php echo $data[1] ?? '';?>"  required>
    <br>
    <?php if(isset($birthday)):?>
    <p><?php echo $birthday; ?></p>
    <?php endif;?>
    <label for="birthday">Ngày Sinh</label>
    <input type="date" name="birthday" value="<?php echo $data[2] ?? '';?>" >
    <br>
    <?php if(isset($salary)):?>
    <p><?php echo $salary; ?></p>
    <?php endif;?>
    <label for="salary">Tiền Lương</label>
    <input type="number" name="salary" value="<?php echo intval($data[3]) ?? '';?>" >
    <?php if (isset($idUpdate) && $idUpdate['id_update']): ?>
    <input type="hidden" name="indexUpdate" value="<?php echo $id;?>">
    <?php endif; ?>
    <br>
    <button type="submit">Nhập Thông Tin</button>
</form>
