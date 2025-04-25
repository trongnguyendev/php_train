<?php
require_once 'base.php';
class Employee extends Base {
    public $filePath = '../data/employee.txt';

    public $rules = [
        'name' => 'required',
        'email' => 'required',
        'phone' => 'required',
    ];

    public $fields = [
        'name',
        'birthday',
        'email',
        'phone',
        'address',
    ];
}