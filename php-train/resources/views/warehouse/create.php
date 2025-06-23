<div class="create">
    <form action="/warehouse/create" method="POST" enctype="multipart/form-data">
        <label for="name">Kho:</label>
        <input type="text" name="name" id="name" value="<?= $oldInput['name'] ?? '' ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>


        <label for="localtion">Vị Trí:</label>
        <input type="text" name="localtion" id="localtion" value="<?= $oldInput['localtion'] ?? '' ?>">
        <?php if (isset($errors['localtion'])): ?>
            <p class='error'><?= implode(', ', $errors['localtion']) ?></p>
        <?php endif;  ?>

    

        <button type="submit">Gửi</button>

        <a class="link" href="/warehouse">← Quay về danh sách</a>
    </form>
</div>