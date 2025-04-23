<?php

namespace Controllers;

use Core\Controller;

class DashboardController extends Controller {
    
    public function index() {

        $data = [
            'pageTitle' => 'Dashboard',
            'labels' => ['Customer', 'Employee', 'User'],
            'labels2' => ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7'],
            'data' => [12, 19, 50],
            'data2' => [65, 59, 80, 81, 56, 55, 40]
        ];

        $this->view('dashboard/index', $data);
    }
}