<?php

require_once 'Base.php';

class Customer extends Base {

    /**
     * Đường dẫn tới file dữ liệu.
     * @var string
     */
    public $filePath = '../data/customer.txt';

    /**
     * Các trường dữ liệu cần xử lý trong file (ví dụ: name, email, age).
     * @var array
     */
    public $fields = [
        'name',
        'phone',
        'address',
        'province',
        'quantity',
        'product',
    ];
    public $rules = [
        'name' => 'required',
        'phone' => 'required',
        'product' => 'required'
    ];
}