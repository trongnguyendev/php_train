<?php

require_once 'Base.php';
require_once 'Role.php';

class User extends Base {
    public $filePath = '../data/user/user.txt';
    public $rules = [
        'username' => 'required'
    ];

    public $fields = [
        'username',
        'email',
        'lastname',
        'firstname',
        'is_verified',
        'password',
        'role',
    ];
    public $columnMap = [
        'username' => 0,
        'email' => 1,
        'lastname' => 0,
    ];
}