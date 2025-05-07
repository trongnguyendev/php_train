<?php

namespace Core;

class Request {
    protected $params = [];
    protected $query = [];
    protected $request = [];

    public function __construct() {
        $this->request = $_POST;
        $this->query = $_GET;
        $this->params = array_merge($_GET, $_POST);
    }

    public function all() {
        return $this->params;
    }

    public function input($key = null, $default = null) {
        if (is_null($key)) {
            return [];
        }
        return $this->request[$key] ?? $default;
    }

    public function query($key = null, $default = null) {
        if (is_null($key)) {
            return [];
        }
        return $this->query[$key] ??  $default;
    }

    public function has($key) {
        return isset($this->request[$key]);
    }
}