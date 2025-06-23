<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Import_receipts;
use Models\Warehouse;
use Models\Product;

class Import_receiptsController extends Controller {
    public function index(Request $request = null)
    {
         $this->requireLogin();
        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('type', '') : '';

        $import_receipts = new Import_receipts();

        $import_receiptsed = !empty($searchQuery)
                ? $import_receipts->where('name', $searchQuery)
                : $import_receipts->all();

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
    {   $warehouse = new Warehouse ();
        $warehoused = $warehouse->all();

        $product = new Product ();
        $products = $product->all();
        $this->view('import_receipts/create', [
            'warehoused' => $warehoused,
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
            'devlivered_at' => 'required'
        ];

        $messages = [
            'warehouse.required' => 'Bắt buộc nhập KHO',
            'code.required' => 'Bắt buộc nhập Mã Tạo Đơn',
            'devlivered_at.required' => 'Bắt buộc nhập Ngày Tạo',
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

        $store = $import_receipts->create([
            'warehouse_id' => $data['warehouse'],
            'code' => $data['code'],
            'devlivered_at' => $data['devlivered_at'],
        ]);

        if ($store) {
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
            'warehouse' => 'required',
            'code' => 'required|email',
            'devlivered_at' => 'required'
        ];

        $messages = [
            'warehouse.required' => 'Bắt buộc nhập KHO',
            'code.required' => 'Bắt buộc nhập Mã Tạo Phiếu',
            'devlivered_at.required' => 'Bắt buộc nhập Ngày Tạo',
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
            'devlivered_at' => $data['devlivered_at']
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
}