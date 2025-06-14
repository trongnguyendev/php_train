<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Validation;
use Models\Login;

class LoginController extends Controller {
    public function login(){
        // $login = new Login();
        $this->view('login/login',[
            'pageTitle' => 'Đăng Nhập'
        ], false);
    }

    public function create( Request $request){
        $data = $request->all();

        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $messages = [
            'username.required' => 'Bắt buộc nhập User',
            'password.required' => 'Bắt buộc nhập Password'
        ];

        $validator = new Validation($data, $rules, $messages);

        if(!$validator->validate()){
            $this->view('login/create',[
                'pageTitle' => 'Đăng Nhập',
                'errors' => $validator->getErrors(),
                'oldInput' => $data,
            ]);
            return;
        }

        $loginIn = new Login();

        $isLogin = $loginIn->login([
            'username' => $data['username'],
            'password' => $data['password']
        ]);

        
        if($isLogin == true){
            header("Location: /");
            exit;
        }
        header("Location: /login/create");
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_info']);
        header("Location: /login/create");
    }
}
