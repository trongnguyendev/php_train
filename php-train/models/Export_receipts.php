<?php

namespace Models;

use Core\Model;

class Export_receipts extends Model {
    protected $table = 'export_receipts';

    protected $fk = 'warehouse_id';
}