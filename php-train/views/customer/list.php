<style>
  .search-container {
      background: #fff;
      padding: 20px 25px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      display: flex;
      gap: 12px;
      width: 100%;
      max-width: 500px;
      margin-top: 20px;
    }

    .search-container input[type="text"] {
      flex: 1;
      padding: 12px 16px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 16px;
      transition: border-color 0.3s ease;
      width: 200px;
      margin: 0;
    }

    .search-container input[type="text"]:focus {
      border-color: #007bff;
      outline: none;
    }

    .search-container button {
      padding: 12px 20px;
      background-color: #007bff;
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin: 0px;
      width: 120px;
    }

    .search-container button:hover {
      background-color: #0056b3;
    }
  </style>
<form class="search-container" action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET">
  <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm...">
  <button type="submit">Tìm kiếm</button>
</form>

<div class="list">
  <?php if (empty($customers)): ?>
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
        <?php foreach ($customers as $index => $emp): ?>
          <tr>
            <td><?= htmlspecialchars($emp[0]); ?></td>
            <td><?= htmlspecialchars($emp[1]); ?></td>
            <td><?= htmlspecialchars($emp[2]); ?></td>
            <td>
              <a href="/customer/update.php?id=<?= $index + 1 ?>">Cập nhật</a>
              <a href="/customer/delete.php?id=<?= $index + 1 ?>">Xoá</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

<a class="btn-create" href="/customer/create.php">+ Tạo mới</a>
</div>