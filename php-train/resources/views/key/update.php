<?php
// Hàm giữ lại dữ liệu cũ sau khi submit
function oldInput($field, $oldInput)
{
    return htmlspecialchars($oldInput[$field] ?? '');
}
?>

<form action="/key/edit/<?= $indexData ?>" method="POST">
  <div style="display: flex; gap: 20px;">
    <!-- Bên trái: Full bộ -->
    <div style="flex: 1;">
      <h3>Thông tin đơn hàng</h3>

      <?php if (!empty($errors['fullbo'])): ?>
        <p style="color: red"><?= $errors['fullbo'] ?></p>
      <?php endif; ?>

      <label for="fullbo">Chọn sản phẩm Full Bộ:</label>
      <select name="fullbo" id="fullbo">
        <option value="">-- Chọn Sản Phẩm Full Bộ --</option>
        <?php foreach ($full_bo_sanphams as $item): ?>
          <option value="<?= $item['id'] ?>" <?= oldInput('fullbo', $oldInput) == $item['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($item['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label>Sản phẩm lẻ đã chọn:</label>
      <div id="selectedProducts" style="border:1px solid #ccc; padding:10px;"></div>

      <button type="submit" style="margin-top:10px;">Gửi</button>
    </div>

    <!-- Bên phải: danh sách sản phẩm -->
    <div style="flex: 1;">
      <h3>Chọn sản phẩm lẻ</h3>
      <input type="text" oninput="filterProducts(this.value)" placeholder="Tìm...">
      <div id="productList">
        <?php foreach ($sanphams as $sp): ?>
          <label style="display: flex; margin-bottom: 8px;">
            <input type="checkbox"
                   value="<?= $sp['id'] ?>"
                   data-name="<?= htmlspecialchars($sp['name']) ?>"
                   data-price="<?= $sp['price'] ?>"
                   onchange="toggleProduct(this)">
            <div style="margin-left: 8px;">
              <strong><?= htmlspecialchars($sp['name']) ?></strong><br>
              Giá: <?= number_format($sp['price'], 0, ',', '.') ?> đ
            </div>
          </label>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</form>

<!-- SCRIPT xử lý chọn/xoá sản phẩm lẻ -->
<script>
function toggleProduct(checkbox) {
  const id = checkbox.value;
  if (!id) return;
  const name = checkbox.dataset.name;
  const price = checkbox.dataset.price;
  const container = document.getElementById('selectedProducts');

  if (checkbox.checked) {
    const html = `
      <div id="product-${id}" style="margin-bottom:10px;">
        <input type="hidden" name="products[${id}][id]" value="${id}">
        <strong>${name}</strong>
        <input type="number" name="products[${id}][qty]" value="1" min="1" style="width:60px;">
        <button type="button" onclick="removeProduct('${id}')">X</button>
      </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
  } else {
    removeProduct(id);
  }
}

function removeProduct(id) {
  const el = document.getElementById(`product-${id}`);
  if (el) el.remove();
  const cb = document.querySelector(`input[type="checkbox"][value="${id}"]`);
  if (cb) cb.checked = false;
}

function filterProducts(keyword) {
  const items = document.querySelectorAll('#productList label');
  items.forEach(item => {
    item.style.display = item.innerText.toLowerCase().includes(keyword.toLowerCase()) ? '' : 'none';
  });
}
</script>

<!-- SCRIPT hiển thị lại sản phẩm đã chọn sau khi submit lỗi -->
<?php if (!empty($oldInput['products'])): ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const selected = <?= json_encode($oldInput['products']) ?>;

  Object.values(selected).forEach(item => {
    const id = item.id;
    const qty = item.qty || 1;
    const cb = document.querySelector(`input[type="checkbox"][value="${id}"]`);
    if (!cb) return;

    const name = cb.dataset.name || 'Sản phẩm';
    const price = cb.dataset.price || 0;

    const container = document.getElementById('selectedProducts');
    const html = `
      <div id="product-${id}" style="margin-bottom:10px;">
        <input type="hidden" name="products[${id}][id]" value="${id}">
        <strong>${name}</strong>
        <input type="number" name="products[${id}][qty]" value="${qty}" min="1" style="width:60px;">
        <button type="button" onclick="removeProduct('${id}')">X</button>
      </div>
    `;
    container.insertAdjacentHTML('beforeend', html);

    cb.checked = true;
  });
});
</script>
<?php endif; ?>
