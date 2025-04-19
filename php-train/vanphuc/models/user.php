<?php
require_once('base.php');
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
    ];
}