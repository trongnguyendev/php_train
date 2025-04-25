<?php
require_once 'base.php';

class Customer extends Base {

    public  $filePath = '../data/customer.txt';
    
    public $rules = [
        'name' => 'required',
        'phone' => 'required',
        'product' => 'required',
    ];

    public $fields = [
        'name',
        'phone',
        'province',
        'quantity',
        'product',
    ];
}