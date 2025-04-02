<?php
require_once "../core/Controller.php";
// require_once "../app/models/"

class HomeController extends Controller {
    public function dashboard() {
        $users = [
            '123',
            '456'
        ];
        return $this->view('dashboard', ['users' => $users]);
    }
}