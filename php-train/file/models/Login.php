<?php
namespace Models;

use Models\Base;

class Login extends Base {
    public $filePath = './data/user/data.txt';
    public $fileds = [
        'username',
        'password',
    ];

    public function login($data){
        $username = $data['username'];
        $pass = $data['password'];
        $data = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($data as $line){
        list($name, $email, $phone, $province, $password ) = explode(',',$line);
            if($username == $email && password_verify($pass, trim($password)))
            {
                $_SESSION['user_info'] = [
                    'name' => $name . ' ' . $phone
                ];
                return true;
            }
        }
        return false;
    }
}