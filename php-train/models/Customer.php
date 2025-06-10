<?php

namespace Models;
// require_once 'Base.php';
use Core\Model;

    
class Customer extends Model {
   /**
     * Đường dẫn tới file dữ liệu.
     * @var string
     */
    // public $filePath = './data/customer/data.txt';

    // /**
    //  * Các trường dữ liệu cần xử lý trong file (ví dụ: name, email, age).
    //  * @var array
    //  */
    // public $fields = [
    //     'name',
    //     'email',
    //     'phone',
    //     'province',
    //     'address',
    //     'age',
    // ];
    protected $table = 'Customer';
}