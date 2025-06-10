<?php

namespace Models;

use Core\Model;

class Product extends Base {

    // /**
    //  * Đường dẫn tới file dữ liệu.
    //  * @var string
    //  */
    // public $filePath = './data/product/data.txt';

    // /**
    //  * Các trường dữ liệu cần xử lý trong file (ví dụ: name, email, age).
    //  * @var array
    //  */
    // public $fields = [
    //     'name',
    //     'sku',
    //     'quantity',
    //     'warehouse',
    //     'img'
    // ];
    protected $table = 'product';
}