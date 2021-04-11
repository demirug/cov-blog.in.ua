<?php

namespace application\models;

use \application\core\Model;

class Account_Model extends Model
{

    public function onInitialize() {}

    public function requireDataBase()
    {
        return true;
    }

    //If has troubles with registration exists will be returned error messages else returned OK
    public function checkRegister() {

        $settings = require 'application/config/authorization.php';
        $message = array();

        $login = $_POST['login'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['conf_password'];


        //-----

        if($password !== $confirmPassword) {
            array_push($message,'Пароли не совпадают');
        } else {

            if (strlen($password) < $settings['min-password-length']) {
                array_push($message, 'Слишком короткий пароль. Минимальная длина ' . $settings['min-password-length'] . ' символов');
            }

            if (strlen($login) > $settings['max-password-length']) {
                array_push($message, 'Слишком длинный логин. Максимальная длина ' . $settings['max-password-length'] . ' символов');
            }

            if (!preg_match($settings['password-filter'], $login)) {
                array_push($message, 'Пароль содержит недопустимые символы. Допустимо только латинский алфавит и цифры');
            }
        }

        //----

        $user = $this->database->query('SELECT login FROM Users WHERE login = :login', ['login' => $login])->fetch(\PDO::FETCH_ASSOC);
        if(isset($user) && !empty($user)) {
            array_push($message,'Пользователь с данным логином уже существует');
        } else {

            if (strlen($login) < $settings['min-login-length']) {
                array_push($message, 'Слишком короткий логин. Минимальная длина ' . $settings['min-login-length'] . ' символов');
            }

            if (strlen($login) > $settings['max-login-length']) {
                array_push($message, 'Слишком длинный логин. Максимальная длина ' . $settings['max-login-length'] . ' символов');
            }

            if (!preg_match($settings['login-filter'], $login)) {
                array_push($message, 'Логин имеет недопустимые символы. Допустимо только латинский алфавит и цифры');
            }
        }

        //----

        if(empty($message)) {
            array_push($message, 'OK');

        }

        return $message;
    }

    //If user with login and password founded returned his id and permission level else return -1
    public function checkLogin() {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $user = $this->database->query('SELECT id, permissionLevel, hash, sault FROM Users WHERE login = :login', ['login' => strtolower($login)])->fetch(\PDO::FETCH_ASSOC);
        
        if(isset($user) && !empty($user)) {

            if($this->hash($_POST['password'], $user['sault']) === $user['hash']) {
                return array($user['id'], $user['permissionLevel']);
            } else return -1;
        } else return -1;

    }

    function generateSault() {
        $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/\\][{}\'";:?.>,<!@#$%^&*()-_=+|';
        $randStringLen = 16;

        $randString = "";
        for ($i = 0; $i < $randStringLen; $i++) {
            $randString .= $charset[mt_rand(0, strlen($charset) - 1)];
        }

        return $randString;
    }

    public function hash($password, $sault) {

        $hash = $password . $sault;

        for($i = 0; $i < 10; $i++) {
            $hash = hash('sha256', $hash);
        }

        return $hash;
    }

}