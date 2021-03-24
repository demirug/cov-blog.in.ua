<?php

use \application\core\Model;

class Account_Model extends Model
{

    public function requireDataBase()
    {
        return false;
    }

    public function getConfig() {
        return require 'application/config/authorization.php';
    }

}