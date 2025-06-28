<div class="create">
    <form action="/import_receipts/create" method="POST">
        <label for="warehouse">KHO:</label>

        <select name="warehouse" id="warehouse">
            <option value="warehouse_id">-- Chọn kho --</option>
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

        <label for="received_at">Thời Gian Tạo Đơn:</label>
        <input type="date" name="received_at" id="received_at" value="<?= $oldInput['received_at'] ?? '' ?>">
        <?php if (isset($errors['received_at'])): ?>
            <p class='error'><?= implode(', ', $errors['received_at']) ?></p>
        <?php endif;  ?>

         <label for="note">Ghi Chú:</label>
        <input type="text" name="note" id="note" value="<?= $oldInput['note'] ?? '' ?>">
        <?php if (isset($errors['note'])): ?>
            <p class='error'><?= implode(', ', $errors['note']) ?></p>
        <?php endif;  ?>

        <!-- <label for="product">Sản Phẩm:</label>

         <select name="" id="products">
            <option value="">-- Chọn Sản Phẩm --</option>
            <?php foreach ($products as $item): ?>
                <option value="<?= $item['name'] ?>"
                    <?= ($oldInput['products'] ?? '') == $item['name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($item['name']) ?>
                </option>
            <?php endforeach; ?>
        </select> -->
        <!-- code lại chỗ sản phẩm và số lượng -->
        <?php foreach ($products as $key => $item): ?>
            <li class="product-item">
                <label>
                    <!-- Checkbox sản phẩm -->
                    <input type="checkbox" name="products[]" value="<?= $item['id'] ?>">
                    <?= htmlspecialchars($item['name']) ?>
                </label>

                <!-- Ô nhập số lượng đi kèm -->
                <input
                    type="number"
                    name="quantities[<?= $item['id'] ?>]"
                    min="1"
                    placeholder="Số lượng"
                    style="width: 80px;"
                >
            </li>
        <?php endforeach; ?>

        <!-- <?php if (isset($errors['product'])): ?>
            <p class='error'><?= implode(', ', $errors['product']) ?></p>
        <?php endif;  ?> -->

         <!-- <label for="quantity">Số Lượng:</label>
        <input type="number" name="quantity" id="quantity" value="<?= $oldInput['quantity'] ?? '' ?>">
        <?php if (isset($errors['quantity'])): ?>
            <p class='error'><?= implode(', ', $errors['quantity']) ?></p>
        <?php endif;  ?> -->

        <button type="submit">Gửi</button>

        <a class="link" href="/import_receipts">← Quay về danh sách</a>
    </form>
</div>