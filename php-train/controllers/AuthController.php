<?php

namespace Controllers;

use Core\Controller;

class AuthController extends Controller {
    
    public function showLogin() {
        $data = [
            'pageTitle' => 'Login Page'
        ];

        $this->view('auth/login', $data, false);
    }
}