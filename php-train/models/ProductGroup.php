<?php

namespace Models;
use Core\Model;

class ProductGroup extends Model {
    protected $table = 'product_group';

    public function getInfoProductGroup($id) {
            $sql = "
                SELEC
                FROM bundle 
                INNER JOIN products ON bundle.product = product.id 
                INNER JOIN product_group ON bundle.full_bo_sanpham_id = product_group.id
                WHERE product_group.id = $id;
            ";
        
        return $this->db->select($sql);
    }
}