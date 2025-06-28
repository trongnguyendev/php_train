<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Import_receipts;
use Models\Warehouse;
use Models\Product;
use Models\Import_items;

class Import_receiptsController extends Controller {
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
        $this->view('import_receipts/list', $data);
    }

    public function create()
    {
        $warehouse = new Warehouse();
        $warehouses = $warehouse->all();

        $product = new Product();
        $products = $product->all();
        $this->view('import_receipts/create', [
            'warehouses' => $warehouses,
            'products' => $products,
            'pageTitle' => 'Tạo mới Phiếu Nhập'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'warehouse_id' => 'required',
            'code' => 'required',
            'received_at' => 'required',
            'products' => 'required|array',
            'quantities' => 'required|array',
        ];

        $messages = [
            'warehouse_id.required' => 'Bắt buộc nhập KHO',
            'code.required' => 'Bắt buộc nhập Mã Tạo Đơn',
            'received_at.required' => 'Bắt buộc nhập Ngày Tạo',
            'products.required' => 'Bắt buộc chọn sản phẩm',
            'products.array' => 'Sản phẩm phải là một mảng',
        ];

        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('import_receipts/create', [
                'pageTitle' => 'Tạo mới Phiếu Nhập Kho',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
            ]);
            return;
        }

        $import_receipts = new Import_receipts();

        $storeId = $import_receipts->create([
            'warehouse_id' => $data['warehouse_id'],
            'code' => $data['code'],
            'received_at' => $data['received_at'],
            'note' => $data['note'],
        ]);

        if ($storeId) {
             $import_items = new Import_items ();


            $productIds = $data['products']; // <div 1,2,3=""></div>
            $quantities = $data['quantities']; // []

            foreach($productIds as $ids) {
                $store_items = $import_items->create([
                    'product_id' => $productIds,
                    'quantity' => $quantities,
                    'import_receipt_id' => $storeId
                ]);
            }
            // $store_items = $import_items->create([
            //     'product_id' => $data['product'],
            //     'quantity' => $data['quantity'],
            //     'import_receipt_id' => $storeId
            // ]);
        }


        if ($store_items) {
            $this->redirect('/import_receipts');
            exit;
        }
    }

    public function edit($id)
    {
        $import_receipts = new Import_receipts();
        $this->view('import_receipts/update', [
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
            $this->view('import_receipts/update', [
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
        
        $this->view('import_receipts/list_items', [
            'pageTitle' => 'Cập nhật Chi Tiết Phiếu Nhập',
            'indexItems' => $import_items->getInfoImport($id, 'products.name', 'products', [
                'import_items.warehouses_id',
                'products.name',
                'products.quantity'
            ])
        ]);
    }


}