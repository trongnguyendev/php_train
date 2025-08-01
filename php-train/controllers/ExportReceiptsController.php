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
            'pageTitle' => 'Danh sách Phiếu Xuất Mới',
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
                $export_items->create([
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
        $export_receipts = new Export_receipts();
        $this->view('exportReceipts/update', [
            'pageTitle' => 'Cập nhật Phiếu Nhập Kho',
            'export_receiptsData' => $export_receipts->whereOne('id', $id),
            'indexData' => $id
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $rules = [
            'received_at' => 'required',
            'code' => 'required|email',
            'delivered_at' => 'required'
        ];
        $messages = [
            'delivered_at.required' => 'Bắt buộc nhập KHO',
            'code.required' => 'Bắt buộc nhập Mã Tạo Phiếu',
            'delivered_at.required' => 'Bắt buộc nhập Ngày Tạo',
        ];
        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('exportReceipts/update', [
                'pageTitle' => 'Cập nhật Phiếu Nhập Kho',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }

        $export_receipts = new Export_receipts();

        $update = $import_receipts->update($id, [
            'warehouse' => $data['warehouse'],
            'code' => $data['code'],
            'delivered_at' => $data['delivered_at']
        ]);

        if ($update) {
            $this->redirect('/export_receipts');
            exit;
        }
    }

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