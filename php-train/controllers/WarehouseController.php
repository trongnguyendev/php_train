<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Warehouse;

class WarehouseController extends Controller {
    public function index(Request $request = null)
    {
         $this->requireLogin();
        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('type', '') : '';

        $warehouse = new Warehouse();
        $warehoused = !empty($searchQuery)
                ? $warehouse->where($searchType, $searchQuery)
                : $warehouse->all();

        $data = [
            'pageTitle' => 'Danh sách Kho',
            'warehoused' => $warehoused,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('warehouse/list', $data);
    }

    public function create()
    {
        $this->view('warehouse/create', [
            'pageTitle' => 'Tạo KHO'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'localtion' => 'required',
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập KHO',
            'localtion.required' => 'Bắt buộc nhập Vị Trí',
        ];

        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('warehouse/create', [
                'pageTitle' => 'Tạo KHO',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
            ]);
            return;
        }

        $warehouse = new Warehouse();

        $store = $warehouse->create([
            'name' => $data['name'],
            'localtion' => $data['localtion']
        ]);

        if ($store) {
            $this->redirect('/warehouse');
            exit;
        }
    }

    public function edit($id)
    {
        $warehouse = new Warehouse();
        $this->view('warehouse/update', [
            'pageTitle' => 'Cập nhật KHO',
            'warehouseData' => $warehouse->whereOne('id', $id),
            'indexData' => $id
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'localtion' => 'required'
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập KHO',
            'localtion.required' => 'Bắt buộc nhập Vị Trí'
        ];

        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('warehouse/update', [
                'pageTitle' => 'Cập nhật KHO',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }

        $warehouse = new Warehouse();

        $update = $warehouse->update($id, [
            'name' => $data['name'],
            'localtion' => $data['localtion']
        ]);

        if ($update) {
            $this->redirect('/warehouse');
            exit;
        }
    }

    public function delete($id)
    {
        $warehouse = new Warehouse();
        $isDeleted = $warehouse->delete($id);
        if ($isDeleted) {
            $this->redirect('/warehouse');
            exit;
        }
    }
}