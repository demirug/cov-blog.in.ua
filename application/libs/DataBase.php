<?php

namespace application\libs;

class DataBase
{

    public $dbConnection;

    public function __construct()
    {
        $params = require 'application/config/database.php';
        $this->dbConnection = new \PDO("mysql:host=" . $params['host'] . ";dbname=" . $params['base'], $params['username'], $params['password']);
    }

    //Sample of usage database->query("INSERT INTO BlogRecords(blogid, title, text) VALUES (:id, :title, :text)", ['id' => 15, 'title' => 'MyTitle', 'text' => 'Text']);
    public function query($sql, $params = []) {

        $statement = $this->dbConnection->prepare($sql);
        if(!empty($params)) {
            foreach ($params as $key => $value) {
                $statement->bindValue(':'. $key, $value);
            }
        }

        $statement->execute();
        return $statement;
    }

    public function lastInsertId() {
        return $this->dbConnection->lastInsertId();
    }



}