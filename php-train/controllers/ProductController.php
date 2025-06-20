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
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên sản phẩm',
            'sku.required' => 'Bắt buộc nhập mã sản phẩm',
            'quantity.required' => 'Bắt buộc nhập số lượng',
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

        // Xử lý upload file
        $imgFileName = null;
        $uploadError = null;
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'storage/public/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileTmpPath = $_FILES['img']['tmp_name'];
            $fileName = basename($_FILES['img']['name']);
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);
            $destPath = $uploadDir . $fileName;
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $imgFileName = $fileName;
            } else {
                $uploadError = 'Không thể lưu file upload.';
            }
        } elseif (isset($_FILES['img']) && $_FILES['img']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadError = 'Lỗi upload file: ' . $_FILES['img']['error'];
        }

        if ($uploadError) {
            $this->view('product/create',[
                'pageTitle' => 'Tạo Sản Phẩm Mới',
                'errors' => array_merge($validator->getErrors() ?? [], ['img' => [$uploadError]]),
                'oldInput' => $data,
            ]);
            return;
        }
        if ($imgFileName) {
            $data['img'] = '/storage/public/' . $imgFileName;
        } else {
            $data['img'] = '';
        }

        $product = new Product();

        $store = $product->create([
            'name' => $data['name'],
            'sku' => $data['sku'],
            'price' => 11111,
            'quantity' => $data['quantity'],
            'image' => $data['img']
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
            'name' => 'required',
            'sku' => 'required',
            'quantity' => 'required',
        ];

        $messages = [
            'name.required' => 'Bắt buộc nhập tên sản phẩm',
            'sku.required' => 'Bắt buộc nhập Mã Sản Phẩm',
            'quantity.required' => 'Bắt buộc nhập số lượng',
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

        // Xử lý upload file mới nếu có
        $imgFileName = null;
        $uploadError = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'storage/public/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['image']['name']));
            $destPath = $uploadDir . $fileName;
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $imgFileName = '/storage/public/' . $fileName;
            } else {
                $uploadError = 'Không thể lưu file upload.';
            }
        } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadError = 'Lỗi upload file: ' . $_FILES['image']['error'];
        }
        if ($uploadError) {
            $this->view('product/update',[
                'pageTitle' => 'Cập Nhập Sản Phẩm',
                'errors' => array_merge($validator->getErrors() ?? [], ['image' => [$uploadError]]),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }
        // Lấy dữ liệu cũ để giữ nguyên img nếu không upload mới
        $productData = $product->whereOne('id', $id);
        $imgValue = $imgFileName ? $imgFileName : ($productData['image'] ?? '');

        $update = $product->update($id,[
            'name' => $data['name'],
            'sku' => $data['sku'],
            'quantity' => $data['quantity'],
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
}