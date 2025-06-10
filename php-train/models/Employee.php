<?php

namespace Models;

// require_once 'Base.php';
use Core\Model;

class Employee extends Model {

    // /**
    //  * Đường dẫn tới file dữ liệu.
    //  * @var string
    //  */
    // public $filePath = './data/employee/data.txt';

    // /**
    //  * Các trường dữ liệu cần xử lý trong file (ví dụ: name, email, age).
    //  * @var array
    //  */
    // public $fields = [
    //     'name',
    //     'email',
    //     'age',
    // ];
    protected $table = 'employees';

}