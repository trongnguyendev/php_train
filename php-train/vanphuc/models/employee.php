<?php
require_once('base.php');
class Employee extends Base {

    public $filePath = '../data/employee/employee.txt';
    public $fields = [
        'name',
        'age',
        'email',
        'phone'
    ];

    public $rules = [
        'name' => 'required',
        'email' => 'required',
    ];
    public $columnMap = [
        'name' => 0,
        'age' => 1,
        'email' => 2,
        'phone' => 3,
    ];

}