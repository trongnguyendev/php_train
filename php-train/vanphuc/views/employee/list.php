<?php 

$selectedAge = $oldSearch['search_type'];
$selectedSearch = $oldSearch['search_content'];
?>
<form class="form-search" action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET">
<input type="content_search" name="search" value="<?=  $selectedSearch ?? '' ?>" >
<select name="type" id="">
  <option value="name" <?= $selectedAge === 'name' ? 'selected' : ''; ?>>Tên</option>
  <option value="age" <?= $selectedAge === 'age' ? 'selected' : ''; ?>>Tuổi</option>
  <option value="email" <?= $selectedAge === 'email' ? 'selected' : ''; ?>>email</option>
  <option value="phone" <?= $selectedAge === 'phone' ? 'selected' : ''; ?>>Số Điện Thoại</option>
</select>
<button type="submit" class="search_employee">Tìm Kiếm</button>
</form>

<style>

  
</style>


<div class="list">
    <?php if(empty($employees)):?>
        <p class="no-data">Không Có Dữ Liệu</p>
    <?php else: ?>
      <table>
      <thead>
        <tr>
          <th>Tên</th>
          <th>Tuổi</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Hành Động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($employees as $index => $emp): ?>
          <tr>
            <td><?= htmlspecialchars($emp[0]); ?></td>
            <td><?= htmlspecialchars($emp[1]); ?></td>
            <td><?= htmlspecialchars($emp[2]); ?></td>  
            <td><?= htmlspecialchars($emp[3]); ?></td>

            <td>
              <a href="update.php?id=<?= $index + 1 ?>">Cập nhật</a>
              <a href="delete.php?id=<?= $index + 1 ?>">Xoá</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>