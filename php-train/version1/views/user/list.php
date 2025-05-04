<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {

        }

        .list {
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-list {
            background: rgb(255 255 255 / 56%);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            width: 400px;
            border: 10px solid #ffffff;
        }
        .form-row {
          padding: 40px;
          border: 1px solid #ccc;
          border-radius: 5px;
          background: linear-gradient(135deg,rgb(219, 231, 129),rgb(70, 99, 226));
        
        }

        .input {
            width: 100%;
            padding: 12px;
            background-color:rgb(176, 51, 5);
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .input:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="search-form" >


</div>
    <div class="list">
    <table class="form-list">
      <tr class="form-row">
        <th>Username</th>
        <th>Email</th>
        <th>Họ</th>
        <th>Tên</th>
        <th>Xác Thực</th>
        <th>Mật Khẩu</th>
        <th>Trạng Thái</th>
      </tr>
        <?php foreach($users as $key => $item):?>
      <tr>
        <td><?= htmlspecialchars($item[0])?></td>
        <td><?= htmlspecialchars($item[1])?></td>
        <td><?= htmlspecialchars($item[2])?></td>
        <td><?= htmlspecialchars($item[3])?></td>
        <td><?= htmlspecialchars($item[4])?></td>
        <td><?= htmlspecialchars($item[5])?></td>
        <td class="input">
            <a href="update.php?id=<?= $key + 1 ?>"> Cập Nhập </a>
        </td>
        <td class="input">
            <a href="delete.php?id=<?= $key + 1 ?>"> Xóa </a>
        </td>
      </tr>
        <?php endforeach;?>
    </table>
    </div>
</body>
</html>