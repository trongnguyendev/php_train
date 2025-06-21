<div class="create">
    <form action="/stocks/create" method="POST" enctype="multipart/form-data">
        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" name="name" id="name" value="<?= $oldInput['name'] ?? '' ?>">

        <select name="" id="">
            <option value=""> Product 1
            </option>
        </select>
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

         <label for="warehouse">Kho:</label>
        <input type="text" name="warehouse" id="warehouse" value="<?= $oldInput['warehouse'] ?? '' ?>">

        <select name="" id="">
            <option value=""> Product 1
            </option>
        </select>
        <?php if (isset($errors['warehouse'])): ?>
            <p class='error'><?= implode(', ', $errors['warehouse']) ?></p>
        <?php endif;  ?>

        <label for="quantity">Số Lượng</label>
        <input type="number" name="quantity" id="quantity" value="<?= $oldInput['quantity'] ?? '' ?>">
        <?php if (isset($errors['quantity'])): ?>
            <p class='error'><?= implode(', ', $errors['quantity']) ?></p>
        <?php endif;  ?>

        <button type="submit">Gửi</button>

        <a class="link" href="/stocks">← Quay về danh sách</a>
    </form>
</div>