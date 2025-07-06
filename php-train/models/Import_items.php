<?php

namespace Models;

use Core\Model;

// class Import_items extends Model {
//     protected $table = 'import_items';

//     public function getInfoImport($idReceipt, $tableRelation, $fk, $columnSelection = []) {
//         $columnStr = implode (',', $columnSelection);
//         $warehouseSql = "SELECT * FROM import_receipts INNER JOIN warehouses ON warehouses.id = import_receipts.warehouse_id WHERE import_receipts.id = {$idReceipt}";
//         $dataWarehouse = $this->db->select($warehouseSql);
//         $wareHouseName = $dataWarehouse[0]['name'];
        
//         $sql = "SELECT {$columnStr} FROM {$this->table} INNER JOIN {$tableRelation} ON {$tableRelation}.id = {$this->table}.{$fk}";
//         $dataImportItems = $this->db->select($sql);

//         return [
//             'warehouse_name' => $wareHouseName,
//             'importItems' => $dataImportItems
//         ];
//     }

    class Import_items extends Model {
        protected $table = 'import_items';

        public function getInfoImport($idReceipt, $columnSelection = []) {
                // // Thêm tên kho vào danh sách cột nếu chưa có
                // if (!in_array('warehouses.name AS warehouse_name', $columnSelection)) {
                //     $columnSelection[] = 'warehouses.name AS warehouse_name';
                // }

                // Ghép SELECT
                $columnStr = implode(',', $columnSelection);

                // SELECT kết hợp 3 bảng: products, import_receipts, warehouses
                $sql = "
                    SELECT {$columnStr}
                    FROM {$this->table}
                    INNER JOIN products ON products.id = {$this->table}.product_id
                    INNER JOIN import_receipts ON import_receipts.id = {$this->table}.import_receipt_id
                    INNER JOIN warehouses ON warehouses.id = import_receipts.warehouse_id
                    WHERE {$this->table}.import_receipt_id = {$idReceipt}
                ";
            
            return $this->db->select($sql);
        }
}


    