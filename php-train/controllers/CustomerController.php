<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Customer;

class CustomerController extends Controller {
    public function index()
    {
        // Lấy dữ liệu từ request
        // $_GET['tags_search'] là tên của input trong form tìm kiếm
        // $_GET['type'] là tên của select trong form tìm kiếm
        $searchQuery = $_GET['tags_search'] ?? '';
        $searchType = $_GET['type'] ?? '';


        $customer = new Customer();

        // Tìm kiếm nhân viên theo tên hoặc email
        // Nếu không có tìm kiếm thì lấy tất cả nhân viên
        $customer = !empty($searchQuery)
                ? $customer->findRowByType($searchQuery, $searchType)
                : $customer->all();

        $data = [
            'pageTitle' => 'Danh sách khách hàng',
            'customers' => $customer,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('customer/list', $data);
    }

    public function create()
    {
        $this->view('customer/create', [
            'pageTitle' => 'Tạo mới khách hàng'
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
            $this->view('customer/create', [
                'pageTitle' => 'Tạo mới khách hàng',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
            ]);
            return;
        }

        $customer = new Customer();

        $store = $customer->store([
            'name' => $data['name'],
            'email' => $data['email'],
            'age' => $data['age'],
        ]);

        if ($store) {
            header("Location: /customer");
            exit;
        }

        header("Location: create");
    }

    public function edit($id)
    {
        $customer = new Customer();
        $this->view('customer/update', [
            'pageTitle' => 'Cập nhật khách hàng',
            'customerData' => $customer->findRowByIndex($id),
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
            $this->view('customer/update', [
                'pageTitle' => 'Cập nhật khách hàng',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }

        $customer = new Customer();

        $update = $customer->update($id, [
            'name' => $data['name'],
            'email' => $data['email'],
            'age' => $data['age']
        ]);

        if ($update) {
            header("Location: /customer");
            exit;
        }
    }

    public function delete($id)
    {
        $customer = new Customer();
        $isDeleted = $customer->delete($id);

        if ($isDeleted) {
            header("Location: /customer");
            exit;
        }
    }
}