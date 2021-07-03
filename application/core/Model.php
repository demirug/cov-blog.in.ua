<?php

namespace application\core;

use application\libs\DataBase;

abstract class Model
{

    private static $database;

    public abstract function onInitialize();

    public function getDataBase() {
        if(!isset(Model::$database)) Model::$database = new DataBase();
        return Model::$database;
    }

}