<?php
namespace Models;

use Core\Model;

class Login extends Model {
    // public $filePath = './data/user/data.txt';
    // public $fileds = [
    //     'username',
    //     'password',
    // ];

    // public function login($data){
    //     $username = $data['username'];
    //     $pass = $data['password'];
    //     $data = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    //     foreach ($data as $line){
    //     list($name, $email, $phone, $province, $password ) = explode(',',$line);
    //         if($username == $email && password_verify($pass, trim($password)))
    //         {
    //             $_SESSION['user_info'] = [
    //                 'name' => $name . ' ' . $phone
    //             ];
    //             return true;
    //         }
    //     }
    //     return false;
    // }


    public $table = 'user_name';

    public function login($data) {
        $username = $data['username'];
        $pass = $data['password'];

        $sql = "SELECT name, email, password FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':email', $username);
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user_info'] = [
                'name' => $user['name'] . ' ' . $user['phone']
            ];
            return true;
        }

        return false;
    }
}

