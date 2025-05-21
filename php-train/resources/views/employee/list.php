<?php
$options = ['name' => 'Tên', 'email' => 'Email', 'age' => 'Tuổi'];
$selectedValue = oldInput('search_type', $oldSearch ?? '');
$oldContent = oldInput('search_content', $oldSearch ?? '');

function oldInput($field, $oldInput)
{
  return htmlspecialchars($oldInput[$field] ?? '');
}
?>

<div class="search-container">
  <form class="form-search" action="/employee" method="GET">
    <input type="text" name="tags_search" id="hiddenSearchContent" />
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
    <a href="/employee/create">+ Tạo mới</a>
  </button>
</div>

<div class="list">
  <?php if (empty($employees)): ?>
    <p class="no-data">Không có dữ liệu</p>
  <?php else: ?>
    <table>
      <thead> 
        <tr>
          <th>Tên</th>
          <th>Email</th>
          <th>Tuổi</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($employees as $index => $emp): ?>
          <tr>
            <td><?= htmlspecialchars($emp[0]) ?></td>
            <td><?= htmlspecialchars($emp[1]) ?></td>
            <td><?= htmlspecialchars($emp[2]); ?></td>
            <td>
              <a href="/employee/edit/<?= $index + 1 ?>">Cập nhật</a>
              <a href="/employee/delete/<?= $index + 1 ?>">Xoá</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>