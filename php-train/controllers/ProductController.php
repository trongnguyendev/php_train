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
            'name' => 'required',
            'sku' => 'required',
            'quantity' => 'required',
            'warehouse' => 'required',
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên sản phẩm',
            'sku.required' => 'Bắt buộc nhập mã sản phẩm',
            'quantity.required' => 'Bắt buộc nhập số lượng',
            'warehouse.required' => 'Bắt buộc nhập KHO',
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

        $product = new Product();

        $store = $product->create([
            'name' => $data['name'],
            'sku' => $data['sku'],
            'quantity' => $data['quantity'],
            'warehouse' => $data['warehouse'],
            'img' => $data['img']
        ]);

        if($store) {
            $this->redirect('/product');
            exit;
        }
        $this->redirect('/product/create');
    }

    public function edit($id){
        $product = new Product();
        $this->view('product/update',[
            'pageTitle' => 'Cập Nhập Sản Phẩm',
            'productData' => $product->whereOne('id',$id),
            'indexData' => $id
        ]);
    }

    public function update($id, Request $request) {
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'sku' => 'required',
            'quantity' => 'required',
            'warehouse' => 'required'
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên sản phẩm',
            'sku.required' => 'Bắt buộc nhập Mã Sản Phẩm',
            'quantity.required' => 'Bắt buộc nhập số lượng',
            'warehouse.required' => 'Bắt buộc nhập KHO'
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

        $update = $product->update($id,[
            'name' => $data['name'],
            'sku' => $data['sku'],
            'quantity' => $data['quantity'],
            'warehouse' => $data['warehouse'],
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
}