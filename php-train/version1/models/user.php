<?php
require_once 'base.php';
class User extends Base {
    public $filePath = '../data/user.txt';
    public $rules = [
        'username' => 'required',
        'email' => 'required',
        'firstname' => 'required',
        'password' => 'required',
    ];

    public $fields = [
        'username',
        'email',
        'lastname',
        'firstname',
        'verified',
        'password',
    ];

}