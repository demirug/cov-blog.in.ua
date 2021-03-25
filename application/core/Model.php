<?php

namespace application\core;

use application\libs\DataBase;

abstract class Model
{

    public $database;

    public function __construct()
    {

        if($this->requireDataBase() === true) {
            $this->database = new DataBase();
        }

    }

    public abstract function onInitialize();
    public abstract function requireDataBase();

}