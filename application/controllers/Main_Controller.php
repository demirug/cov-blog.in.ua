<?php

namespace application\controllers;

use application\core\Controller;

class Main_Controller extends Controller
{

    public function onInitialize()
    {
        // TODO: Implement onInitialize() method.
    }

    public function index_Action($args) {
        $this->view->render('Main page', ['kek' => '23']);
    }

    public function test_Action($argument) {

    }

    public function contact_Action() {
        $this->view->render("Обратная связь");
    }
}