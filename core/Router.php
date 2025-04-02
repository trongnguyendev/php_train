<?php

class Router {
    private static $routes = [];

    public static function get($uri, $callback) {
        // var_dump(__DIR__);
        self::$routes['GET'][$uri] = $callback;
    }

    public static function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        var_dump($uri);
        $uri = str_replace('project/public/index.php', '', $uri);

        if (isset(self::$routes[$method][$uri])) {
            call_user_func(self::$routes[$method][$uri]);
        } else {
            echo "404 - Page Not Found";
        }
    }
}