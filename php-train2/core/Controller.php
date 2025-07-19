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
        return isset($_SESSION['user_info']);
    }

    protected function requireLogin() {
        if (!$this->isLoginedIn()) {
            $this->redirect('/login');
        }
    }

    /**
     * Upload file hình ảnh/video
     * @param string $inputName Tên input file
     * @param string $uploadDir Thư mục lưu file
     * @return array ['path' => đường_dẫn, 'error' => lỗi nếu có]
     */
    protected function uploadImage($inputName = 'image', $uploadDir = 'storage/public/', $onlyImage = true) {
        if (!isset($_FILES[$inputName])) {
            return ['path' => null, 'error' => null];
        }
        if ($_FILES[$inputName]['error'] === UPLOAD_ERR_NO_FILE) {
            return ['path' => null, 'error' => 'Lỗi upload file: ' . $_FILES[$inputName]['error']];
        }
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileTmpPath = $_FILES[$inputName]['tmp_name'];
        // Kiểm tra kiểu file là ảnh nếu yêu cầu
        if ($onlyImage) {
            $imageInfo = @getimagesize($fileTmpPath);
            // Có thể kiểm tra thêm mime type nếu muốn giới hạn loại ảnh
            $allowedTypes = ['image/jpg','image/jpeg','image/png','image/gif','image/webp','image/bmp','image/svg+xml'];
            if (!is_array($imageInfo) || !in_array($imageInfo['mime'], $allowedTypes)) {
                return ['path' => null, 'error' => 'Chỉ cho phép các định dạng ảnh jpeg, png, gif, webp, bmp, svg!'];
            }
        }
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES[$inputName]['name']));
        $destPath = $uploadDir . $fileName;
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            return ['path' => '/' . ltrim($destPath, '/'), 'error' => null];
        } else {
            return ['path' => null, 'error' => 'Không thể lưu file upload.'];
        }
    }
}