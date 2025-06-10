<?php

namespace Controllers;

use Core\Controller;
use Core\Validator;
use Core\Validation;
use Core\Request;
use Models\Customer;

class CustomerController extends Controller {
    public function index (Request $request = null){
        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('type', '') :  '';

        $customer = new Customer();
        
        $customers = !empty($searchQuery)
            ? $customer->where($searchType, $searchQuery)
            : $customer->all();

        $data = [
            'pageTitle' => 'Danh Sách Khách Hàng',
            'customers' => $customers,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('customer/list', $data);
    }

    public function create(){
        $this->view('customer/create',[
            'pageTitle' => 'Tạo mới khách hàng'
        ]);
    }

    public function store(Request $request){
        $data = $request->all();

        $rules = [
            'name' =>'required',
            'email' => 'required',
            'age' => 'required|numeric'
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên',
            'email.required' => 'Bắt buộc nhập email',
            'phone.required' => 'Bắt buộc nhập số điện thoại',
            'age.required' => 'Bắt buộc nhập tuổi',  
        ];

        $validator = new Validation ($data,$rules,$messages);

        if (!$validator->validate()){
            $this->view('customer/create',[
                'pageTitle' => 'Tạo thông tin Khách hàng mới',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
            ]);
            return;
        }

        $customer = new Customer();

        $store = $customer-> store([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'province' => $data['province'],
            'address' => $data['address'],
            'age' => $data['age'],
        ]);

        if($store){
            header("Location: /customer");
            exit;
        }

        header("Location: create");
    }

    public function edit($id){
        $customer = new Customer();
        $this->view('customer/update', [
            'pageTitle' => 'Cập nhập thông tin Khách hàng',
            'customerData' => $customer->whereOne('id',$id),
            'indexData' => $id
        ]);
    } 

    public function update($id, $request){
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'age' => 'required',
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên',
            'email.required' => 'Bắt buộc nhập email',
            'phone.required' => 'Bắt buộc nhập số điện thoại',
            'age.required' => 'Bắt buộc nhập tuổi',
        ];

        $validator = new Validation($data, $rules, $messages);

        if(!$validator->validate()){
            $this->view('customer/update',[
                'pageTitle' => 'Cập nhập thông tin Khách hàng',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id,
            ]);
            return;
        }

        $customer = new Customer();

        $update = $customer->update($id, [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'province' => $data['province'],
            'address' => $data['address'],
            'age' => $data['age'],
        ]);

        if($update) {
            header("Location: /customer");
            exit;
        }
    }

    public function delete($id){

        $customer = new Customer();
        $isDeleted = $customer->delete($id);

        if($isDeleted){
            header("Location: /customer");
            exit;
        }
    }

}