<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\warehouse;

class WarehouseController extends Controller {
    public function index(Request $request = null)
    {
         $this->requireLogin();
        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('type', '') : '';

        $warehouse = new Warehouse();

        $warehouse = !empty($searchQuery)
                ? $warehouse->where('name', $searchQuery)
                : $warehouse->all();

        $data = [
            'pageTitle' => 'Danh sách nhân viên',
            'employees' => $warehouse,
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
            'name.required' => 'Bắt buộc nhập tên',
            'localtion.required' => 'Bắt buộc nhập email',
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

        $store = $employee->create([
            'name' => $data['name'],
            'warehouse' => $data['warehouse']
        ]);

        if ($store) {
            $this->redirect('/warehouse');
            exit;
        }
    }

    public function edit($id)
    {
        $employee = new Employee();
        $this->view('warehouse/update', [
            'pageTitle' => 'Cập nhật KHO',
            'warehouseData' => $employee->whereOne('id', $id),
            'indexData' => $id
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'warehouse' => 'required|email'
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên',
            'warehouse.required' => 'Bắt buộc nhập KHO'
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
            'warehouse' => $data['warehouse']
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