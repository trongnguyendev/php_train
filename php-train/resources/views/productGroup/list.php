<div class="search-container">
  <form class="form-search" action="/product-group" method="GET">
    <input type="text" name="content_search" id="tagInput" placeholder="Nhập giá trị và nhấn Enter" value="<?= $oldSearch['search_content'] ?? '' ?>">
    <button type="submit">Tìm kiếm</button>
    <button id="resetBtn">Reset</button>
  </form>
  <button class="btn-create">
    <a href="/product-group/create">+ Tạo mới</a>
  </button>
</div>

<div class="list">
  <?php if (empty($productGroup)): ?>
    <p class="no-data">Không có dữ liệu</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="modern-table">
        <thead>
          <tr>
            <th>Tên Sản Phẩm</th>
            <th>Giá</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($productGroup as $index => $emp): ?>
            <tr>
              <td><?= htmlspecialchars($emp['name']) ?></td>
              <td><?= htmlspecialchars($emp['price']) ?></td>
              <td>
                <a href="/product-group/edit/<?= $emp['id'] ?>" class="icon-btn edit" title="Cập nhật"><i class="fa fa-pen"></i></a>
                <a href="/product-group/delete/<?= $emp['id'] ?>" class="icon-btn delete" title="Xoá"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>