<div class="create">
    <form action="/import_receipts/create" method="POST">
        <label for="warehouse">KHO:</label>

        <select name="warehouse" id="warehouse">
            <option value="">-- Chọn kho --</option>
            <?php foreach ($warehoused as $item): ?>
                <option value="<?= $item['name'] ?>"
                    <?= ($oldInput['warehouse'] ?? '') == $item['name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($item['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <?php if (isset($errors['warehouse'])): ?>
            <p class='error'><?= implode(', ', $errors['warehouse']) ?></p>
        <?php endif;  ?>

        <label for="code">Mã Đơn:</label>
        <input type="text" name="code" id="code" value="<?= $oldInput['code'] ?? '' ?>">
        <?php if (isset($errors['code'])): ?>
            <p class='error'><?= implode(', ', $errors['code']) ?></p>
        <?php endif;  ?>

        <label for="devlivered_at">Thời Gian Tạo Đơn:</label>
        <input type="text" name="devlivered_at" id="devlivered_at" value="<?= $oldInput['devlivered_at'] ?? '' ?>">
        <?php if (isset($errors['devlivered_at'])): ?>
            <p class='error'><?= implode(', ', $errors['devlivered_at']) ?></p>
        <?php endif;  ?>

         <label for="note">Ghi Chú:</label>
        <input type="text" name="note" id="note" value="<?= $oldInput['note'] ?? '' ?>">
        <?php if (isset($errors['note'])): ?>
            <p class='error'><?= implode(', ', $errors['note']) ?></p>
        <?php endif;  ?>

        <label for="product">Sản Phẩm:</label>

         <select name="" id="products">
            <option value="">-- Chọn Sản Phẩm --</option>
            <?php foreach ($products as $item): ?>
                <option value="<?= $item['name'] ?>"
                    <?= ($oldInput['products'] ?? '') == $item['name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($item['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <?php if (isset($errors['product'])): ?>
            <p class='error'><?= implode(', ', $errors['product']) ?></p>
        <?php endif;  ?>

         <label for="quantity">Số Lượng:</label>
        <input type="text" name="quantity" id="quantity" value="<?= $oldInput['quantity'] ?? '' ?>">
        <?php if (isset($errors['quantity'])): ?>
            <p class='error'><?= implode(', ', $errors['quantity']) ?></p>
        <?php endif;  ?>

        <button type="submit">Gửi</button>

        <a class="link" href="/import_receipts">← Quay về danh sách</a>
    </form>
</div>