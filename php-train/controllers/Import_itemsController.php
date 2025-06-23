<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Import_items;
use Models\Product;

class Import_itemsController extends Controller {
    public function index(Request $request = null)
    {
         $this->requireLogin();
        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('type', '') : '';

        $import_items = new Import_items();

        $import_itemsed = !empty($searchQuery)
                ? $import_items->where('name', $searchQuery)
                : $import_items->all();

        $data = [
            'pageTitle' => 'Danh sách Sản Phẩm Nhập Kho',
            'import_items' => $import_itemsed,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('import_items/list', $data);
    }

    public function create()
    {
        $product = new Product();
        $products = $product->all(;)
        $this->view('import_items/create', [
            'products' => $products;
            'pageTitle' => 'Tạo mới Sản Phẩm'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'product' => 'required',
            'quantity' => 'required|numeric',
        ];

        $messages = [
            'product.required' => 'Bắt buộc nhập Sản Phẩm',
            'quantity.required' => 'Bắt buộc nhập Số Lượng',
        ];

        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('import_items/create', [
                'pageTitle' => 'Tạo mới Sản Phẩm',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
            ]);
            return;
        }

        $Import_items = new Import_items();

        $store = $Import_items->create([
            'product' => $data['product'],
            'quantity' => $data['quantity'],
        ]);

        if ($store) {
            $this->redirect('/import_items');
            exit;
        }
    }

    public function edit($id)
    {
        $import_items = new Import_items();
        $this->view('import_items/update', [
            'pageTitle' => 'Cập nhật Sản Phẩm',
            'import_itemsData' => $import_items->whereOne('id', $id),
            'indexData' => $id
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $rules = [
            'product' => 'required',
            'quantity' => 'required'
        ];

        $messages = [
            'product.required' => 'Bắt buộc nhập Sản Phẩm',
            'quantity.required' => 'Bắt buộc nhập Số Lượng',
        ];

        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('import_items/update', [
                'pageTitle' => 'Cập nhật Sản Phẩm',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }

        $import_items = new Import_items();

        $update = $import_items->update($id, [
            'product' => $data['product'],
            'quantity' => $data['quantity']
        ]);

        if ($update) {
            $this->redirect('/import_items');
            exit;
        }
    }

    public function delete($id)
    {
        $import_items = new Import_items();
        $isDeleted = $import_items->delete($id);
        if ($isDeleted) {
            $this->redirect('/import_items');
            exit;
        }
    }
}