<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;

class Account_Controller extends Controller
{

    public function onInitialize() {}

    public function index_Action($args)
    {
        View::redirect('/login');
    }

    public function logout_Action() {
        unset($_SESSION['userID'], $_SESSION['userName'], $_SESSION['permissionLevel']);

        View::redirect('/login');
    }

    public function login_Action() {

        if(isset($_SESSION['userID'])) { //If user already authorized redirect to main page
            View::redirect('/');
        }

        if(!empty($_POST)) {

            $result = $this->model->checkLogin();

            if($result !== -1) {

                $_SESSION["userName"] = strtolower($_POST['login']);
                $_SESSION["userID"] = $result[0];
                $_SESSION["permissionLevel"] =  $result[1];
                View::location('/');

            } else  View::sendMessage('Error', "Неверный логин или пароль", 3);

            return;
        }

        $this->view->render('Login page', [], ['/public/js/patternHandler.js', '/public/js/formHandler.js'], ["/public/styles/account.css"]);
    }

    public function register_Action() {

        if(isset($_SESSION['userID'])) { //If user already authorized redirect to main page
            View::redirect('/');
        }

        if(!empty($_POST)) {

            $result = $this->model->checkRegister(); //Return error is exists or OK message

            if($result[0] === 'OK') {
                $sault = $this->model->generateSault();

                $this->model->database->query("INSERT INTO `Users` (`login`, `hash`, `sault`, `email`) VALUES (:login , :hash, :sault, :email)", ['login' => strtolower($_POST['login']), 'hash' => $this->model->hash($_POST['password'], $sault), 'sault' => $sault, 'email' => $_POST['email']]);

                View::sendMessage('Successful', 'Вы успешно зарегистрировались! Теперь авторизуйтесь', 1, 1300, '/login');

            } else  View::sendMessage('Error', $result, 3);

            return;
        }

        $this->view->render('Register page', [], ['/public/js/patternHandler.js', '/public/js/formHandler.js'], ["/public/styles/account.css"]);
    }

}