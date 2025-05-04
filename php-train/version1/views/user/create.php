<!-- <!DOCTYPE html>
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

        .create {
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .user-create {
            background: rgb(255 255 255 / 56%);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            width: 400px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #444;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #bbb;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body> -->
<<div class="create">
    <form class="user-create" action="process.php" method="POST">
        <div class="form-group">
        <label for="username">Username</label>
        <?php displayErrors('username', $errors) ?? '';?>
        <input type="text" name="username" value="<?php oldInput('username', $oldInput) ;?>">
        </div>

        <div class="form-group">
        <label for="email">Email</label>
        <?php displayErrors('email', $errors) ?? '';?>
        <input type="email" name="email" value="<?php oldInput('email', $oldInput);?>">
        </div>

        <div class="form-group">
        <label for="lastname">Tên</label>
        <input type="text" name="lastname" value="<?php oldInput('lastname', $oldInput);?>">
        </div>

        <div class="form-group">
        <label for="firstname">Họ</label>
        <?php displayErrors('firstname', $errors) ?? '';?>
        <input type="text" name="firstname" value="<?php oldInput('firstname', $oldInput);?>">
        </div>

        <div class="form-group">
        <label for="verified">Xác Thực</label>
        <input type="text" name="verified" value="<?php oldInput('verified', $oldInput);?>">
        </div>

        <div class="form-group">
        <label for="password">Mật Khẩu</label>
        <?php displayErrors('password', $errors) ?? '';?>
        <input type="password" name="password" value="<?php oldInput('password', $oldInput);?>">
        </div>

        <button type="submit">Gửi</button>

    </form>
</div>
<!-- </body>
</html> -->


