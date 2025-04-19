<form action="updateProcess.php" method="POST">
    <label for="name">Tên Nhân Viên</label>
    <input type="text" name="name" value="<?php echo $data[0] ?? '';?>" required>
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" value="<?php echo $data[1] ?? '';?>"required>
    <br>
    <label for="brithday">Ngày Sinh</label>
    <input type="date" name="brithday" value="<?php echo $data [2] ?? '';?>">
    <br>
    <label for="customer">Loại Khách</label>
    <input type="customer" name="customer" value="<?php echo $data [3] ?? '';?>">
    <input type="hidden" name="indexUpdate" value="<?php echo $idUpdate;?>">
    <br>
    <button type="submit">Nhập Lại Thông Tin</button>
</form>
