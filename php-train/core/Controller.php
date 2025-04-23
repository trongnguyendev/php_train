<?php

namespace Core;

class Controller {

    protected function view($view, $data = [], $layout = true) 
    {
        extract($data);
        
        $viewFile = BASE_PATH . "/resources/views/{$view}.php";
        
        if (!file_exists($viewFile)) {
            throw new \Exception("View '{$view}' not found");
        }
        
        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        if (!$layout) {
            echo $content;
        } else {
            $layoutFile = BASE_PATH . "/resources/views/layouts/default.php";
            
            if (!file_exists($layoutFile)) {
                throw new \Exception("Layout not found");
            }
            require_once $layoutFile;
        }
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }

    protected function isLoginedIn() {
        return isset($_SESSION['user_id']);
    }

    protected function requireLogin() {
        if (!$this->isLoginedIn()) {
            $this->redirect('/login');
        }
    }

}