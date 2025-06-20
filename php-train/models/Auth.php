<?php
namespace Models;

use Core\Model;

class Auth extends Model {
    public $table = 'users';

    public function login($data) {
        $email = $data['email'];
        $pass = $data['password'];

        $user = $this->whereOne('email', $email);

        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user_info'] = $user['name'] . ' ' . $user['phone'];
            return true;
        }

        return false;
    }
}

