<?php 
namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Product;

class ProductController extends Controller {

    public function index(Request $request = null){
        $this->requireLogin();

        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('typpe', '') : '';

        $product = new Product();

        $products = !empty($searchQuery)
            ? $product->where($searchType, $searchQuery)
            : $product->all();

        $data = [
            'pageTitle' => 'Danh Sách Sản Phẩm',
            'products' => $products,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
            $this->view('product/list', $data);
    }

    public function create(){
        $this->view('product/create',[
            'pageTitle' => 'Tạo mới sản phẩm'
        ]);
    }

    public function store(Request $request){
        $data = $request->all();

        $rules = [
            'code' => 'required',
            'name' => 'required',
            'price' => 'required',
        ];

        $messages = [
            'code.required' => 'Bắt buộc nhập mã sản phẩm',
            'name.required' => 'Bắt buộc nhập tên sản phẩm',
            'price.required' => 'Bắt buộc nhập Giá',
        ];

        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('product/create',[
                'pageTitle' => 'Tạo Sản Phẩm Mới',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
            ]);
            return;
        }

        // Xử lý upload file sử dụng hàm cha
        $upload = $this->uploadImage('image', 'storage/public/');
        if ($upload['error']) {
            $this->view('product/create',[
                'pageTitle' => 'Tạo Sản Phẩm Mới',
                'errors' => array_merge($validator->getErrors() ?? [], ['image' => [$upload['error']]]),
                'oldInput' => $data,
            ]);
            return;
        }
        $data['image'] = $upload['path'] ?? '';

        $product = new Product();

        $store = $product->create([
            'code' => $data['code'],
            'name' => $data['name'],
            'description' => $data['description'],
            'unit' => $data['unit'],
            'price' => $data['price'],
            'image' => $data['image']
        ]);

        if($store) {
            $this->redirect('/product');
            exit;
        }
        $this->redirect('/product/create');
    }

    public function edit($id){
        $product = new Product();
        $productUpdate = $product->whereOne('id',$id);
        $this->view('product/update',[
            'pageTitle' => 'Cập Nhập Sản Phẩm',
            'productData' => $productUpdate,
            'indexData' => $id
        ]);
    }

    public function update($id, Request $request) {
        $data = $request->all();

         $rules = [
            'code' => 'required',
            'name' => 'required',
            'price' => 'required',
        ];

        $messages = [
            'code.required' => 'Bắt buộc nhập mã sản phẩm',
            'name.required' => 'Bắt buộc nhập tên sản phẩm',
            'price.required' => 'Bắt buộc nhập Giá',
        ];

        $validator = new Validation($data, $rules, $messages);

        if(!$validator->validate()) {
            $this->view('product/update',[
                'pageTitle' => 'Cập Nhập Sản Phẩm',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }

        $product = new Product();

        // Xử lý upload file mới nếu có (sử dụng hàm cha)
        $upload = $this->uploadImage('image', 'storage/public/');
        if ($upload['error']) {
            $this->view('product/update',[
                'pageTitle' => 'Cập Nhập Sản Phẩm',
                'errors' => array_merge($validator->getErrors() ?? [], ['image' => [$upload['error']]]),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }
        // Lấy dữ liệu cũ để giữ nguyên image nếu không upload mới
        $productData = $product->whereOne('id', $id);
        $imgValue = $upload['path'] ? $upload['path'] : ($productData['image'] ?? '');

        $update = $product->update($id,[
            'code' => $data['code'],
            'name' => $data['name'],
            'description' => $data['description'],
            'unit' => $data['unit'],
            'price' => $data['price'],
            'image' => $imgValue,
        ]);

        if($update){
            $this->redirect('/product');
            exit;
        }
    }

    public function delete($id){
        $product = new Product();
        $isDeleted = $product->delete($id);

        if($isDeleted){
            $this->redirect('/product');
            exit;
        }
    }

    public function search(Request $request) {
        $this->requireLogin();

        $searchQuery = $request->input('content', '');

        $product = new Product();

        $products = $product->where('name', $searchQuery);

        echo json_encode([
            'status' => 'success',
            'data' => $products
        ]);
    }
}