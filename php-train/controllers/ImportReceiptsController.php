<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Import_receipts;
use Models\Warehouse;
use Models\Product;
use Models\Stock;
use Models\Import_items;
use Core\Database;

class ImportReceiptsController extends Controller {
    public function index(Request $request = null)
    {
         $this->requireLogin();
        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('type', '') : '';

        $import_receipts = new Import_receipts();

        $warehouse = new Warehouse;
        $tableRelation = $warehouse->getTable();
        $fk = $import_receipts->getFk();

        $columnSelection = [
            'warehouses.name',
            'import_receipts.code',
            'import_receipts.received_at',
            'import_receipts.note',
            'import_receipts.id'
        ];

        $import_receiptsed = !empty($searchQuery)
                ? $import_receipts->where('name', $searchQuery)
                : $import_receipts->allWidth($tableRelation,$fk,$columnSelection);

        $data = [
            'pageTitle' => 'Danh sách nhân viên',
            'import_receipts' => $import_receiptsed,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('importReceipts/list', $data);
    }

    public function create()
    {
        $warehouse = new Warehouse();
        $warehouses = $warehouse->all();

        $product = new Product();
        $products = $product->all();
        $this->view('importReceipts/create', [
            'warehouses' => $warehouses,
            'products' => $products,
            'pageTitle' => 'Tạo mới Phiếu Nhập'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $stock = new Stock();

        $rules = [
            'warehouse' => 'required',
            'code' => 'required',
            'received_at' => 'required',
            'products' => 'required',
            'quantities' => 'required',
        ];

        $messages = [
            'warehouse.required' => 'Bắt buộc nhập KHO',
            'code.required' => 'Bắt buộc nhập Mã Tạo Đơn',
            'received_at.required' => 'Bắt buộc nhập Ngày Tạo',
            'products.required' => 'Bắt buộc chọn sản phẩm',
            'quantities.required' => 'Bắt buộc nhập số lượng',
        ];


        $validator = new Validation($data, $rules, $messages);
        $warehouses = (new Warehouse())->all();

        if (!$validator->validate()) {
            $this->view('importReceipts/create', [
                'pageTitle' => 'Tạo mới Phiếu Nhập Kho',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'warehouses' => $warehouses,
            ]);
        }

        $db = Database::getInstance();

        try {
            $db->beginTransaction();

            $import_receipts = new Import_receipts();



            $storeId = $import_receipts->create([
                'warehouse_id' => $data['warehouse'],
                'code' => $data['code'],
                'received_at' => $data['received_at'],
                'note' => $data['note'],
            ]);

            // $createdPost = Post::create([
            // 'title' => 'Bài viết mới',
            // 'content' => 'Nội dung...',
            // 'user_id' => 1,
            // ]);

            // $createdPost->getLastInsertID;

            $import_items = new Import_items();
            $productIds = explode(',', $data['products']);
            $quantities = $data['quantities'];

            foreach($productIds as $key => $ids) {
                $import_items->create([
                    'product_id' => $ids,
                    'quantity' => $quantities[$key],
                    'import_receipt_id' => $storeId
                ]);
                $stockData = $stock->whereMulti([
                    'product_id' => $ids,
                    'warehouse_id' => $data['warehouse']
                ]);

                $stockInfo = !empty($stockData) ? $stockData[0] : [];

                 if (!empty($stockInfo)) {
                    $newQty = $stockInfo['quantity'] + $quantities[$key];
                    $stock->update($stockInfo['id'], ['quantity' => $newQty]);
                } else {
                    $stock->create([
                        'product_id' => $ids,
                        'warehouse_id' => $data['warehouse'],
                        'quantity' => $quantities[$key]
                    ]);
                }
            }


            // Lấy danh sách sản phẩm trong phiếu nhập
            // $items = $imports_items->where('import_receipt_id', $id);
            // $stock = new Stock();

            // foreach ($items as $item) {
            //     $productId = $item['product_id'];
            //     $importQty = (int)$item['quantity'];

            //     $stockData = $stock->whereMulti([
            //         'product_id' => $productId,
            //         'warehouse_id' => $data['warehouse']
            //     ]);

            //     $stockInfo = !empty($stockData) ? $stockData[0] : [];

            //     if (!empty($stockInfo)) {
            //         $newQty = $stockInfo['quantity'] + $importQty;
            //         $stock->update($stockInfo['id'], ['quantity' => $newQty]);
            //     } else {
            //         $stock->create([
            //             'product_id' => $productId,
            //             'warehouse_id' => $data['warehouse'],
            //             'quantity' => $importQty
            //         ]);
            //     }
            // }

            $db->commit();
            $this->redirect('/import_receipts');
        } catch (\Exception $e) {
            // Rollback nếu có lỗi
            $db->rollback();
            // Xử lý lỗi...
            $this->view('importReceipts/create', [
                'pageTitle' => 'Tạo mới Phiếu Nhập Kho',
                'errors' => ['error_system' => 'Lỗi hệ thống, vui lòng thử lại sau.'],
                'oldInput' => $data,
                'warehouses' => $warehouses,
            ]);
        }
    }

    public function edit($id)
    {
        // Lấy thông tin đơn nhập hàng (warehouse, danh sách sản phẩm, thông tin đơn nhập)
        $import_receipts = new Import_receipts();
        $import_receiptsData = $import_receipts->whereOne('id', $id);

        // Lấy tất cả các kho
        $warehouse = new Warehouse();
        $warehouses = $warehouse->all();

        // Lấy tất cả sản phẩm
        $product = new Product();
        $products = $product->all();

        // Lấy danh sách id của import_item
        $import_items = new Import_items();
        $import_item = $import_items->where('import_receipt_id', $id);
        // var_dump($import_item);

         $importIdSelected = array_map(function ($products) {
            return $products['product_id'];
        }, $import_item);

        // Lấy danh sách các sản phẩm của đơn nhập hàng
        
        $this->view('importReceipts/update', [
            'pageTitle' => 'Cập nhật Phiếu Nhập Kho',
            'import_receiptsData' => $import_receiptsData,
            'warehouses' => $warehouses,
            'products' => $products,
            'importIdSelected' => $importIdSelected,
            'indexData' => $id
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();



        // var_dump($data);
        // exit;

        $rules = [
            'warehouse' => 'required',
            'code' => 'required',
            'received_at' => 'required'
        ];
        $messages = [
            'warehouse.required' => 'Bắt buộc nhập KHO',
            'code.required' => 'Bắt buộc nhập Mã Tạo Phiếu',
            'received_at.required' => 'Bắt buộc nhập Ngày Tạo',
        ];
        $validator = new Validation($data, $rules, $messages);

        if (!$validator->validate()) {
            $this->view('importReceipts/update', [
                'pageTitle' => 'Cập nhật Phiếu Nhập Kho',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
                'indexData' => $id
            ]);
            return;
        }


        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $importReceiptsData = new Import_receipts();
            $imports_items = new Import_items();

            $importReceiptsDatas = $importReceiptsData->update( $id, [
                'warehouse_id' => $data['warehouse'],
                'code' => $data['code'],
                'received_at' => $data['received_at'],
                'note' => $data['note'],
            ]);

            $importsItems = $imports_items->where('import_receipt_id', $id);

            foreach ($importsItems as $keyItem) {
                $deleteProduct = $imports_items->delete($keyItem['id']);
            };

            foreach ($data['products'] as $item) {
                if (empty($item['id']) || !is_numeric($item['id'])) continue;
                $created = $imports_items->create([
                    'import_receipt_id' => $id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty']
                ]);
            }

            // Lấy danh sách sản phẩm trong phiếu nhập
            $items = $imports_items->where('import_receipt_id', $id);
            $stock = new Stock();

            foreach ($items as $item) {
                $productId = $item['product_id'];
                $importQty = (int)$item['quantity'];

                $stockData = $stock->whereMulti([
                    'product_id' => $productId,
                    'warehouse_id' => $data['warehouse']
                ]);

                $stockInfo = !empty($stockData) ? $stockData[0] : [];

                if (!empty($stockInfo)) {
                    $newQty = $stockInfo['quantity'] + $importQty;
                    $stock->update($stockInfo['id'], ['quantity' => $newQty]);
                } else {
                    $stock->create([
                        'product_id' => $productId,
                        'warehouse_id' => $data['warehouse'],
                        'quantity' => $importQty
                    ]);
                }
            }


            // Cập nhật tồn kho
            // $stock = new Stock();
            // $stockInfo = $stock->where([
            //     'product_id' => 1,
            //     'warehouse_id' => 3
            // ]);

            // $quantityOld = $stockInfo['quantity'];
            // $newQUantity = 6;

            // $dataUpdate = [
            //     'quantity' => ($quantityOld + $newQUantity)
            // ]

            // $stock->update($stockInfo['id'], $dataUpdate);


            $db->commit();

            $this->redirect('/import_receipts');

        } catch (\Exception $e) {
            $db->rollback();
            return $this->view('importReceipts/update', [
                'pageTitle' => 'Cập Nhập Full Bộ Sản Phẩm',
                'errors' => ['error_system' => 'Lỗi hệ thống: ' . $e->getMessage()],
                'oldInput' => $data,
                'indexData' => $id
            ]);
        };

    }
    //     $import_receipts = new Import_receipts();

    //     $update = $import_receipts->update($id, [
    //         'warehouse' => $data['warehouse'],
    //         'code' => $data['code'],
    //         'revlivered_at' => $data['revlivered_at']
    //     ]);

    //     if ($update) {
    //         $this->redirect('/import_receipts');
    //         exit;
    //     }
    // }

    public function delete($id)
    {
        $import_receipts = new import_receipts();
        $isDeleted = $import_receipts->delete($id);
        if ($isDeleted) {
            $this->redirect('/import_receipts');
            exit;
        }
    }

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

        $this->view('importReceipts/list_items', [
            'pageTitle' => 'Chi tiết phiếu nhập',
            'indexItems' => [
                'warehouse_name' => $warehouseName,
                'importItems' => $data
            ]
        ]);
    }


}