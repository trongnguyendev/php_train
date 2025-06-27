<?php

namespace Models;

use Core\Model;

class Import_items extends Model {
    protected $table = 'import_items';

    public function getInfoImport($idReceipt, $tableRelation, $fk, $columnSelection = []) {
        $columnStr = implode (',', $columnSelection);
        $warehouseSql = "SELECT * FROM import_receipts INNER JOIN warehouses ON warehouses.id = import_receipts.warehouse_id WHERE import_receipts.id = {$idReceipt}";
        $dataWarehouse = $this->db->select($warehouseSql);
        $wareHouseName = $dataWarehouse[0]['name'];
        
        $sql = "SELECT {$columnStr} FROM {$this->table} INNER JOIN {$tableRelation} ON {$tableRelation}.id = {$this->table}.{$fk}";
        $dataImportItems = $this->db->select($sql);

        return [
            'warehouse_name' => $wareHouseName,
            'importItems' => $dataImportItems
        ];
    }
    
}