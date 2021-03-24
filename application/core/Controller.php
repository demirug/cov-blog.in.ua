<?php

namespace application\core;

abstract class Controller
{

    public $route;

    public $view;
    public $model;

    public function __construct($route)
    {
        $this->view = new View($route);

    }

    public abstract function onInitialize();

    public abstract function index_Action($args);

}