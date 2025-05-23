<?php
if(isset($_SESSION['user_info'])){
    header("Location: /");
}
?>
<div class="create">
    <form action="/login/create" method="POST">
        <label for="username">User:</label>
        <input type="text" name="username" id="username" value="<?= $oldInput['username'] ?? '' ?>">

        <label for="password">Password:</label>
        <input type="text" name="password" id="password" value="<?= $oldInput['password'] ?? '' ?>">

        <button type="submit">Nhập</button>
    </form>       
</div>