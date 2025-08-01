<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Sanpham;
use Models\ProductGroup;
use Models\Product;
use Models\Key;
use Core\Database;

class ProductGroupController extends Controller {
    public function index(Request $request = null)
    {
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

    public function create()
    {
        $productGroups = (new ProductGroup())->all();
        $products = (new Product())->all();

        return $this->view('productGroup/create', [
            'pageTitle' => 'Tạo mới Full Bộ Sản Phẩm',
            'productGroups' => $productGroups,
            'products' => $products,
            'errors' => [],        // tránh lỗi undefined
            'oldInput' => [],      // tránh lỗi undefined
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'price' => 'required',
            'products' => 'required',
        ];

        $messages = [
            'name.required' => 'Bắt buộc chọn sản phẩm Full Bộ',
            'products.required' => 'Bắt buộc chọn ít nhất 1 sản phẩm lẻ',
        ];

        $validator = new Validation($data, $rules, $messages);
        $productGroup = (new ProductGroup())->all();
        $products = (new Product())->all();

        if (!$validator->validate()) {
            return $this->view('productGroup/create', [
                'pageTitle' => 'Tạo mới Full Bộ Sản Phẩm',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'productGroup' => $productGroup,
                'products' => $products,
            ]);
        }

        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $key = new Key();
            $storeId = null;

            $productGroup = new ProductGroup();
            $idProductGroup = $productGroup->create([
                'name' => $data['name'],
                'price' => $data['price']
            ]);

            $key = new Key();
            foreach ($data['products'] as $item) {
                if (empty($item['id']) || !is_numeric($item['id'])) continue;

                $key->create([
                    'product_group_id' => $idProductGroup,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'note' => $data['note'] ?? null,
                ]);
            }

            $db->commit();
            $this->redirect('/product-group');
        } catch (\Exception $e) {
            $db->rollback();
            return $this->view('productGroup/create', [
                'pageTitle' => 'Tạo mới Full Bộ Sản Phẩm',
                'errors' => ['error_system' => 'Lỗi hệ thống: ' . $e->getMessage()],
                'oldInput' => $data,
                'productGroup' => $productGroup,
                'products' => $products,
            ]);
        }
    }


    public function edit($id)
    {
        $productGroups = new ProductGroup();
        $products = (new Product())->all();

        $productGroup = new ProductGroup();
        $groupInfo = $productGroup->find($id);

        $key = new Key();
        $dataProducts = $key->getInfoProductGroup($id);

        $productIdSelected = array_map(function ($product) {
            return $product['id'];
        }, $dataProducts);

        $this->view('productGroup/update', [
            'pageTitle' => 'Cập nhật Key Full Bộ',
            'groupInfo' => $groupInfo,
            'products' => $products,
            'productIdSelected' => $productIdSelected,
            'indexData' => $id,
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'price' => 'required',
            'products' => 'required',
        ];

        $messages = [
            'name.required' => 'Bắt buộc chọn sản phẩm Full Bộ',
            'products.required' => 'Bắt buộc chọn ít nhất 1 sản phẩm lẻ',
        ];

        $validator = new Validation($data, $rules, $messages);
        
        if(!$validator->validate()) {
            return $this->view('productGroup/create', [
                'pageTitle' => 'Cập Nhập Full Bộ Sản Phẩm',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
        }


        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $productData = new productGroup();
            $producted = new product();
            $key = new Key();
            

            $groupInfo = $productData->update( $id, [
                'name' => $data['name'],
                'price' => $data['price']
            ]);

            $isKey = $key->where('product_group_id',$id);

            foreach ($isKey as $keyItem) {
                $deleteProduct = $key->delete($keyItem['id']);
            };

            foreach ($data['products'] as $item) {
                if (empty($item['id']) || !is_numeric($item['id'])) continue;
                $created = $key->create([
                    'product_group_id' => $id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'note' => $data['note'] ?? null,
                ]);
            }

            $db->commit();

            $this->redirect('/product-group');

        } catch (\Exception $e) {
            $db->rollback();
            return $this->view('productGroup/create', [
                'pageTitle' => 'Cập Nhập Full Bộ Sản Phẩm',
                'errors' => ['error_system' => 'Lỗi hệ thống: ' . $e->getMessage()],
                'oldInput' => $data,
                'productGroup' => $productGroup,
                'products' => $products,
            ]);
        };
    }
        // $rules = [
        //     'full_bo_sanpham_id' => 'required',
        //     'sanpham_id' => 'required|email',
        //     'quantity' => 'required'
        // ];
        // $messages = [
        //     'full_bo_sanpham_id.required' => 'Bắt buộc nhập Full Bộ Sản Phẩm',
        //     'sanpham_id.required' => 'Bắt buộc nhập Sản Phẩm Lẻ',
        //     'quantity.required' => 'Bắt buộc nhập Số Lượng',
        // ];
        // $validator = new Validation($data, $rules, $messages);

        // if (!$validator->validate()) {
        //     $this->view('productGroup/update', [
        //         'pageTitle' => 'Cập nhật Sản Phẩm Full Bộ',
        //         'errors' => $validator->getErrors(),
        //         'oldInput' => $data,
        //         'indexData' => $id
        //     ]);
        //     return;
        // }

        // $import_receipts = new Import_receipts();

        // $update = $import_receipts->update($id, [
        //     'warehouse' => $data['warehouse'],
        //     'code' => $data['code'],
        //     'revlivered_at' => $data['revlivered_at']
        // ]);

        // if ($update) {
        //     $this->redirect('/product-group/edit/'.$id);
        //     exit;
        // }
    

    public function delete($id)
    {
        $key = new Key();
        $isKey = $key->where('product_group_id',$id);
        foreach ($isKey as $keyItem) {
            $deleteProduct = $key->delete($keyItem['id']);
        };

        $productGroup = new ProductGroup();
        $deleteProductGroup = $productGroup->delete($id);

        $this->redirect('/product-group');
    }

    public function indexItems($id) {
        $productGroup = new ProductGroup();
        $groupInfo = $productGroup->find($id);

        $key = new Key();
        $dataProducts = $key->getInfoProductGroup($id);

        $this->view('productGroup/list_items', [
            'pageTitle' => 'Chi tiết Sản Phẩm Full Bộ',
            'data' => [
                'dataProducts' => $dataProducts,
                'groupInfo' => $groupInfo
            ]
        ]);
    }
}