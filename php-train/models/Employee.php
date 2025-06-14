<?php

namespace Models;

//use Models\Base;
use Core\Model;

class Employee extends Model {

    /**
     * Table name in the database
     * @var string
     */
    protected $table = 'employees';

     public function countEmployee() {
        $selectStr = "$this->table.name, $this->table.age
         COUNT($table.email) as count"
        // $sql = "SELECT  FROM {$this->table}";
        return $this->countEmp($selectStr);
    }
}