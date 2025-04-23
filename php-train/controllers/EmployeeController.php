<?php

namespace Controllers;

use Core\Controller;
use Core\Validator;
use Models\Employee;

class EmployeeController extends Controller {

    public function index()
    {
        $employee = new Employee();

        $employees = [];

        $searchQuery = $_GET['tags_search'] ?? '';
        $searchType = $_GET['type'] ?? '';

        if (!empty($searchQuery)) {
            $employees = $employee->findRowByType($searchQuery, $searchType);
        } else {
            $employees = $employee->all();
        }

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
        $data = [
            'pageTitle' => 'Tạo mới nhân viên'
        ];

        $this->view('employee/create', $data);
    }

    public function store()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $age = $_POST['age'];

        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Name is required';
        }
        
        if (empty($email)) {
            $errors['email'] = 'Email is required';
        }

        if (empty($age)) {
            $errors['age'] = 'Age is required';
        }

        $data = [
            'pageTitle' => 'Tạo mới nhân viên'
        ];
        
        if (!empty($errors)) {
            $data['errors'] = $errors;
            $data['oldInput'] = $_POST;
            $this->view('employee/create', $data);
            return;
        }

        $employee = new Employee();

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $age = $_POST['age'] ?? '';

        $store = $employee->store([
            'name' => $name,
            'email' => $email,
            'age' => $age
        ]);

        if ($store) {
            header("Location: /employee");
            exit;
        } else {
            header("Location: create");
        }
    }

    public function edit($id)
    {
        $employee = new Employee();
        $data = [
            'pageTitle' => 'Cập nhật nhân viên',
            'employeeData' => $employee->findRowByIndex($id),
            'indexData' => $id
        ];
        $this->view('employee/update', $data);
    }

    public function update($id)
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $age = $_POST['age'];

        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Name is required';
        }

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        }

        if (empty($age)) {
            $errors['age'] = 'Age is required';
        }

        if (!empty($errors)) {
            $data = [
                'errors' => $errors,
                'oldInput' => $_POST,
                'indexData' => $id,
                'pageTitle' => 'Cập nhật nhân viên',
            ];

            $this->view('employee/update', $data);
            return;
        }

        $employee = new Employee();

        $update = $employee->update($id, [
            'name' => $name,
            'email' => $email,
            'age' => $age
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