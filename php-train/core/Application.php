<?php

namespace Core;

class Application {
    protected $router;
    
    public function __construct() {
        $this->router = new Router();
    }
    
    public function run() {
        // Get the current URI and HTTP method
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // $uri = /employee
        $method = $_SERVER['REQUEST_METHOD']; // $method = GET | POST
        
        // Handle the route
        $this->router->dispatch($uri, $method);
    }
}
?>
