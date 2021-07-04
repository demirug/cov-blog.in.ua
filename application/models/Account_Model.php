<?php

namespace application\models;

use \application\core\Model;

class Account_Model extends Model
{

    public function onInitialize() {}

    //If has troubles with registration exists will be returned error messages else returned OK
    public function checkRegister($login, $password, $confirmPassword, $email) {

        $settings = require 'application/config/authorization.php';
        $message = array();


        //-----

        if($password !== $confirmPassword) {
            array_push($message,'Пароли не совпадают');
        } else {

            if (strlen($password) < $settings['min-password-length']) {
                array_push($message, 'Слишком короткий пароль. Минимальная длина ' . $settings['min-password-length'] . ' символов');
            }

            if (strlen($password) > $settings['max-password-length']) {
                array_push($message, 'Слишком длинный пароль. Максимальная длина ' . $settings['max-password-length'] . ' символов');
            }

            if (!preg_match($settings['password-filter'], $password)) {
                array_push($message, 'Пароль содержит недопустимые символы. Допустимо только латинский алфавит и цифры');
            }
        }

        //----

        $user = $this->getDataBase()->query('SELECT login FROM Users WHERE login = :login', ['login' => $login])->fetch(\PDO::FETCH_ASSOC);
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

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($message, 'Некорректный email адресс');
        }

        $user = $this->getDataBase()->query('SELECT email FROM Users WHERE email = :email', ['email' => $email])->fetch(\PDO::FETCH_ASSOC);

        if(isset($user) && !empty($user)) {
            array_push($message,'Данный email уже используется');
        }

        //----

        if(empty($message)) {
            array_push($message, 'OK');

        }

        return $message;
    }

    public function checkSettings($oldPassword, $password, $passwordRepeat) {

        $message = array();

        if($oldPassword === "" && $password === "" && $passwordRepeat === "") {
            array_push($message, "EMPTY");
            return $message;
        }

        if($oldPassword === "" || $password === "" || $passwordRepeat === "") {
            array_push($message, "Все поля должны быть заполнены");
            return $message;
        }

        $settings = require 'application/config/authorization.php';


        if($password !== $passwordRepeat) {
            array_push($message,'Пароли не совпадают');
        } else {

            if (strlen($password) < $settings['min-password-length']) {
                array_push($message, 'Слишком короткий пароль. Минимальная длина ' . $settings['min-password-length'] . ' символов');
            }

            if (strlen($password) > $settings['max-password-length']) {
                array_push($message, 'Слишком длинный пароль. Максимальная длина ' . $settings['max-password-length'] . ' символов');
            }

            if (strlen($oldPassword) < $settings['min-password-length']) {
                array_push($message, 'Слишком короткий старый пароль. Минимальная длина ' . $settings['min-password-length'] . ' символов');
            }

            if (strlen($oldPassword) > $settings['max-password-length']) {
                array_push($message, 'Слишком длинный старый пароль. Максимальная длина ' . $settings['max-password-length'] . ' символов');
            }

            if (!preg_match($settings['password-filter'], $password)) {
                array_push($message, 'Пароль содержит недопустимые символы. Допустимо только латинский алфавит и цифры');
            }
        }

        if(empty($message)) {
            array_push($message, 'OK');
        }


        return $message;

    }

    //Returned sql row with user data from database
    public function getUserRecord($login) {
        return $this->getDataBase()->query('SELECT id, permissionLevel, hash, salt FROM Users WHERE login = :login', ['login' => strtolower($login)])->fetch(\PDO::FETCH_ASSOC);
    }

    function generateSalt() {
        $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/\\][{}\'";:?.>,<!@#$%^&*()-_=+|';
        $randStringLen = 16;

        $randString = "";
        for ($i = 0; $i < $randStringLen; $i++) {
            $randString .= $charset[mt_rand(0, strlen($charset) - 1)];
        }

        return $randString;
    }

    public function hash($password, $salt) {

        $hash = $password . $salt;

        for($i = 0; $i < 10; $i++) {
            $hash = hash('sha256', $hash);
        }

        return $hash;
    }

}