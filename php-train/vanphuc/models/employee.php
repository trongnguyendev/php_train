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
}