<?php

namespace application\controllers;

use application\core\Controller;
use application\libs\DataBase;

class Main_Controller extends Controller
{

    public function onInitialize()
    {
        // TODO: Implement onInitialize() method.
    }

    public function index_Action($args) {
        $this->view->render('Main page');
    }

    public function contact_Action() {
        $this->view->render("Обратная связь");
    }

}