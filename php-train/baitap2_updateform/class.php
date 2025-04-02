<?php
session_start();
class Show_Error {
    public $brithday;
    public $salary;
public function __construct(){
$this->brithday = $_SESSION['errer_brithday'] ?? '';
unset($_SESSION['errer_brithday']);
$this->salary = $_SESSION['errer_salary'] ?? '';
unset($_SESSION['errer_salary']);
}

    public function showForm(){
        $this->brithday = $brithday;
        $this->$salary = $salary;

    }
}
?>
    <label for="name">Tên Nhân Viên</label>
    <input type="text" name="name" required>
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" required>
    <br>
    <?php if(isset($this->brithday)):?>
    <?php echo $this->brithday;?>
    <?php endif;?>
    <label for="brithday">Ngày Sinh</label>
    <input type="date" name="brithday">
    <br>
    <?php if(isset($this->salary)):?>
    <?php echo $this->salary;?>
    <?php endif;?>
    <label for="salary">Tiền Lương</label>
    <input type="number" name="salary">



