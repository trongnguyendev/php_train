<?php
$options = ['name' => 'Tên', 'email' => 'Email', 'password' => 'Mật khẩu'];
$selectedValue = oldInput('search_type', $oldSearch ?? '');
$oldContent = oldInput('search_content', $oldSearch ?? '');

function oldInput($field, $oldInput)
{
  return htmlspecialchars($oldInput[$field] ?? '');
}
?>

<div class="search-container">
  <form class="form-search" action="/user" method="GET">
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
    <a href="/user/create">+ Tạo mới</a>
  </button>
</div>

<div class="list">
  <?php if (empty($users)): ?>
    <p class="no-data">Không có dữ liệu</p>
  <?php else: ?>
    <table>
      <thead> 
        <tr>
          <th>Tên</th>
          <th>Email</th>
          <th>Mật khẩu</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $index => $emp): ?>
          <tr>
            <td><?= htmlspecialchars($emp[0]) ?></td>
            <td><?= htmlspecialchars($emp[1]) ?></td>
            <td><?= htmlspecialchars($emp[2]); ?></td>
            <td>
              <a href="/user/edit/<?= $index + 1 ?>">Cập nhật</a>
              <a href="/user/delete/<?= $index + 1 ?>">Xoá</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>