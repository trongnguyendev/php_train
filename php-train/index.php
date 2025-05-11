<?php

session_start();

// Đường dẫn gốc của ứng dụng
// Tạo hằng số BASE_PATH để lưu đường dẫn gốc
define('BASE_PATH', __DIR__);

// Tự động load class khi gọi đến
spl_autoload_register(function ($className) {
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $file = BASE_PATH . DIRECTORY_SEPARATOR . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    return false;
});

// Lưu list các page tương ứng voi các controller
static $routesArr = [
    'GET' => [
        '/employee' => 'EmployeeController@index',
        '/employee/create' => 'EmployeeController@create',
        '/employee/edit/{id}' => 'EmployeeController@edit',
        '/employee/delete/{id}' => 'EmployeeController@delete',
        '/login' => 'AuthController@showLogin',
        '/' => 'DashboardController@index'
    ],
    'POST' => [
        '/employee/create' => 'EmployeeController@store',
        '/employee/edit/{id}' => 'EmployeeController@update',
        '/employee/delete/{id}' => 'EmployeeController@delete',
    ]
];

// Vd: localhost:9000/employee
// Lất path từ URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // $uri = /employee
$method = $_SERVER['REQUEST_METHOD']; // $method = GET | POST

$routes = $routesArr[$method] ?? [];
/* Route lúc này sẽ là:
$routes = [
    '/employee' => 'EmployeeController@index',
    '/employee/create' => 'EmployeeController@create',
    '/employee/edit/{id}' => 'EmployeeController@edit',
    '/employee/delete/{id}' => 'EmployeeController@delete',
    '/login' => 'AuthController@showLogin',
    '/' => 'DashboardController@index'
];
*/
// từ $uri và $method tìm ra controller và function tương ứng.
foreach ($routes as $route => $controller) {
    // Nếu route không có tham số thì $params sẽ là mảng rỗng
    // Ngược lại thì $params sẽ là mảng chứa các tham số
    // vd: /employee thì $params = []
    // vd: /employee/edit/{id} thì $params = [1] nếu path là: localhost:9000/employee/edit/1
    if ($route === $uri) {
        $params = [];
    } else {
        // Nếu route có tham số thì dùng preg_replace để thay thế
        // vd: /employee/edit/{id} thành /employee/edit/([^/]+)
        // sau đó dùng preg_match để tìm kiếm
        // preg_match sẽ trả về mảng $matches
        // $matches[0] là toàn bộ chuỗi khớp
        // $matches[1] là giá trị của tham số
        // vd: /employee/edit/1 thì $matches[1] = 1
        // $matches[2] là giá trị của tham số thứ 2
        $pattern = preg_replace('/\{([a-z]+)\}/', '([^/]+)', $route);
        $pattern = "#^" . $pattern . "$#";
        if (!preg_match($pattern, $uri, $matches)) {
            continue;
        }
        /*
         Nếu path là localhost:9000/employee/edit/1
         $matches = [
             0 => '/employee/edit/1',
             1 => '1'
        ];
        */
        // $matches[0] là toàn bộ chuỗi khớp
        // $matches[1] là giá trị của tham số
        array_shift($matches);
        // $matches = [1]
        $params = $matches;
    }

    // $controller sẽ có dạng: EmployeeController@index
    // $action sẽ là index
    // $controllerName sẽ là EmployeeController
    // $controllerClass sẽ là Controllers\EmployeeController
    // $controllerInstance sẽ là new Controllers\EmployeeController();
    list($controllerName, $action) = explode('@', $controller);
    $controllerClass = "Controllers\\{$controllerName}";

    if (class_exists($controllerClass)) {
        $controllerInstance = new $controllerClass();

        // Kiểm tra xem phương thức có tồn tại trong controller không
        // nếu có thì gọi phương thức đó
        if (method_exists($controllerInstance, $action)) {
            // Gọi phương thức với các tham số
            // $params sẽ là mảng chứa các tham số => $pảams = [1]
            return call_user_func_array([$controllerInstance, $action], $params);
        }
    }

    // Nếu không tìm thấy controller hoặc action
    throw new \Exception("Controller or action not found: {$controllerName}@{$action}");
}



?>
 