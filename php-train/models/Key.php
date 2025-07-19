<?php

namespace Models;

use Core\Model;

class Key extends Model {
    protected $table = 'bundle';

    protected $fk = 'full_bo_sanpham_id';
    
    public function getInfoProductGroup($id) {
            $sql = "
                SELECT product_group.name, product.name, product.code, product.price, bundle.quantity 
                FROM bundle 
                INNER JOIN product ON bundle.product = product.id 
                INNER JOIN product_group ON bundle.full_bo_sanpham_id = product_group.id
                WHERE product_group.id = $id;
            ";
        
        return $this->db->select($sql);
    }
}