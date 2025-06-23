<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Stock;

class StockController extends Controller {
    public function index(Request $request = null)
    {
         $this->requireLogin();
        $searchQuery = $request ? $request->query('tags_search', '') : '';
        $searchType = $request ? $request->query('type', '') : '';

        $stock = new Stock();

        $stock = !empty($searchQuery)
                ? $stock->where('name', $searchQuery)
                : $stock->all();

        $data = [
            'pageTitle' => 'Danh sách tồn kho',
            'stock' => $stock,
            'oldSearch' => [
                'search_content' => $searchQuery,
                'search_type' => $searchType
            ]
        ];
        $this->view('stock/list', $data);
    }
}