<?php
$options = ['name' => 'Tên Nhân Viên', 'email' => 'Email', 'phone' => 'Số Điện Thoại'];
$selectedValue = oldInput('search_type', $oldSearch ?? '');
$oldContent = oldInput('search_content', $oldSearch ?? '');
?>

<div class="">
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET">
        <div>
            <input type="text" name="content_search" placeholder="Nhập giá trị và nhấn Enter">
        </div>
        <input type="hidden" name="tags_search">
        <select name="type_option" id="">
            <?php foreach($options as $key => $label):?>
                <option value="<?= $key?>" <?= $key=== $selectedValue ? 'selected' : '' ?>>
                    <?= $label?>
                </option>
                <?php endforeach; ?>
        </select>
            <button type="submit">Tìm Kiếm</button>
    </form>
</div>




<div class="list">
    <?php if(empty($employees)): ?>
        <p class="no-data"> KHông có dữ liệu</p>
    <?php else: ?>
    <table>
        <thead> 
            <tr>
            <th>Tên Nhân Viên</th>
            <th>Ngày Sinh</th>
            <th>Email</th>
            <th>Số Điện Thoại</th>
            <th>Địa Chỉ</th>
            <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $index => $emp): ?>
            <tr>
                <td><?= htmlspecialchars($emp[0]) ?></td>
                <td><?= htmlspecialchars($emp[1]) ?></td>
                <td><?= htmlspecialchars($emp[2]); ?></td>
                <td><?= htmlspecialchars($emp[3]) ?></td>
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
</div>