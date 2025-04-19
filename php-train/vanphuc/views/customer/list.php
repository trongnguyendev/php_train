<?php
  $selectedAge = $oldSearch['search_type'];
  $selectedSearch = $oldSearch['search_content'];
?>
<form class="form-search" action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET">
  <input type="contet_search" name="search" value="<?=$selectedSearch ?? ''?>">
  <select name="type" id="">
    <option value="name" <?= $selectedAge === 'name' ? 'selected' : ''; ?>>Tên Khách Hàng</option>
    <option value="phone" <?= $selectedAge === 'phone' ? 'selected' : ''; ?> >Số Điện Thoại</option>
  </select>
  <button type="submot">Tìm Kiếm</button>
</form>


<div class="list">
  <?php if (empty($customers)): ?>
    <p class="no-data">Không có dữ liệu</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Tên Khách Hàng</th>
          <th>Số Điện Thoại</th>
          <th>Địa Chỉ</th>
          <th>Số Lượng</th>
          <th>Sản Phẩm</th>
          <th>Hành Động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($customers as $index => $emp): ?>
          <tr>
            <td><?= htmlspecialchars($emp[0]); ?></td>
            <td><?= htmlspecialchars($emp[1]); ?></td>
            <td><?= htmlspecialchars($emp[2]); ?></td>  
            <td><?= htmlspecialchars($emp[3]); ?></td>
            <td><?= htmlspecialchars($emp[4]); ?></td>

            <td>
              <a href="update.php?id=<?= $index + 1 ?>">Cập nhật</a>
              <a href="delete.php?id=<?= $index + 1 ?>">Xoá</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <a class="btn-create" href="/customer/create.php">+ Tạo mới</a>
</div>