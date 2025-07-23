<div class="container">
  <form action="/product-group/edit/<?=  $indexData; ?>" method="POST" id="orderForm" class="form-group">
    <div style="display: flex; gap: 20px;">
      <!-- Bên trái: Full bộ -->
      <div style="flex: 1;">
        <h3>Thông tin đơn hàng</h3>

        <?php if (!empty($errors['fullbo'])): ?>
          <p style="color: red"><?= implode(', ', $errors['fullbo']); ?></p>
        <?php endif; ?>
        <?php if (!empty($errors['error_system'])): ?>
          <p style="color: red"><?= implode(', ', $errors['error_system']); ?></p>
        <?php endif; ?>

        <label for="name">Chọn sản phẩm Full Bộ:</label>
          <input type="text" name="name" id="name" value="<?= htmlspecialchars($groupInfo['name'] ?? $oldInput['name'] ?? '') ?>">
          <?php if (isset($errors['name'])): ?>
              <p class='error'><?= implode(', ', $errors['name']) ?></p>
          <?php endif; ?>

          <label for="price">Giá:</label>
          <input type="number" name="price" id="price" value="<?= htmlspecialchars($groupInfo['price'] ?? $oldInput['price'] ?? '') ?>">
          <?php if (isset($errors['price'])): ?>
              <p class='error'><?= implode(', ', $errors['price']) ?></p>
          <?php endif;  ?>


        <label>Sản phẩm lẻ đã chọn:</label>
        <div id="selectedProducts" style="border:1px solid #ccc; padding:10px;"></div>

        <button type="submit" style="margin-top:10px;">Gửi</button>
      </div>

      <!-- Bên phải: danh sách sản phẩm -->
      <div style="flex: 1;">
        <h3>Chọn sản phẩm lẻ</h3>
        <input type="text" oninput="filterProducts(this.value)" placeholder="Tìm...">
        <div id="productList">
          <?php foreach ($products as $sp): ?>
            <label style="display: flex; margin-bottom: 8px;">
              <input type="checkbox"
                    value="<?= $sp['id'] ?>"
                    data-name="<?= htmlspecialchars($sp['name']) ?>"
                    data-price="<?= $sp['price'] ?>"
                    <?= in_array($sp['id'], $productIdSelected) ? 'checked' : '' ?>
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
</div>

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
function renderSelectedProducts(selectedIds, allProducts) {
    const container = document.querySelector('#selectedProducts');
    if (!container) return;

    selectedIds.forEach((id) => {
      const sp = allProducts.find(p => p.id == id);
      if (sp) {
        const checkbox = document.querySelector(`input[type="checkbox"][value="${sp.id}"]`);
        if (checkbox) checkbox.checked = true;

        const html = `
          <div id="product-${sp.id}" style="margin-bottom:10px;">
            <input type="hidden" name="products[${sp.id}][id]" value="${sp.id}">
            <strong>${sp.name}</strong>
            <input type="number" name="products[${sp.id}][qty]" value="1" min="1" style="width:60px;">
            <button type="button" onclick="removeProduct('${sp.id}')">X</button>
          </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
      }
    });
}

const productIdSelected = <?= json_encode($productIdSelected ?? []) ?>;
const products = <?= json_encode($products) ?>;
window.addEventListener('DOMContentLoaded', () => {
  renderSelectedProducts(productIdSelected, products);
});
</script>