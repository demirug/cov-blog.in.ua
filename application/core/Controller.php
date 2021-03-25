<?php

namespace application\core;

use application\models;

abstract class Controller
{

    public $route;

    public $view;
    public $model;

    public function __construct($route)
    {
        $this->view = new View($route);
        $this->route = $route;

        $modelPath = 'application\models\\' . $this->route['controller'].'_Model';
        if (class_exists($modelPath)) {
            $model = new $modelPath();
            $model->onInitialize();
        }

    }

    public abstract function onInitialize();

    public abstract function index_Action($args);

}