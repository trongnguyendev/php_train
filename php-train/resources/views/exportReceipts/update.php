<div class="update">
    <form action="/export_receipts/edit/<?= $indexData ?>" method="POST">
        <label for="warehouse">KHO:</label>
        <input type="text" name="warehouse" id="warehouse" value="<?php echo htmlspecialchars($export_receiptsData['warehouse'] ?? $oldInput['warehouse'] ?? ''); ?>">
        <?php if (isset($errors['warehouse'])): ?>
            <p class='error'><?= implode(', ', $errors['warehouse']) ?></p>
        <?php endif;  ?>

        <label for="code">Mã Đơn:</label>
        <input type="code" name="code" id="code" value="<?php echo htmlspecialchars($export_receiptsData['code'] ?? $oldInput['code'] ?? ''); ?>">
        <?php if (isset($errors['code'])): ?>
            <p class='error'><?= implode(', ', $errors['code']) ?></p>
        <?php endif;  ?>

        <label for="devlivered_at">Thời Gian Tạo Đơn:</label>
        <input type="datetime" name="devlivered_at" id="devlivered_at" value="<?php echo intval($export_receiptsData['devlivered_at'] ?? $oldInput['devlivered_at'] ?? 0); ?>">
        <?php if (isset($errors['devlivered_at'])): ?>
            <p class='error'><?= implode(', ', $errors['devlivered_at']) ?></p>
        <?php endif;  ?>

        <label for="note">Ghi Chú:</label>
        <input type="text" name="note" id="note" value="<?php echo intval($export_itemsData['note'] ?? $oldInput['note'] ?? 0); ?>">
        <?php if (isset($errors['note'])): ?>
            <p class='error'><?= implode(', ', $errors['note']) ?></p>
        <?php endif;  ?>

        <label for="product">Sản Phẩm:</label>
        <input type="text" name="product" id="product" value="<?php echo intval($export_itemsData['product'] ?? $oldInput['product'] ?? 0); ?>">
        <?php if (isset($errors['product'])): ?>
            <p class='error'><?= implode(', ', $errors['product']) ?></p>
        <?php endif;  ?>

        <label for="quantity">Số Lượng:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo intval($export_itemsData['quantity'] ?? $oldInput['quantity'] ?? 0); ?>">
        <?php if (isset($errors['quantity'])): ?>
            <p class='error'><?= implode(', ', $errors['quantity']) ?></p>
        <?php endif;  ?>

        <button type="submit">Cập nhật</button>
        <a class="link-back" href="/employee">← Quay lại danh sách</a>
    </form>
</div>