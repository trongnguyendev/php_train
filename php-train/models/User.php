<?php

namespace Models;

use Models\Base;

class Employee extends Base {

    /**
     * Đường dẫn tới file dữ liệu.
     * @var string
     */
    public $filePath = './data/employee/data.txt';

    /**
     * Các trường dữ liệu cần xử lý trong file (ví dụ: name, email, age).
     * @var array
     */
    public $fields = [
        'name',
        'email',
        'age',
    ];
}