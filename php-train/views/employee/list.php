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
              <a href="/employee/update.php?id=<?= $index + 1 ?>">Cập nhật</a>
              <a href="/employee/delete.php?id=<?= $index + 1 ?>">Xoá</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <a class="btn-create" href="/employee/create.php">+ Tạo mới</a>
</div>