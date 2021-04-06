<?php

namespace application\models;

use \application\core\Model;

class Account_Model extends Model
{

    public function getConfig() {
        return require 'application/config/authorization.php';
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

        $user = $this->database->query('SELECT id, permissionLevel FROM Users WHERE login = :login AND hash = :password', ['login' => strtolower($login), 'password' => $password])->fetch(\PDO::FETCH_ASSOC);
        
        if(isset($user) && !empty($user)) {
            return array($user['id'], $user['permissionLevel']);
        } else return -1;

    }

    public function onInitialize()
    {
        $this->database->dbConnection->exec("
                CREATE TABLE IF NOT EXISTS Users (
                    `id` int NOT NULL AUTO_INCREMENT, 
                    `login` varchar(32) NOT NULL UNIQUE,
                    `hash` varchar(256) NOT NULL, 
                    `sault` varchar(16) NOT NULL,
                    `email` varchar(320) NOT NULL,
                    `permissionLevel` TINYINT DEFAULT 0,
                    `registerDate` DATE DEFAULT (CURRENT_DATE),
                    PRIMARY KEY (`id`)
                ) DEFAULT CHARSET=utf8 COLLATE utf8_bin AUTO_INCREMENT=0
        ");

        $this->database->dbConnection->exec("
                CREATE TABLE IF NOT EXISTS BlogList (
                    `blogid` int NOT NULL AUTO_INCREMENT, 
                    `userid` int NOT NULL,
                    `title` varchar(180) NOT NULL,
                    `description` varchar(1200) NOT NULL,
                    `region` varchar(16) NOT NULL,
                    `createDate` DATE DEFAULT (CURRENT_DATE),
                    PRIMARY KEY (`blogid`)
                ) DEFAULT CHARSET=utf8 COLLATE utf8_bin AUTO_INCREMENT=0
        ");

        $this->database->dbConnection->exec("
                CREATE TABLE IF NOT EXISTS BlogRecords (
                    `blogid` int NOT NULL, 
                    `title` varchar(180) NOT NULL,
                    `text` varchar(5000) NOT NULL,
                    `createDate` DATE DEFAULT (CURRENT_DATE)
                ) DEFAULT CHARSET=utf8 COLLATE utf8_bin
        ");
    }

    public function requireDataBase()
    {
        return true;
    }
}