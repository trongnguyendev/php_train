<?php

namespace Controllers;

use Core\Controller;
use Core\Validator;
use Core\Validation;
use Core\Request;
use Models\Full_bo_sanpham;

class Full_bo_sanphamController extends Controller {

    public function index (Request $request = null){
        $this->requireLogin();
        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('type', '') :  '';

        $full_bo_sanpham = new full_bo_sanpham();
        
        $full_bo_sanphams = !empty($searchQuery)
            ? $full_bo_sanpham->where($searchType, $searchQuery)
            : $full_bo_sanpham->all();
        $data = [
            'pageTitle' => 'Danh Sách Full Bộ Sản Phẩm',
            'full_bo_sanphams' => $full_bo_sanphams,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('full_bo_sanpham/list', $data);
    }

    public function create(){
        $this->view('full_bo_sanpham/create',[
            'pageTitle' => 'Tạo mới Full Bộ Sản Phẩm'
        ]);
    }

    public function store(Request $request){
        $data = $request->all();

        $rules = [
            'name' =>'required',
            'price' => 'required',
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên',
            'price.required' => 'Bắt buộc nhập giá',
        ];

        $validator = new Validation ($data,$rules,$messages);

        if (!$validator->validate()){
            $this->view('sanpham/create',[
                'pageTitle' => 'Tạo thông tin Full Bộ Sản Phẩm mới',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
            ]);
            return;
        }

        $full_bo_sanpham = new Full_bo_sanpham();

        $store = $full_bo_sanpham-> create([
            'name' => $data['name'],
            'price' => $data['price']
        ]);

        if($store){
            $this->redirect('/full_bo_sanpham');
            exit;
        }

        $this->redirect('/full_bo_sanpham/create');
    }

    public function edit($id){
        $full_bo_sanpham = new Full_bo_sanpham();
        $this->view('full_bo_sanpham/update', [
            'pageTitle' => 'Cập nhập thông tin Full Bộ Sản Phẩm',
            'full_bo_sanphamData' => $full_bo_sanpham->whereOne('id', $id),
            'indexData' => $id
        ]);
    } 

    public function update($id, $request){
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'price' => 'required'
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên sản phẩm',
            'price.required' => 'Bắt buộc nhập giá',
        ];

        $validator = new Validation($data, $rules, $messages);

        if(!$validator->validate()){
            $this->view('full_bo_sanpham/update',[
                'pageTitle' => 'Cập nhập thông tin Full Bộ sản phẩm',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id,
            ]);
            return;
        }

        $full_bo_sanpham = new Full_bo_sanpham();

        $full_bo_sanpham = $full_bo_sanpham->update($id, [
            'name' => $data['name'],
            'price' => $data['price']
        ]);

        if($update) {
            $this->redirect('/full_bo_sanpham');
            exit;
        }
    }

    public function delete($id){

        $full_bo_sanpham = new Full_bo_sanpham();
        $isDeleted = $full_bo_sanpham->delete($id);

        if($isDeleted){
            $this->redirect('/full_bo_sanpham');
            exit;
        }
    }

}