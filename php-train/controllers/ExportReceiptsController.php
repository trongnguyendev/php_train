<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Export_receipts;
use Models\Warehouse;
use Models\Product;
use Models\Export_items;
use Core\Database;

class ExportReceiptsController extends Controller {
    public function index(Request $request = null)
    {
         $this->requireLogin();
        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('type', '') : '';

        $export_receipts = new Export_receipts();

        $warehouse = new Warehouse;
        $tableRelation = $warehouse->getTable();
        $fk = $export_receipts->getFk();

        $columnSelection = [
            'warehouses.name',
            'export_receipts.code',
            'export_receipts.delivered_at',
            'export_receipts.note',
            'export_receipts.id'
        ];

        $export_receiptsed = !empty($searchQuery)
                ? $export_receipts->where('name', $searchQuery)
                : $export_receipts->allWidth($tableRelation,$fk,$columnSelection);

        $data = [
            'pageTitle' => 'Danh sách nhân viên',
            'export_receipts' => $export_receiptsed,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('exportReceipts/list', $data);
    }

    public function create()
    {
        $warehouse = new Warehouse();
        $warehouses = $warehouse->all();

        $product = new Product();
        $products = $product->all();
        $this->view('exportReceipts/create', [
            'warehouses' => $warehouses,
            'products' => $products,
            'pageTitle' => 'Tạo mới Phiếu Xuất'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'warehouse' => 'required',
            'code' => 'required',
            'delivered_at' => 'required',
            'products' => 'required',
            'quantities' => 'required',
        ];

        $messages = [
            'warehouse.required' => 'Bắt buộc nhập KHO',
            'code.required' => 'Bắt buộc nhập Mã Tạo Đơn',
            'delivered_at.required' => 'Bắt buộc nhập Ngày Tạo',
            'products.required' => 'Bắt buộc chọn sản phẩm',
            'quantities.required' => 'Bắt buộc nhập số lượng',
        ];


        $validator = new Validation($data, $rules, $messages);
        $warehouses = (new Warehouse())->all();

        if (!$validator->validate()) {
            $this->view('exportReceipts/create', [
                'pageTitle' => 'Tạo mới Phiếu Xuất Kho',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'warehouses' => $warehouses,
            ]);
        }

        $db = Database::getInstance();

        try {
            $db->beginTransaction();

            $export_receipts = new Export_receipts();
            $storeId = $export_receipts->create([
                'warehouse_id' => $data['warehouse'],
                'code' => $data['code'],
                'delivered_at' => $data['delivered_at'],
                'note' => $data['note'],
            ]);

            $export_items = new Export_items();
            $productIds = explode(',', $data['products']);
            $quantities = $data['quantities'];

            foreach($productIds as $key => $ids) {
                $import_items->create([
                    'product_id' => $ids,
                    'quantity' => $quantities[$key],
                    'export_receipt_id' => $storeId
                ]);
            }

            $db->commit();
            $this->redirect('/export_receipts');
        } catch (\Exception $e) {
            // Rollback nếu có lỗi
            $db->rollback();
            // Xử lý lỗi...
            $this->view('exportReceipts/create', [
                'pageTitle' => 'Tạo mới Phiếu Xuất Kho',
                'errors' => ['error_system' => 'Lỗi hệ thống, vui lòng thử lại sau.'],
                'oldInput' => $data,
                'warehouses' => $warehouses,
            ]);
        }
    }

    public function edit($id)
    {
        // Lấy thông tin đơn nhập hàng (warehouse, danh sách sản phẩm, thông tin đơn nhập)
        $export_receipts = new Export_receipts();
        $export_receiptsData = $export_receipts->whereOne('id', $id);

        // Lấy tất cả các kho
        $warehouse = new Warehouse();
        $warehouses = $warehouse->all();

        // Lấy tất cả sản phẩm
        $product = new Product();
        $products = $product->all();

        // Lấy danh sách id của import_item
        $export_items = new Import_items();
        $export_item = $export_items->where('export_receipt_id', $id);
        // var_dump($import_item);

         $exportIdSelected = array_map(function ($products) {
            return $products['product_id'];
        }, $export_item);

        // Lấy danh sách các sản phẩm của đơn nhập hàng
        
        $this->view('exportReceipts/update', [
            'pageTitle' => 'Cập nhật Phiếu Xuất Kho',
            'export_receiptsData' => $import_receiptsData,
            'warehouses' => $warehouses,
            'products' => $products,
            'exportIdSelected' => $exportIdSelected,
            'indexData' => $id
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();



        // var_dump($data);
        // exit;

        $rules = [
            'warehouse' => 'required',
            'code' => 'required',
            'delivered_at' => 'required'
        ];
        $messages = [
            'warehouse.required' => 'Bắt buộc nhập KHO',
            'code.required' => 'Bắt buộc nhập Mã Tạo Phiếu',
            'delivered_at.required' => 'Bắt buộc nhập Ngày Tạo',
        ];
        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('exportReceipts/update', [
                'pageTitle' => 'Cập nhật Phiếu Xuất Kho',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }


        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $exportReceiptsData = new Export_receipts();
            $exports_items = new Export_items();

            $exportReceiptsDatas = $exportReceiptsData->update( $id, [
                'warehouse_id' => $data['warehouse'],
                'code' => $data['code'],
                'delivered_at' => $data['delivered_at'],
                'note' => $data['note'],
            ]);

            $exportsItems = $exports_items->where('export_receipt_id', $id);

            foreach ($exportsItems as $keyItem) {
                $deleteProduct = $exports_items->delete($keyItem['id']);
            };

            // var_dump($data['products']);
            // exit;
            foreach ($data['products'] as $item) {
                if (empty($item['id']) || !is_numeric($item['id'])) continue;
                $created = $exports_items->create([
                    'export_receipt_id' => $id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty']
                ]);
            }

            // Cập nhật tồn kho
            // $stock = new Stock();
            // $stockInfo = $stock->where([
            //     'product_id' => 1,
            //     'warehouse_id' => 3
            // ]);

            // $quantityOld = $stockInfo['quantity'];
            // $newQUantity = 6;

            // $dataUpdate = [
            //     'quantity' => ($quantityOld + $newQUantity)
            // ]

            // $stock->update($stockInfo['id'], $dataUpdate);


            $db->commit();

            $this->redirect('/export_receipts');

        } catch (\Exception $e) {
            $db->rollback();
            return $this->view('exportReceipts/update', [
                'pageTitle' => 'Cập Nhập Full Bộ Sản Phẩm',
                'errors' => ['error_system' => 'Lỗi hệ thống: ' . $e->getMessage()],
                'oldInput' => $data,
                'indexData' => $id
            ]);
        };

    }
    //     $import_receipts = new Import_receipts();

    //     $update = $import_receipts->update($id, [
    //         'warehouse' => $data['warehouse'],
    //         'code' => $data['code'],
    //         'revlivered_at' => $data['revlivered_at']
    //     ]);

    //     if ($update) {
    //         $this->redirect('/import_receipts');
    //         exit;
    //     }
    // }

    public function delete($id)
    {
        $export_receipts = new Export_receipts();
        $isDeleted = $export_receipts->delete($id);
        if ($isDeleted) {
            $this->redirect('/export_receipts');
            exit;
        }
    }

    public function indexItems($id) {
        $export_items = new Export_items();

        $data = $export_items->getInfoImport(
            $id,
            [
                'export_items.id',
                'export_items.quantity',
                'products.name',
                'warehouses.name AS warehouse_name'
            ]
        );

        // Lấy tên kho từ dòng đầu tiên
        $warehouseName = !empty($data) ? $data[0]['warehouse_name'] : '';

        $this->view('exportReceipts/list_items', [
            'pageTitle' => 'Chi tiết phiếu nhập',
            'indexItems' => [
                'warehouse_name' => $warehouseName,
                'exportItems' => $data
            ]
        ]);
    }


}