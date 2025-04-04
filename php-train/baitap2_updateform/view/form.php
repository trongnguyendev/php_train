
<form action="updateprocess.php" method="POST">
    <label for="name">Tên Nhân Viên</label>
    <input type="text" name="name" value="<?php echo $data[0] ?? '';?>" required>
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" value="<?php echo $data[1] ?? '';?>"required>
    <br>
    <?php if(isset($brithday)):?>
    <?php echo $brithday;?>
    <?php endif;?>
    <label for="brithday">Ngày Sinh</label>
    <input type="date" name="brithday" value="<?php echo $data [2] ?? '';?>">
    <br>
    <?php if(isset($salary)):?>
    <?php echo $salary;?>
    <?php endif;?>
    <label for="salary">Tiền Lương</label>
    <input type="number" name="salary" value="<?php echo intval($data [3]) ?? '';?>">
    <?php if (isset($data) && $data['is_update']): ?>
    <input type="hidden" name="indexUpdate" value="<?php echo $idUpdate;?>">
    <?php endif; ?>
    <br>
    <button type="submit">Nhập Lại Thông Tin</button>
</form>