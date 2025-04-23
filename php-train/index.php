<?php

session_start();

define('BASE_PATH', __DIR__);

require_once 'core/Autoloader.php';
new Core\Autoloader();

require_once 'routes/web.php';

$app = new Core\Application();
$app->run();

?>
 