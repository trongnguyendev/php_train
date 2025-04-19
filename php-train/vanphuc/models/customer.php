<?php
require_once('base.php');
class Customer extends Base {

    public $filePath = '../data/customer/customer.txt';
    public $rules = [
        'name' => 'required',
        'phone' => 'required',
        'quantity' => 'required'
    ];
    public $fields = [
        'name',
        'phone',
        'address',
        'quantity',
        'product',
    ];

    public $columnMap = [
        'name' => 0,
        'phone' => 1,
    ];

}