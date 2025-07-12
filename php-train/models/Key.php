<?php

namespace Models;

use Core\Model;

class Key extends Model {
    protected $table = 'bundle';

    protected $fk = 'full_bo_sanpham_id';
    
    public function getInfoImport() {
            $sql = "
                SELECT full_bo_sanpham.name, sanpham.name, sanpham.code, sanpham.price,bundle.quantity 
                FROM bundle 
                INNER JOIN sanpham ON bundle.sanpham_id = sanpham.id 
                INNER JOIN full_bo_sanpham ON bundle.full_bo_sanpham_id = full_bo_sanpham.id;
            ";
        
        return $this->db->select($sql);
    }
}