<?php

namespace application\controllers;

use application\core\Controller;

class Blog_Controller extends Controller
{

    public function onInitialize()
    {
        // TODO: Implement onInitialize() method.
    }

    public function index_Action($args) {
        print_r($args);
    }
}