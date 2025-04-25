<div class="login">
    <form action="process.php" method="POST">
        <label for="username">User</label>
        <?php displayError('error_username', $errors); ?>
        <input type="text" name="username" value="<?php echo oldInput('username' , $oldInput) ?>"> 

        <label for="password">Password</label>
        <?php displayError('error_password', $errors); ?>
        <input type="text" name="password" value="<?php echo oldInput('password' , $oldInput) ?>"> 

        <button type="submit">Login</button>
    </form>
</div>