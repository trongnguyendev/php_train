<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 style="text-align: center;">Chi tiết Sản Phẩm Full Bộ: <?= $data['groupInfo']['name'] ?></h2>
    </div>
  </div>
</div>
<div class="list">
  <?php if (empty($data['dataProducts'])): ?>
    <p class="no-data">Không có dữ liệu</p>
  <?php else: ?>
    <table>
      <thead> 
        <tr>
          <th>Tên Sản Phẩm</th>
          <th>Giá Sản Phẩm</th>
          <th>Số Lượng</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data['dataProducts'] as $index => $receipt): ?>
            <tr>
              <td><?= isset($receipt['name']) ? htmlspecialchars($receipt['name']) : '' ?></td>
              <td><?= isset($receipt['price']) ? htmlspecialchars($receipt['price']) : '' ?></td>
              <td><?= isset($receipt['quantity']) ? htmlspecialchars($receipt['quantity']) : '' ?></td>
              <td>
                <a href="/product-group/edit/<?= $receipt['id'] ?? ''?>">Cập nhật</a>
                <a href="/product-group/delete/<?= $receipt['id'] ?? ''?>">Xoá</a>
              </td>
            </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>