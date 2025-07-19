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

class KeyController extends Controller {
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
        $this->view('key/list', $data);
    }

    public function create()
    {
        $productGroups = (new ProductGroup())->all();
        $products = (new Product())->all();

        return $this->view('key/create', [
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
            return $this->view('key/create', [
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

            // Lưu đơn chính (nếu có bảng riêng, bạn có thể bỏ qua nếu không cần)
            $key = new Key(); // <-- nếu bảng keys là bảng trung gian, thì bỏ dòng này
            $storeId = null; // nếu bạn không có bảng đơn chính

            // Tạo product group => product_group
            $productGroup = new ProductGroup();
            $idProductGroup = $productGroup->create([
                'name' => $data['name'],
                'price' => $data['price']
            ]);

            // Lưu từng sản phẩm lẻ
            $key = new Key(); // Lúc này key là model bảng trung gian: keys
            foreach ($data['products'] as $item) {
                if (empty($item['id']) || !is_numeric($item['id'])) continue;

                $key->create([
                    'full_bo_sanpham_id' => $idProductGroup,
                    'sanpham_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'note' => $data['note'] ?? null,
                ]);
            }

            $db->commit();
            $this->redirect('/key');
        } catch (\Exception $e) {
            $db->rollback();

            return $this->view('key/create', [
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
        $keyModel = new Key();
        $productGroup = (new ProductGroup())->all();
        $sanphams = (new Sanpham())->all();

        $this->view('key/edit', [
            'pageTitle' => 'Cập nhật Key Full Bộ',
            'key' => $keyModel->whereOne('id', $id),
            'indexData' => $id,
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $rules = [
            'full_bo_sanpham_id' => 'required',
            'sanpham_id' => 'required|email',
            'quantity' => 'required'
        ];
        $messages = [
            'full_bo_sanpham_id.required' => 'Bắt buộc nhập Full Bộ Sản Phẩm',
            'sanpham_id.required' => 'Bắt buộc nhập Sản Phẩm Lẻ',
            'quantity.required' => 'Bắt buộc nhập Số Lượng',
        ];
        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('import_receipts/update', [
                'pageTitle' => 'Cập nhật Sản Phẩm Full Bộ',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }

        $import_receipts = new Import_receipts();

        $update = $import_receipts->update($id, [
            'warehouse' => $data['warehouse'],
            'code' => $data['code'],
            'revlivered_at' => $data['revlivered_at']
        ]);

        if ($update) {
            $this->redirect('/import_receipts');
            exit;
        }
    }

    public function delete($id)
    {
        $import_receipts = new import_receipts();
        $isDeleted = $import_receipts->delete($id);
        if ($isDeleted) {
            $this->redirect('/import_receipts');
            exit;
        }
    }

    // public function indexItems($id) {
    //     $import_items = new Import_items();
        
    //     $this->view('import_receipts/list_items', [
    //         'pageTitle' => 'Cập nhật Chi Tiết Phiếu Nhập',
    //         'indexItems' => $import_items->getInfoImport($id,  'products', 'products.name', [
    //             [
    //                 'import_items.id',
    //                 'products.name',
    //                 'import_items.quantity' // 👈 sửa lại đúng cột
    //             ]

    //         ])
    //     ]);
    // }

    public function indexItems($id) {
        $productGroup = new ProductGroup();
        $data = $productGroup->getInfoProductGroup(
            $id
        );

        // Lấy tên kho từ dòng đầu tiên
        $productGroup = !empty($data) ? $data[0]['productGroup'] : '';

        $this->view('key/list_items', [
            'pageTitle' => 'Chi tiết Sản Phẩm Full Bộ',
            'indexItems' => [
                'productGroup' => $productGroup,
                'importItems' => $data
            ]
        ]);
    }


}