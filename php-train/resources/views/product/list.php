<?php
$options = ['name' => 'Tên Sản Phẩm', 'sku' => 'Mã Sản Phẩm'];
$selectedValue = oldInput('search_type', $oldSearch ?? '');
$oldContent = oldInput('search_content', $oldSearch ?? '');

function oldInput($field, $oldInput)
{
  return htmlspecialchars($oldInput[$field] ?? '');
}
?>

<div class="search-container">
  <div class="tag-input-container" onclick="input.focus()">
    <input type="text" name="content_search" id="tagInput" placeholder="Nhập giá trị và nhấn Enter">
  </div>
  <form class="form-search" action="/product" method="GET">
    <input type="hidden" name="tags_search" id="hiddenSearchContent" />
    <select name="type" class="type_search">
      <?php foreach ($options as $key => $label): ?>
        <option value="<?= $key ?>" <?= $key === $selectedValue ? 'selected' : '' ?>>
          <?= $label ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit">Tìm kiếm</button>
    <button id="resetBtn">Reset</button>
  </form>
  <button class="btn-create">
    <a href="/product/create">+ Tạo mới</a>
  </button>
</div>

<div class="list">
  <?php if (empty($products)): ?>
    <p class="no-data">Không có dữ liệu</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="modern-table">
        <thead>
          <tr>
            <th>Mã Sản Phẩm</th>
            <th>Tên Sản Phẩm</th>
            <th>Mô Tả</th>
            <th>Đơn Vị</th>
            <th>Giá</th>
            <th>Hình Ảnh</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $index => $emp): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td>
                <div class="emp-info">
                  <div class="emp-avatar">
                    <span><?= strtoupper(mb_substr($emp['name'], 0, 1, 'UTF-8')) ?></span>
                  </div>
                  <div>
                    <div class="emp-name"><?= htmlspecialchars($emp['name']) ?></div>
                  </div>
                </div>
              </td>
              <td><?= htmlspecialchars($emp['id']) ?></td>
              <td><?= htmlspecialchars($emp['quantity']); ?></td>
              <td><?= htmlspecialchars($emp['id']); ?></td>
              <td><img style="width: 56px; height: 40px; object-fit:cover; border-radius:6px; background:#f6f8fb;" src="<?= htmlspecialchars($emp['image'] ?? ''); ?>"></td>
              <td>
                <a href="/product/edit/<?= $index + 1 ?>" class="icon-btn edit" title="Cập nhật"><i class="fa fa-pen"></i></a>
                <a href="/product/delete/<?= $index + 1 ?>" class="icon-btn delete" title="Xoá"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<script>
  const input = document.getElementById('tagInput');
  const container = document.querySelector('.tag-input-container');
  const hiddenInput = document.getElementById('hiddenSearchContent');
  const resetBtn = document.getElementById('resetBtn');

  let tags = [];

  input.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && input.value.trim() !== '') {
      e.preventDefault();
      const value = input.value.trim();
      if (!tags.includes(value) && input.value.trim() !== '') {
        tags.push(value);
        renderTags();
        input.value = '';
      }
    }
  });

  resetBtn.addEventListener('click', function (e) {
    e.preventDefault();
    tags = [];
    input.value = '';
    hiddenInput.value = '';
    container.querySelectorAll('.tag').forEach(tag => tag.remove());
    const cleanUrl = window.location.origin + window.location.pathname;
    window.history.pushState({}, '', cleanUrl);
    window.location.reload();
  });

  function renderTags() {
    container.querySelectorAll('.tag').forEach(tag => tag.remove());
    tags.forEach((tag, index) => {
      const tagEl = document.createElement('div');
      tagEl.className = 'tag';
      tagEl.innerHTML = `${tag}<span onclick="removeTag(${index})">&times;</span>`;
      container.insertBefore(tagEl, input);
    });
    hiddenInput.value = tags.join(',');
  }

  function removeTag(index) {
    tags.splice(index, 1);
    renderTags();
  }

  function initTags(tagStr) {
    if (tagStr == '') return
    tags = tagStr.toString().split(",")
    renderTags()
  }

  initTags("<?= $oldContent ?>")
</script>