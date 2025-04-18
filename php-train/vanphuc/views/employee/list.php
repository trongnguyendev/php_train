<form class="form-search" action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET">
<input type="content_search">
<select name="type" id="">
  <option value="nam">Tên</option>
  <option value="age">Tuổi</option>
  <option value="email">email</option>
  <option value="phone">Số Điện Thoại</option>
</select>
<button type="submit">Tìm Kiếm</button>
</form>



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