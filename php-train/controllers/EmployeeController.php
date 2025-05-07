<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Employee;

class EmployeeController extends Controller {
    public function index(Request $request = null)
    {
        $searchQuery = $request->query('tags_search', '');
        $searchType = $request->query('type', '');

        $employee = new Employee();

        $employees = !empty($searchQuery)
                ? $employee->findRowByType($searchQuery, $searchType)
                : $employee->all();

        $this->view('employee/list',  [
            'pageTitle' => 'Danh sách nhân viên',
            'employees' => $employees,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ]);
    }

    public function create()
    {
        $this->view('employee/create', [
            'pageTitle' => 'Tạo mới nhân viên'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'email' => 'required',
            'age' => 'required|numeric'
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên',
            'email.required' => 'Bắt buộc nhập email',
            'age.required' => 'Bắt buộc nhập tuổi',
            'age.numeric' => 'Tuổi phải là số'
        ];

        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('employee/create', [
                'pageTitle' => 'Tạo mới nhân viên',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
            ]);
            return;
        }

        $employee = new Employee();

        $store = $employee->store([
            'name' => $data['name'],
            'email' => $data['email'],
            'age' => $data['age'],
        ]);

        if ($store) {
            header("Location: /employee");
            exit;
        }

        header("Location: create");
    }

    public function edit($id)
    {
        $employee = new Employee();
        $this->view('employee/update', [
            'pageTitle' => 'Cập nhật nhân viên',
            'employeeData' => $employee->findRowByIndex($id),
            'indexData' => $id
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'age' => 'required'
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên',
            'email.required' => 'Bắt buộc nhập email',
            'age.required' => 'Bắt buộc nhập tuổi',
        ];

        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('employee/update', [
                'pageTitle' => 'Cập nhật nhân viên',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }

        $employee = new Employee();

        $update = $employee->update($id, [
            'name' => $data['name'],
            'email' => $data['email'],
            'age' => $data['age']
        ]);

        if ($update) {
            header("Location: /employee");
            exit;
        }
    }

    public function delete($id)
    {
        $employee = new Employee();
        $isDeleted = $employee->delete($id);

        if ($isDeleted) {
            header("Location: /employee");
            exit;
        }
    }
}