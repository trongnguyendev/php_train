<?php
  $selectedAge = $oldSearch['search_type'];
  $selectedSearch = $oldSearch['search_content'];
?>


<form class="form-search" action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET">
  <input type="contet_search" name="search" value="<?= $selectedSearch ?? ''?>">
  <select name="type" id="">
    <option value="username" <?= $selectedAge === 'username' ? 'selected' : ''; ?>>Username</option>
    <option value="Email" <?= $selectedAge === 'email' ? 'selected' : ''; ?> >Email</option>
    <option value="lastname" <?= $selectedAge === 'lastname' ? 'selected' : ''; ?> >lastname</option>
  </select>
  <button type="submot">Tìm Kiếm</button>
</form>


<div class="list">
    <?php if(empty($users)):?>
        <p class="no-data">Không Có Dữ Liệu</p>
    <?php else: ?>
      <table>
      <thead>
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>Tên</th>
          <th>Họ</th>
          <th>Xác Thực</th>
          <th>Password</th>
          <th>Hành Động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $index => $emp): ?>
          <tr>
            <td><?= htmlspecialchars($emp[0]); ?></td>
            <td><?= htmlspecialchars($emp[1]); ?></td>
            <td><?= htmlspecialchars($emp[2]); ?></td>  
            <td><?= htmlspecialchars($emp[3]); ?></td>
            <td><?= htmlspecialchars($emp[4]); ?></td>  
            <td><?= htmlspecialchars($emp[5]); ?></td>

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