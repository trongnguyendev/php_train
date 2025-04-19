<?php
require_once 'base.php';
class Employee extends Base {

    public $filePath = '../employee/employee.txt';
    public $rules = [
        'name' => 'required',
        'email' => 'required',
        'phone' => 'required',
    ];

    public $fields = [
        'name',
        'email',
        'address',
        'birthday',
        'phone',
    ];
}