<?php


namespace application\controllers;

use application\core\Controller;
use application\core\View;

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
        unset($_SESSION['userID']);
        View::redirect('/login');
    }

    public function login_Action() {

        if(isset($_SESSION['userID'])) {
            View::redirect('/');
        }

        if(!empty($_POST)) {

            $result = $this->model->checkLogin();

            if($result !== -1) {

                $_SESSION["userID"] = $result;
                View::location('/');

            } else  View::sendMessage('Error', "Неверный логин или пароль", 3);

            return;
        }

        $this->view->render('Login page', [], ['/public/js/patternHandler.js', '/public/js/formHandler.js']);
    }

    public function register_Action() {

        if(isset($_SESSION['userID'])) {
            View::redirect('/');
        }

        if(!empty($_POST)) {

            $result = $this->model->checkRegister();

            if($result[0] === 'OK') {
                $this->model->database->query("INSERT INTO `users` (`login`, `hash`, `sault`, `email`) VALUES (:login , :hash, :sault, :email)", ['login' => $_POST['login'], 'hash' => $_POST['password'], 'sault' => 'saultWillBeSoon', 'email' => 'emailWillBeSoon']);

                $_SESSION["userID"] = $this->model->database->lastInsertId();;
                View::location('/');

            } else  View::sendMessage('Error', $result, 3);

            return;
        }

        $this->view->render('Register page', [], ['/public/js/patternHandler.js', '/public/js/formHandler.js']);
    }

}