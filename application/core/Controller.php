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
            $this->model = new $modelPath();
            $this->model->onInitialize();
        }

        $this->onInitialize();

    }

    public abstract function onInitialize();

    public abstract function index_Action($args);

}