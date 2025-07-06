<?php

namespace Controllers;

use Core\Controller;
use Core\Validator;
use Core\Validation;
use Core\Request;
use Models\Sanpham;

class SanphamController extends Controller {

    public function index (Request $request = null){
        $this->requireLogin();
        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('type', '') :  '';

        $sanpham = new Sanpham();
        
        $sanphams = !empty($searchQuery)
            ? $sanpham->where($searchType, $searchQuery)
            : $sanpham->all();
        $data = [
            'pageTitle' => 'Danh Sách Sản Phẩm',
            'sanphams' => $sanphams,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('sanpham/list', $data);
    }

    public function create(){
        $this->view('sanpham/create',[
            'pageTitle' => 'Tạo mới Sản Phẩm'
        ]);
    }

    public function store(Request $request){
        $data = $request->all();

        $rules = [
            'name' =>'required',
            'code' => 'required',
            'price' => 'required',
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên',
            'code.required' => 'Bắt buộc nhập mã sản phẩm',
            'price.required' => 'Bắt buộc nhập Giá Bán',
        ];

        $validator = new Validation ($data,$rules,$messages);

        if (!$validator->validate()){
            $this->view('sanpham/create',[
                'pageTitle' => 'Tạo thông tin Sản Phẩm mới',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
            ]);
            return;
        }

        $sanpham = new Sanpham();

        $store = $sanpham-> create([
            'name' => $data['name'],
            'code' => $data['code'],
            'price' => $data['price']
        ]);

        if($store){
            $this->redirect('/sanpham');
            exit;
        }

        $this->redirect('/sanpham/create');
    }

    public function edit($id){
        $sanpham = new Sanpham();
        $this->view('sanpham/update', [
            'pageTitle' => 'Cập nhập thông tin Sản Phẩm',
            'sanphamData' => $sanpham->whereOne('id', $id),
            'indexData' => $id
        ]);
    } 

    public function update($id, $request){
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'code' => 'required'
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên sản phẩm',
            'code.required' => 'Bắt buộc nhập mã sản phẩm',
        ];

        $validator = new Validation($data, $rules, $messages);

        if(!$validator->validate()){
            $this->view('sanpham/update',[
                'pageTitle' => 'Cập nhập thông tin sản phẩm',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id,
            ]);
            return;
        }

        $sanpham = new Sanpham();

        $update = $sanpham->update($id, [
            'name' => $data['name'],
            'code' => $data['code']
        ]);

        if($update) {
            $this->redirect('/sanpham');
            exit;
        }
    }

    public function delete($id){

        $sanpham = new Sanpham();
        $isDeleted = $sanpham->delete($id);

        if($isDeleted){
            $this->redirect('/sanpham');
            exit;
        }
    }

}