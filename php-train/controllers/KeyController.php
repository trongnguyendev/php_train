<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Sanpham;
use Models\Full_bo_sanpham;
use Models\Product;
use Models\Key;
use Core\Database;

class KeyController extends Controller {
    public function index(Request $request = null)
    {
        $this->requireLogin();
        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('type', '') : '';

        $key = new Key();

        $full_bo_sanpham = new Full_bo_sanpham;
        $tableRelation = $full_bo_sanpham->getTable();
        $fk = $key->getFk();

        $columnSelection = [
            'full_bo_sanpham_id',
            'sanpham_id',
            'quantity'
        ];

        $keys = !empty($searchQuery)
                ? $key->where('name', $searchQuery)
                : $key->allWidth($tableRelation,$fk,$columnSelection);

        $data = [
            'pageTitle' => 'Danh sách Sản Phẩm Full Bộ',
            'keys' => $keys,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('key/list', $data);
    }

    public function create()
    {
        $full_bo_sanphams = (new Full_bo_sanpham())->all();
        $sanphams = (new Sanpham())->all();

        return $this->view('key/create', [
            'pageTitle' => 'Tạo mới Full Bộ Sản Phẩm',
            'full_bo_sanphams' => $full_bo_sanphams,
            'sanphams' => $sanphams,
            'errors' => [],        // tránh lỗi undefined
            'oldInput' => [],      // tránh lỗi undefined
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'fullbo' => 'required',
            'products' => 'required',
        ];

        $messages = [
            'fullbo.required' => 'Bắt buộc chọn sản phẩm Full Bộ',
            'products.required' => 'Bắt buộc chọn ít nhất 1 sản phẩm lẻ',
        ];

        $validator = new Validation($data, $rules, $messages);
        $full_bo_sanpham = (new Full_bo_sanpham())->all();
        $sanphams = (new Sanpham())->all();

        if (!$validator->validate()) {
            return $this->view('key/create', [
                'pageTitle' => 'Tạo mới Full Bộ Sản Phẩm',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'full_bo_sanpham' => $full_bo_sanpham,
                'sanphams' => $sanphams,
            ]);
        }

        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            // Lưu đơn chính (nếu có bảng riêng, bạn có thể bỏ qua nếu không cần)
            $key = new Key(); // <-- nếu bảng keys là bảng trung gian, thì bỏ dòng này
            $storeId = null; // nếu bạn không có bảng đơn chính

            // Lưu từng sản phẩm lẻ
            $key = new Key(); // Lúc này key là model bảng trung gian: keys
            foreach ($data['products'] as $item) {
                if (empty($item['id']) || !is_numeric($item['id'])) continue;

                $key->create([
                    'full_bo_sanpham_id' => $data['fullbo'],
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
                'full_bo_sanpham' => $full_bo_sanpham,
                'sanphams' => $sanphams,
            ]);
        }
    }




    public function edit($id)
    {
        $keyModel = new Key();
        $full_bo_sanphams = (new Full_bo_sanpham())->all();
        $sanphams = (new Sanpham())->all();

        $this->view('key/edit', [
            'pageTitle' => 'Cập nhật Key Full Bộ',
            'key' => $keyModel->whereOne('id', $id),
            'indexData' => $id,
            'full_bo_sanphams' => $full_bo_sanphams,
            'sanphams' => $sanphams,
            'errors' => [],
            'oldInput' => [],
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
        $import_items = new Import_items();

        $data = $import_items->getInfoImport(
            $id,
            [
                'import_items.id',
                'import_items.quantity',
                'products.name',
                'warehouses.name AS warehouse_name'
            ]
        );

        // Lấy tên kho từ dòng đầu tiên
        $warehouseName = !empty($data) ? $data[0]['warehouse_name'] : '';

        $this->view('import_receipts/list_items', [
            'pageTitle' => 'Chi tiết phiếu nhập',
            'indexItems' => [
                'warehouse_name' => $warehouseName,
                'importItems' => $data
            ]
        ]);
    }


}