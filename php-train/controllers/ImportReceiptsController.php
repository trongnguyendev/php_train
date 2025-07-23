<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Import_receipts;
use Models\Warehouse;
use Models\Product;
use Models\Import_items;
use Core\Database;

class ImportReceiptsController extends Controller {
    public function index(Request $request = null)
    {
         $this->requireLogin();
        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('type', '') : '';

        $import_receipts = new Import_receipts();

        $warehouse = new Warehouse;
        $tableRelation = $warehouse->getTable();
        $fk = $import_receipts->getFk();

        $columnSelection = [
            'warehouses.name',
            'import_receipts.code',
            'import_receipts.received_at',
            'import_receipts.note',
            'import_receipts.id'
        ];

        $import_receiptsed = !empty($searchQuery)
                ? $import_receipts->where('name', $searchQuery)
                : $import_receipts->allWidth($tableRelation,$fk,$columnSelection);

        $data = [
            'pageTitle' => 'Danh sách nhân viên',
            'import_receipts' => $import_receiptsed,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('importReceipts/list', $data);
    }

    public function create()
    {
        $warehouse = new Warehouse();
        $warehouses = $warehouse->all();

        $product = new Product();
        $products = $product->all();
        $this->view('importReceipts/create', [
            'warehouses' => $warehouses,
            'products' => $products,
            'pageTitle' => 'Tạo mới Phiếu Nhập'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'warehouse' => 'required',
            'code' => 'required',
            'received_at' => 'required',
            'products' => 'required',
            'quantities' => 'required',
        ];

        $messages = [
            'warehouse.required' => 'Bắt buộc nhập KHO',
            'code.required' => 'Bắt buộc nhập Mã Tạo Đơn',
            'received_at.required' => 'Bắt buộc nhập Ngày Tạo',
            'products.required' => 'Bắt buộc chọn sản phẩm',
            'quantities.required' => 'Bắt buộc nhập số lượng',
        ];


        $validator = new Validation($data, $rules, $messages);
        $warehouses = (new Warehouse())->all();

        if (!$validator->validate()) {
            $this->view('importReceipts/create', [
                'pageTitle' => 'Tạo mới Phiếu Nhập Kho',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'warehouses' => $warehouses,
            ]);
        }

        $db = Database::getInstance();

        try {
            $db->beginTransaction();

            $import_receipts = new Import_receipts();
            $storeId = $import_receipts->create([
                'warehouse_id' => $data['warehouse'],
                'code' => $data['code'],
                'received_at' => $data['received_at'],
                'note' => $data['note'],
            ]);

            $import_items = new Import_items();
            $productIds = explode(',', $data['products']);
            $quantities = $data['quantities'];

            foreach($productIds as $key => $ids) {
                $import_items->create([
                    'product_id' => $ids,
                    'quantity' => $quantities[$key],
                    'import_receipt_id' => $storeId
                ]);
            }

            $db->commit();
            $this->redirect('/import_receipts');
        } catch (\Exception $e) {
            // Rollback nếu có lỗi
            $db->rollback();
            // Xử lý lỗi...
            $this->view('importReceipts/create', [
                'pageTitle' => 'Tạo mới Phiếu Nhập Kho',
                'errors' => ['error_system' => 'Lỗi hệ thống, vui lòng thử lại sau.'],
                'oldInput' => $data,
                'warehouses' => $warehouses,
            ]);
        }
    }

    public function edit($id)
    {
        $import_receipts = new Import_receipts();
        $this->view('importReceipts/update', [
            'pageTitle' => 'Cập nhật Phiếu Nhập Kho',
            'import_receiptsData' => $import_receipts->whereOne('id', $id),
            'indexData' => $id
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $rules = [
            'received_at' => 'required',
            'code' => 'required|email',
            'received_at' => 'required'
        ];
        $messages = [
            'received_at.required' => 'Bắt buộc nhập KHO',
            'code.required' => 'Bắt buộc nhập Mã Tạo Phiếu',
            'received_at.required' => 'Bắt buộc nhập Ngày Tạo',
        ];
        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('importReceipts/update', [
                'pageTitle' => 'Cập nhật Phiếu Nhập Kho',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }

        $import_receipts = new Import_receipts();

        $update = $import_receipts->update($id, [
            'warehouse' => $data['warehouse'],
            'code' => $data['code'],
            'revlivered_at' => $data['revlivered_at']
        ]);

        if ($update) {
            $this->redirect('/import_receipts');
            exit;
        }
    }

    public function delete($id)
    {
        $import_receipts = new import_receipts();
        $isDeleted = $import_receipts->delete($id);
        if ($isDeleted) {
            $this->redirect('/import_receipts');
            exit;
        }
    }

    public function indexItems($id) {
        $import_items = new Import_items();

        $data = $import_items->getInfoImport(
            $id,
            [
                'import_items.id',
                'import_items.quantity',
                'products.name',
                'warehouses.name AS warehouse_name'
            ]
        );

        // Lấy tên kho từ dòng đầu tiên
        $warehouseName = !empty($data) ? $data[0]['warehouse_name'] : '';

        $this->view('importReceipts/list_items', [
            'pageTitle' => 'Chi tiết phiếu nhập',
            'indexItems' => [
                'warehouse_name' => $warehouseName,
                'importItems' => $data
            ]
        ]);
    }


}