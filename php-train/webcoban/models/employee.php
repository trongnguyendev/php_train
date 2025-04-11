<?php

require_once 'Base.php';

class Employee extends Base {

    /**
     * Đường dẫn tới file dữ liệu.
     * @var string
     */
    public $filePath = '../data/employee.txt';

    /**
     * Các trường dữ liệu cần xử lý trong file (ví dụ: name, email, age).
     * @var array
     */
    public $fields = [
        'name',
        'email',
        'age',
    ];

    public $rules = [
        'name' => 'required',
        'email' => 'required',
        'age' => 'required|max:100'
    ];
}