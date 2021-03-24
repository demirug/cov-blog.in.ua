<?php


namespace application\controllers;

use application\core\Controller;

class Account_Controller extends Controller
{

    public function onInitialize()
    {
        // TODO: Implement onInitialize() method.
    }

    public function index_Action($args)
    {
        $this->view->render('Index page');
    }

    public function logout_Action() {
        $this->view->render('Logout page');
    }

    public function login_Action() {
        $this->view->render('Login page', [], ['/public/js/patternHandler.js']);
    }

    public function register_Action() {
        $this->view->render('Register page', [], ['/public/js/patternHandler.js']);
    }

}