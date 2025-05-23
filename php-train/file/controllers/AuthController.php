<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;

class AuthController extends Controller {
    
    public function showLogin() {
        $this->view('auth/login', [ 'pageTitle' => 'Login Page' ], false);
    }

    public function postLogin(Request $request = null) {
        $data = $request->all();

        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6|max:20'
        ];

        $validator = new Validation($data, $rules);

        if (!$validator->validate()) {
            $this->view('auth/login', [
                'errors' => $validator->getErrors(),
                'email' => $data['email'] ?? '',
            ], false);
            return;
        }

        $this->redirect('/');
    }
}