<?php
$options = ['name' => 'KHO', 'localtion' => 'Vị Trí'];
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
  <form class="form-search" action="/warehouse" method="GET">
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
    <a href="/warehouse/create">+ Tạo mới</a>
  </button>
</div>
<div class="list">
  <?php if (empty($warehoused)): ?>
    <p class="no-data">Không có dữ liệu</p>
  <?php else: ?>
    <table>
      <thead> 
        <tr>
          <th>KHO</th>
          <th>Vị Trí</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($warehoused as $index => $emp): ?>
          <tr>
            <td><?= htmlspecialchars($emp['name']) ?></td>
            <td><?= htmlspecialchars($emp['localtion']) ?></td>
            <td>
              <a href="/warehouse/edit/<?= $emp['id'] ?>">Cập nhật</a>
              <a href="/warehouse/delete/<?= $emp['id'] ?>">Xoá</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
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