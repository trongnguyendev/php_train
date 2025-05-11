<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Employee;

class EmployeeController extends Controller {
    public function index()
    {
        // Lấy dữ liệu từ request
        // $_GET['tags_search'] là tên của input trong form tìm kiếm
        // $_GET['type'] là tên của select trong form tìm kiếm
        $searchQuery = $_GET['tags_search'] ?? '';
        $searchType = $_GET['type'] ?? '';


        $employee = new Employee();

        // Tìm kiếm nhân viên theo tên hoặc email
        // Nếu không có tìm kiếm thì lấy tất cả nhân viên
        $employees = !empty($searchQuery)
                ? $employee->findRowByType($searchQuery, $searchType)
                : $employee->all();

        $data = [
            'pageTitle' => 'Danh sách nhân viên',
            'employees' => $employees,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('employee/list', $data);
    }

    public function create()
    {
        $this->view('employee/create', [
            'pageTitle' => 'Tạo mới nhân viên'
        ]);
    }

    public function store()
    {
        // Lấy dữ liệu từ request
        // $_POST['name'] là tên của input trong form tạo mới nhân viên
        // $_POST['email'] là tên của input trong form tạo mới nhân viên
        // $_POST['age'] là tên của input trong form tạo mới nhân viên
        $data = $_POST;

        $rules = [
            'name' => 'required',
            'email' => 'required',
            'age' => 'required|numeric'
        ];

        $validator = new Validation($data, $rules);

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

    public function update($id)
    {
        $data = $_POST;

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'age' => 'required'
        ];

        $validator = new Validation($data, $rules);

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