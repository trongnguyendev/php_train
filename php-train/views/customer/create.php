<div class="create">
    <form action="process.php" method="POST">
        <label for="name">Tên:</label>
        <?php displayError('name', $errors); ?>
        <input type="text" name="name" id="name" value="<?= oldInput('name', $oldInput) ?>">

        <label for="email">Email:</label>
        <?php displayError('email', $errors); ?>
        <input type="email" name="email" id="email" value="<?= oldInput('email', $oldInput) ?>">

        <label for="age">Tuổi:</label>
        <?php displayError('age', $errors); ?>
        <input type="number" name="age" id="age" min="1" max="100" value="<?= oldInput('age', $oldInput) ?>">

        <button type="submit">Gửi</button>

        <a class="link" href="/customer/list.php">← Quay về danh sách</a>
    </form>
</div>