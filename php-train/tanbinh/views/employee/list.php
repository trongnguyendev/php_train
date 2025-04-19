<div class="list">
  <?php if (empty($employees)): ?>
    <p class="no-data">Không có dữ liệu</p>
  <?php else: ?>
<table>
  <tr>
    <th>Tên Nhân Viên</th>
    <th>Email</th>
    <th>Địa Chỉ</th>
    <th>Ngày Sinh</th>
    <th>Số Điện Thoại</th>
    <th>Trạng Thái</th>
  </tr>
  <?php foreach ($employees as $index => $emp): ?>
  <tr>
    <td><?php htmlspecialchars($emp[0])?></td>
    <td><?php htmlspecialchars($emp[1])?></td>
    <td><?php htmlspecialchars($emp[2])?></td>
    <td><?php htmlspecialchars($emp[3])?></td>
    <td><?php htmlspecialchars($emp[4])?></td>
    <td>
        <a href="update.php?id=<?= $index + 1 ?>">Cập nhật</a>
        <a href="delete.php?id=<?= $index + 1 ?>">Xoá</a>
  </td>
  <?php endforeach; ?>
  </tr>
</table>
  </div>