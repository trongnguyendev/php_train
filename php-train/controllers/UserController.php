<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\User;

class UserController extends Controller {
    public function index(){
        $this->requireLogin();
        $searchQuery = $_GET['tags_search'] ?? '';
        $searchType = $_GET['type'] ?? '';

        $user = new User();

        $users = !empty($searchQuery)
            ? $user->where($searchType, $searchQuery)
            : $user->all();

            $data = [

                'pageTitle' => 'Tài Khoản Nhân Viên',
                'users' => $users,
                'oldSearch' => [
                    'search_content' => $searchQuery,
                    'search_type' => $searchType
                ]
                ];
                $this->view('user/list',$data);
    }


    public function create(){
        $this->view('user/create',[
            'pageTitle' => 'Thêm Nhân Viên Mới'
        ]);
    }

    public function store(){
        $data = $_POST;

        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required'
        ];
        $validator = new Validation ($data, $rules);
        if(!$validator->validate()){
            $this->view('user/create',[
                'pageTitle' => 'Thêm Nhân Viên Mới',
                'errors' => $validator->Erros(),
                'oldInput' => $data,
            ]);
            return;
        }
        $user = new User();
        $store = $user->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'province' => $data['province'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
        if($store){
            $this->redirect('/user');
            exit;
        }
        $this->redirect('/user/create');
    }

    public function edit($id){
        $user = new User();
        $this->view('user/update',[
            'pageTitle' => 'Cập Nhập Nhân Viên Mới',
            'userData' => $user->whereOne('id',$id),
            'indexData' => $id
        ]);
    }
    public function update($id){
        $data = $_POST;

         $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required'
        ];

        $validator = new Validation( $data , $rules);
        if(!$validator->validate()){
            $this->view('user/update',[
                'pageTitle' => 'Cập Nhập Tài Khoản Nhân Viên',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }

        $user = new User();
        $update = $user->update($id,[
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'province' => $data['province'],
            'password' => $data['password']
        ]);
        if($update){
            $this->redirect('/user');
            exit;
        }
    }
    public function delete($id){
        $user = new User();
        $isDeleted = $user->delete($id);

        if($isDeleted){
            $this->redirect('/user');
            exit;
        }
    }
}
