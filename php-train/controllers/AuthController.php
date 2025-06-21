<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Auth;

class AuthController extends Controller {
    
    public function showLogin() {
        if ($this->isLoginedIn()) $this->redirect('/');
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

        $loginIn = new Auth();

        $isLogin = $loginIn->login([
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if (!$isLogin) {
            $this->view('auth/login', [
                'errors' => ['Invalid email or password.'],
                'email' => $data['email'] ?? '',
            ], false);
            return;
        }

        $this->redirect('/');
    }

    public function logout() {
        unset($_SESSION['user_info']);
        $this->redirect('/login');
    }
}