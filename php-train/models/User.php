<?php

namespace Models;

use Core\model;

class User extends Base {

    // /**
    //  * Đường dẫn tới file dữ liệu.
    //  * @var string
    //  */
    // public $filePath = './data/user/data.txt';

    // /**
    //  * Các trường dữ liệu cần xử lý trong file (ví dụ: name, email, age).
    //  * @var array
    //  */
    // public $fields = [
    //     'name',
    //     'email',
    //     'age',
    //     'phone',
    //     'province',
    //     'password',
    // ];

    protected $table = 'User';
}