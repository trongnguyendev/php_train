<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Stock;

class StockController extends Controller {
    public function index(Request $request = null)
    {
         $this->requireLogin();
        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('type', '') : '';

        $stock = new Stock();

        $stock = !empty($searchQuery)
                ? $stock->where('name', $searchQuery)
                : $stock->all();

        $data = [
            'pageTitle' => 'Danh sách tồn kho',
            'stock' => $stock,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('stock/list', $data);
    }

    public function create()
    {
        $this->view('stock/create', [
            'pageTitle' => 'Tạo mới Tồn Kho'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'warehouse' => 'required',
            'quantity' => 'required'
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên',
            'warehouse.required' => 'Bắt buộc nhập KHO',
            'quantity.required' => 'Bắt buộc nhập Số Lượng',
        ];

        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('stock/create', [
                'pageTitle' => 'Tạo mới Số Lượng',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
            ]);
            return;
        }

        $stock = new Stock();

        $store = $stock->create([
            'name' => $data['name'],
            'warehouse' => $data['warehouse'],
            'quantity' => $data['quantity'],
        ]);

        if ($store) {
            $this->redirect('/stocks');
            exit;
        }
    }

    public function edit($id)
    {
        $stock = new Stock();
        $this->view('stock/update', [
            'pageTitle' => 'Cập nhật Tồn Kho',
            'stockData' => $stock->whereOne('id', $id),
            'indexData' => $id
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'warehouse' => 'required|email',
            'quantity' => 'required'
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên',
            'warehouse.required' => 'Bắt buộc nhập KHO',
            'quantity.required' => 'Bắt buộc nhập Số lượng',
        ];

        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('stock/update', [
                'pageTitle' => 'Cập nhật Tồn Khô',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }

        $stock = new Stock();

        $update = $stock->update($id, [
            'name' => $data['name'],
            'warehouse' => $data['warehouse'],
            'quantity' => $data['quantity']
        ]);

        if ($update) {
            $this->redirect('/stock');
            exit;
        }
    }

    public function delete($id)
    {
        $stock = new Stock();
        $isDeleted = $stock->delete($id);
        if ($isDeleted) {
            $this->redirect('/stock');
            exit;
        }
    }
}