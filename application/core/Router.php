<?php

namespace application\core;

class Router
{

    private $shortRoutes;

    public function __construct()
    {
        $this->shortRoutes = require 'application/config/shortRoutes.php';
    }

    public function run() {

        $address = strtolower(trim($_SERVER['REQUEST_URI'], '/'));
        $url = explode('/', $address);

        $controllerPath = 'application\controllers\\';
        $method = 'index_Action';
        $args = $url;

        if(array_key_exists($url[0], $this->shortRoutes)) {
            $controllerPath .= $this->shortRoutes[$url[0]]['controller'] . '_Controller';
            $method = $this->shortRoutes[$url[0]]['action'] . '_Action';

            array_shift($args);
        } else {

            $controllerPath .= ucfirst($url[0]) . '_Controller';

            if (!class_exists($controllerPath)) {
                View::error(404);
            }

            $args = array_shift($url);

            if(isset($url[1])) {

                if (method_exists($controllerPath, $url[1] . '_Action')) {
                    $method = $url[1] . '_Action';
                    array_shift($args);
                } else {
                    View::redirect('/' . $url[0]);
                }
            }
        }

       $controller = new $controllerPath(['controller' => array_key_exists($url[0], $this->shortRoutes) ? $this->shortRoutes[$url[0]]['controller'] : ucfirst($url[0]), 'action' => substr($method, 0, -7)]);
       $controller->$method($args);
    }

}