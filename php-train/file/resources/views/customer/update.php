<div class="update">
    <form action="/customer/edit/<?= $indexData ?>" method="POST">
        <label for="name">Tên:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($customerData[0] ?? $oldInput['name'] ?? ''); ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($customerData[1] ?? $oldInput['email'] ?? ''); ?>">
        <?php if (isset($errors['email'])): ?>
            <p class='error'><?= implode(', ', $errors['email']) ?></p>
        <?php endif;  ?>

        <label for="phone">Số Điện Thoại:</label>
        <input type="number" name="phone" id="phone" value="<?php echo htmlspecialchars($customerData[2] ?? $oldInput['phone'] ?? ''); ?>">
        <?php if (isset($errors['phone'])): ?>
            <p class='error'><?= implode(', ', $errors['phone']) ?></p>
        <?php endif;  ?>

        <label for="province">Tỉnh:</label>
        <input type="text" name="province" id="province" value="<?php echo htmlspecialchars($customerData[3] ?? $oldInput['province'] ?? ''); ?>">
        

        <label for="address">Địa Chỉ:</label>
        <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($customerData[4] ?? $oldInput['address'] ?? ''); ?>">

        <label for="age">Tuổi:</label>
        <input type="number" name="age" id="age" value="<?php echo intval($customerData[5] ?? $oldInput['age'] ?? 0); ?>">
        <?php if (isset($errors['age'])): ?>
            <p class='error'><?= implode(', ', $errors['age']) ?></p>
        <?php endif;  ?>

        <button type="submit">Cập nhật</button>
        <a class="link-back" href="/customer">← Quay lại danh sách</a>
    </form>
</div>