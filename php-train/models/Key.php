<?php

namespace Models;

use Core\Model;

class Key extends Model {
    protected $table = 'bundle';

    protected $fk = 'full_bo_sanpham_id';
}