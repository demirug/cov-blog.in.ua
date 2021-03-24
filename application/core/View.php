<?php

namespace application\core;

class View
{

    public $layout = 'default';
    private $route;

    public function __construct($route)
    {
        $this->route = $route;
    }

    public function render($title, $params = []) {

        extract($params);

        ob_start();
        require 'application/views/' . $this->route['controller'] . '/' . $this->route['action'] . '.php';
        $content = ob_get_clean();

        require 'application/views/layout/' . $this->layout. '.php';
    }

    public static function redirect($url) {
        header('Location: '.$url);
        exit();
    }

    public static function error($code) {
        require 'application/views/codes/' . $code . '.php';
        http_response_code(403);
        exit();
    }

}