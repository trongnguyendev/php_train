<?php

namespace Models;

use Core\Model;

class Import_receipts extends Model {
    protected $table = 'import_receipts';

    protected $fk = 'warehouse_id';
}