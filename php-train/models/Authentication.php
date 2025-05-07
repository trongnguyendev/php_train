<?php

require_once 'Base.php';

class Authentication extends Base{
    public $filePath = '../data/user/user.txt';

    public function login($username, $password) {
        // Read the file and parse the data
        $data = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($data as $line) {
            list($user, $email, $lastname, $firstname, $is_verified , $pass) = explode(',', $line);
            if ($user === $username && password_verify($password, trim($pass))) {
                $_SESSION['user_info'] = [
                    'name' => $firstname . ' ' . $lastname
                ];
                return true;
            }
        }
        $_SESSION['old_input'] = [
            'username' => $username,
            'password' => $password,
        ];
        $_SESSION['errors'] = [
            'error_authenticate' => 'Kiểm tra lại tên đăng nhập hoặc mật khẩu!',
        ];
        return false;
    }

    public function isLogined() {
        return isset($_SESSION['user_info']);
    }

    public function logout() {
        session_destroy();
    }
}