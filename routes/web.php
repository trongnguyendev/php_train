<?php

require_once "../core/Router.php";
require_once "../app/controllers/HomeController.php";

Router::get('/', function() {
    echo 'Welcome to the homepage';
});

Router::dispatch();