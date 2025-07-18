<?php

namespace Controllers;

use Core\Controller;
use Core\Validator;
use Core\Validation;
use Core\Request;
use Models\ProductGroup;

class ProductGroupController extends Controller {

    public function index (Request $request = null){
        $this->requireLogin();
        $contentSearch = $request ? $request->query('content_search', '') : '';

        $productGroup = new ProductGroup();
        
        $productGroup = !empty($contentSearch)
            ? $productGroup->where('name', $contentSearch)
            : $productGroup->all();

        $data = [
            'pageTitle' => 'Danh Sách Full Bộ Sản Phẩm',
            'productGroup' => $productGroup,
            'oldSearch' => [
                'search_content' => $contentSearch,
            ]
        ];
        $this->view('productGroup/list', $data);
    }

    public function create(){
        $this->view('productGroup/create',[
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

        $validator = new Validation($data,$rules,$messages);

        if (!$validator->validate()){
            $this->view('productGroup/create',[
                'pageTitle' => 'Tạo thông tin Full Bộ Sản Phẩm mới',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
            ]);
            return;
        }

        $productGroup = new ProductGroup();

        $store = $productGroup-> create([
            'name' => $data['name'],
            'price' => $data['price']
        ]);

        if($store){
            $this->redirect('/product-group');
            exit;
        }

        $this->redirect('/product-group/create');
    }

    public function edit($id){
        $productGroup = new ProductGroup();
        $this->view('productGroup/update', [
            'pageTitle' => 'Cập nhập thông tin Full Bộ Sản Phẩm',
            'productGroup' => $productGroup->whereOne('id', $id),
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
            $this->view('productGroup/update',[
                'pageTitle' => 'Cập nhập thông tin Full Bộ sản phẩm',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id,
            ]);
            return;
        }

        $productGroup = new ProductGroup();

        $productGroupUpdate = $productGroup->update($id, [
            'name' => $data['name'],
            'price' => $data['price']
        ]);

        if($productGroupUpdate) {
            $this->redirect('/product-group');
            exit;
        }
    }

    public function delete($id){
        $productGroup = new ProductGroup();
        $isDeleted = $productGroup->delete($id);

        if($isDeleted){
            $this->redirect('/product-group');
            exit;
        }
    }

}