<?php
session_start();

$error_name = $_SESSION['error_name'] ?? '';
unset($_SESSION['error_name']);

$error_email = $_SESSION['error_email'] ?? '';
unset($_SESSION['error_email']);

$error_age = $_SESSION['error_age'] ?? '';
unset($_SESSION['error_age']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form Example</title>
</head>
<body>
    <form action="process.php" method="POST">
        <?php if(isset($error_name)): ?>
        <p style="color: red"><?php echo $error_name; ?></p>
        <?php endif; ?>

        <label for="name">Tên:</label>
        <input type="text" name="name" id="name">

        <br>
        <?php if(isset($error_email)): ?>
        <p style="color: red"><?php echo $error_email; ?></p>
        <?php endif; ?>
        <label for="email">Email:</label>
        <input type="email" name="email">
        
        <br>
        <?php if(isset($error_age)): ?>
        <p style="color: red"><?php echo $error_age; ?></p>
        <?php endif; ?>
        <label for="age">Tuổi:</label>
        <input type="number" name="age" min="1" max="100">

        <label for="subscribe">Đăng ký nhận tin:</label>
        <input type="checkbox" name="subscribe" value="yes" id="subscribe">

        <!-- <br>
        <label for="age">Password:</label>
        <input type="password" name="password"> -->

        <!-- <br>
        <input type="checkbox" name="subscribe" value="yes"> Đăng ký nhận tin

        <input type="radio" name="gender" value="male"> Nam
        <input type="radio" name="gender" value="female"> Nữ

        <select name="country">
            <option value="VN">Việt Nam</option>
            <option value="US">Mỹ</option>
        </select>


        <textarea name="message"></textarea>

        <input type="file" name="file"> -->

        <button type="submit">Gửi</button>
        <!-- <input type="submit" value="Gửi"> -->
    </form>
    <a href="/form/list.php">Trang list</a>
</body>
</html>