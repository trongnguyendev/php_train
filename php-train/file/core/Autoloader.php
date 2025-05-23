<?php
namespace Core;

class Autoloader {
    public function __construct() {
        spl_autoload_register(function ($className) {
            $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
            $file = BASE_PATH . DIRECTORY_SEPARATOR . $className . '.php';
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
            return false;
        });
    }
}
?>