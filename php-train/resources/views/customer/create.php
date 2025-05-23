<div class="create">
    <form action="/customer/create" method="POST">
        <label for="name">Tên:</label>
        <input type="text" name="name" id="name" value="<?= $oldInput['name'] ?? '' ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= $oldInput['email'] ?? '' ?>">
        <?php if (isset($errors['email'])): ?>
            <p class='error'><?= implode(', ', $errors['email']) ?></p>
        <?php endif;  ?>

        <label for="phone">Số Điện Thoại:</label>
        <input type="number" name="phone" id="phone" value="<?= $oldInput['phone'] ?? '' ?>">
        <?php if (isset($errors['phone'])): ?>
            <p class='error'><?= implode(', ', $errors['phone']) ?></p>
        <?php endif;  ?>

        <label for="province">Tỉnh:</label>
        <input type="text" name="province" id="province" value="<?= $oldInput['province'] ?? '' ?>">
        
        <label for="address">Địa Chỉ:</label>
        <input type="text" name="address" id="address" value="<?= $oldInput['address'] ?? '' ?>">
       

        <label for="age">Tuổi:</label>
        <input type="number" name="age" id="age" min="1" max="100" value="<?= $oldInput['age'] ?? '' ?>">
        <?php if (isset($errors['age'])): ?>
            <p class='error'><?= implode(', ', $errors['age']) ?></p>
        <?php endif;  ?>

        <button type="submit">Gửi</button>

        <a class="link" href="/customer">← Quay về danh sách</a>
    </form>
</div>