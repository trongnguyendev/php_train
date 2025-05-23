<?php

namespace Core;

class Router {
    protected static $routes = [
        'GET' => [],
        'POST' => []
    ];

    protected static $routes1 = [
        'GET' => [
            '/' => 'DashboardController@index',
            '/login' => 'AuthController@showLogin',
            'employee' => 'EmployeeController@index',
            'employee/create' => 'EmployeeController@create',
            'employee/edit/{id}' => 'EmployeeController@edit',

            'customer' => 'CustomerController@index',
            'customer/create' => 'CustomerController@create',
            'customer/edit/{id}' => 'CustomerController@edit',
            'customer/delete/{id}' => 'CustomerController@delete',

            'user' => 'UserController@index',
            'user/create' => 'UserController@create',
            'user/edit/{id}' => 'UserController@edit',
            'user/delete/{id}' => 'UserController@delete',

            'login/create' => 'LoginController@login',

            'logout' => 'LoginController@logout',
        ],
        'POST' => [
            'employee/create' => 'EmployeeController@store',
            'employee/edit/{id}' => 'EmployeeController@update',
            'employee/delete/{id}' => 'EmployeeController@delete',
            
            'customer/create' => 'CustomerController@store',
            'customer/edit/{id}' => 'CustomerController@update',

            'user/create' => 'UserController@store',
            'user/edit/{id}' => 'UserController@update',

            'login/create' => 'LoginController@create',
            
        ]
    ];
    
    public static function get($uri, $controller) {
        self::$routes['GET'][$uri] = $controller;
    }
    
    public static function post($uri, $controller) {
        self::$routes['POST'][$uri] = $controller;
    }
    
    public function dispatch($uri, $method) { // $uri = /employee | $method = GET
        $uri = $this->removeQueryString($uri);
        
        // Check for exact match
        if (isset(self::$routes[$method][$uri])) { // self::$routes[$method][$uri] = EmployeeController@index
            return $this->callAction(self::$routes[$method][$uri]);
        }
        
        // Check for pattern matches (like /employee/edit/1)
        // employee/1 =>  'EmployeeController@edit'
        foreach (self::$routes[$method] as $route => $controller) {
            $pattern = preg_replace('/\{([a-z]+)\}/', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                return $this->callAction($controller, $matches); //  $controller = 'EmployeeController@edit' | $matches = 1
            }
        }
        
        // No route found
        $this->renderView('404');
    }
    
    protected function callAction($controller, $params = []) { // $controller = 'EmployeeController@index'
        list($controller, $action) = explode('@', $controller); // => $controller = 'EmployeeController'; $action = 'index';

        $controllerClass = "Controllers\\{$controller}"; // => $controllerClass = "Controllers\\EmployeeController";

        if (class_exists($controllerClass)) {
            $controllerInstance = new $controllerClass(); // => $controllerInstance = new EmployeeController();
            
            if (method_exists($controllerInstance, $action)) {

                $request = new Request();
                if ($request->all()) {
                    $params[] = $request;
                }

                return call_user_func_array([$controllerInstance, $action], $params); // => call_user_func_array([$controllerInstance, 'index'], $params);
            }
        }
        
        throw new \Exception("Controller or action not found: {$controller}@{$action}");
    }
    
    protected function removeQueryString($uri) {
        if ($uri === '') {
            return '/';
        }
        
        return $uri;
    }
    
    protected function renderView($view, $data = []) {
        extract($data);
        require_once BASE_PATH . "./resources/views/{$view}.php";
    }
}
?>