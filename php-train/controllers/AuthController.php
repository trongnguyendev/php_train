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

    public function postLogin() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $errors = [];

        // Validate input
        if (empty($email)) {
            $errors['email'] = 'Email is required';
        }

        if (empty($password)) {
            $errors['password'] = 'Password is required';
        }

        if (empty($errors)) {
//            $user = new User();
//            $loggedInUser = $user->validateLogin($email, $password);
            $loggedInUser = [];

            if ($loggedInUser) {
                // Store user data in session
                $_SESSION['user_id'] = $loggedInUser['id'];
                $_SESSION['user_name'] = $loggedInUser['name'];
                $_SESSION['user_email'] = $loggedInUser['email'];

                $this->redirect('/');
            } else {
                $errors['login'] = 'Invalid email or password';
            }
        }

        // If we get here, login failed
        $this->view('auth/login', [
            'errors' => $errors,
            'email' => $email,
        ], false);
    }
}