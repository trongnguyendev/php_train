<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\User;

class UserController extends Controller {
    public function index()
    {
        // Lấy dữ liệu từ request
        // $_GET['tags_search'] là tên của input trong form tìm kiếm
        // $_GET['type'] là tên của select trong form tìm kiếm
        $searchQuery = $_GET['tags_search'] ?? '';
        $searchType = $_GET['type'] ?? '';


        $user = new User();

        // Tìm kiếm nhân viên theo tên hoặc email
        // Nếu không có tìm kiếm thì lấy tất cả nhân viên
        $users = !empty($searchQuery)
                ? $user->findRowByType($searchQuery, $searchType)
                : $user->all();

        $data = [
            'pageTitle' => 'Danh sách user',
            'users' => $users,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('user/list', $data);
    }

    public function create()
    {
        $this->view('user/create', [
            'pageTitle' => 'Tạo mới user'
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
            'password' => 'required'
        ];

        $validator = new Validation($data, $rules);

        if (!$validator->validate()) {
            $this->view('user/create', [
                'pageTitle' => 'Tạo mới user',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
            ]);
            return;
        }

        $user = new User();

        $store = $user->store([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ]);

        if ($store) {
            header("Location: /user");
            exit;
        }

        header("Location: create");
    }

    public function edit($id)
    {
        $user = new User();
        $this->view('user/update', [
            'pageTitle' => 'Cập nhật User',
            'userData' => $user->findRowByIndex($id),
            'indexData' => $id
        ]);
    }

    public function update($id)
    {
        $data = $_POST;

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ];

        $validator = new Validation($data, $rules);

        if (!$validator->validate()) {
            $this->view('user/update', [
                'pageTitle' => 'Cập nhật user',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }

        $user = new User();

        $update = $user->update($id, [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ]);

        if ($update) {
            header("Location: /user");
            exit;
        }
    }

    public function delete($id)
    {
        $user = new User();
        $isDeleted = $user->delete($id);

        if ($isDeleted) {
            header("Location: /user");
            exit;
        }
    }
}