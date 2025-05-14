<?php

namespace Core;

class Controller {

    // Hiển thị view
    // $view: tên view
    // $data: dữ liệu truyền vào view
    // $layout: có sử dụng layout hay không
    protected function view($view, $data = [], $layout = true) 
    {
        // $data là mảng chứa dữ liệu truyền vào view
        extract($data);

        $viewFile = BASE_PATH . "/resources/views/{$view}.php";
        
        if (!file_exists($viewFile)) {
            throw new \Exception("View '{$view}' not found");
        }

        $content = $viewFile;

        // Kiểm tra xem có sử dụng layout hay không
        // nếu không sử dụng layout thì chỉ cần require view
        // nếu sử dụng layout thì require layout
        if (!$layout) {
            require_once $viewFile;
        } else {
            $layoutFile = BASE_PATH . "/resources/views/layouts/default.php";
            
            if (!file_exists($layoutFile)) {
                throw new \Exception("Layout not found");
            }
            require_once $layoutFile;
        }
    }
}