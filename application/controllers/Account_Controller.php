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

            $user = $this->model->getUserRecord($_POST["login"]);

            if(isset($user) && !empty($user)) {

                if($this->model->hash($_POST["password"], $user["sault"]) === $user["hash"]) {
                    $_SESSION["userName"] = strtolower($_POST['login']);
                    $_SESSION["userID"] = $user["id"];
                    $_SESSION["permissionLevel"] =  $user["permissionLevel"];
                    View::location('/');
                } else {
                    View::sendMessage('Error', "Неверный логин или пароль", 3);
                }

            } else {
                View::sendMessage('Error', "Неверный логин или пароль", 3);
            }

        } else {
            $this->view->render('Login page', [], ['/public/js/patternHandler.js', '/public/js/formHandler.js'], ["/public/styles/Account/account.css"]);
        }
    }

    public function register_Action() {

        if(isset($_SESSION['userID'])) { //If user already authorized redirect to main page
            View::redirect('/');
        }

        if(!empty($_POST)) {

            $result = $this->model->checkRegister($_POST["login"], $_POST["password"], $_POST["conf_password"], $_POST["email"]); //Return error is exists or OK message

            if($result[0] === 'OK') {
                $sault = $this->model->generateSault();

                $this->model->getDataBase()->query("INSERT INTO `Users` (`login`, `hash`, `sault`, `email`) VALUES (:login , :hash, :sault, :email)", ['login' => strtolower($_POST['login']), 'hash' => $this->model->hash($_POST['password'], $sault), 'sault' => $sault, 'email' => $_POST['email']]);

                View::sendMessage('Successful', 'Вы успешно зарегистрировались! Теперь авторизуйтесь', 1, 1300, '/login');

            } else  View::sendMessage('Error', $result, 3);

            return;
        }

        $this->view->render('Register page', [], ['/public/js/patternHandler.js', '/public/js/formHandler.js'], ["/public/styles/Account/account.css"]);
    }

    public function settings_Action($args) {

        if(!isset($_SESSION["userID"])) {
            View::error(403);
        }

        if(!empty($_POST)) {


            $result  = $this->model->checkSettings($_POST["old_password"], $_POST["new_password"], $_POST["new_password_repeat"]);

            if($result[0] !== "EMPTY") {

                if($result[0] === "OK") {

                    $user = $this->model->getUserRecord($_SESSION["userName"]);
                    if($this->model->hash($_POST["old_password"], $user["sault"]) === $user["hash"]) {
                        $this->model->getDataBase()->query("UPDATE `Users` SET `hash` = :hash WHERE id = :id", ["id" => $_SESSION["userID"], "hash" => $this->model->hash($_POST["new_password"], $user["sault"])]);
                    } else View::sendMessage("Error", "Incorrect old password", 3);

                } else {
                    View::sendMessage("Error", $result, 3);
                }

            }

            if($_FILES['file-input']['size'] != 0) { //If file exists

                //If size of file large than 2MB
                if ($_FILES['file-input']['size'] > 2097152) {
                    return;
                }

                $extension = pathinfo($_FILES['file-input']['name'], PATHINFO_EXTENSION);

                if ($extension == "png" || $extension !== "jpg" || $extension !== "jpeg") {


                    $url = "public/images/userdata/avatars/" . $_SESSION['userID'] . ".png";

                    imagepng(imagecreatefromstring(file_get_contents($_FILES['file-input']['tmp_name'])), $url); //Converting file to png and saved it
                }
            }

            View::sendMessage("Success", "Your account have been updated", 1, 1500, "/account/settings");

        } else {
            $this->view->render("Settings", ["userID" => $_SESSION["userID"]], ["/public/js/formHandler.js"], ["https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", "/public/styles/Account/settings.css"]);
        }
    }


}