<?php
require_once 'base.php';

class Questions extends Base {
    public $filePath = '../data/questions.txt';
    public $fields = [
        'exam',
        'question',
        'answer',
    ];
}