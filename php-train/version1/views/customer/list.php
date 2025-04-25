



<div>
  <?php if(empty($customers)):?>
      <p class="no-da-ta">Không Có Dữ Liệu</p>
  <?php else: ?> 
    <table >
      <thead>
        <tr>
          <th>Tên Khách Hàng</th>
          <th>Số Điện Thoại</th>
          <th>Địa Chỉ</th>
          <th>Số Lượng</th>
          <th>Sản Phẩm</th>
          <th>Trạng Thái</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($customers as $key => $value): ?>
        <tr>
          <td><?= htmlspecialchars($value[0])?></td>
          <td><?= htmlspecialchars($value[1])?></td>
          <td><?= htmlspecialchars($value[2])?></td>
          <td><?= htmlspecialchars($value[3])?></td>
          <td><?= htmlspecialchars($value[4]);?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  <?php endif; ?>
</div>