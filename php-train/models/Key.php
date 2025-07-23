<?php

namespace Models;

use Core\Model;

class Key extends Model {
    protected $table = 'bundle';

    protected $fk = 'product_group_id';
    
    public function getInfoProductGroup($id) {
        $sql = "
            select *
            from bundle
            INNER JOIN products ON bundle.product_id = products.id
            where bundle.product_group_id= $id;
        ";
    
    return $this->db->select($sql);
}
}