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

    public function render($title, $params = [], $js = []) {

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


    // formHandler.js has handler for this json messages. Used with AJAX
    public static function location($url) {
        exit(json_encode(['url' => $url]));
    }

    public static function sendMessage($title, $message, $code = 1) {
        exit(json_encode(['title' => $title, 'message' => $message, 'code' => $code]));
    }

}