<div class="create">
    <form action="/warehouse/create" method="POST" enctype="multipart/form-data">
        <label for="name">Kho:</label>
        <input type="text" name="name" id="name" value="<?= $oldInput['name'] ?? '' ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>


        <label for="location">Vị Trí:</label>
        <input type="text" name="location" id="location" value="<?= $oldInput['location'] ?? '' ?>">
        <?php if (isset($errors['location'])): ?>
            <p class='error'><?= implode(', ', $errors['location']) ?></p>
        <?php endif;  ?>

    

        <button type="submit">Gửi</button>

        <a class="link" href="/warehouse">← Quay về danh sách</a>
    </form>
</div>