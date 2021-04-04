<?php

namespace application\models;

use application\core\Model;

class Blog_Model extends Model
{

    public static function regionList() {
        return [
            'vinnytsia',
            'dnipro',
            'donetsk',
            'kiev',
            'lutsk',
            'lviv',
            'odesa',
            'simferopol',
            'kharkiv'
        ];
    }


    public function hasRegion($regName) {
        return in_array($regName, Blog_Model::regionList());
    }

    public function getUserID($username) {

        $statement = $this->database->query('SELECT id, login FROM Users WHERE login = :userName', ['userName' => $username]);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return ($result ? $result['id'] : -1);
    }

    public function getBlogsByUser($userName, $pageNumber, $blogsPerPage) {

        $userID = $this->getUserID($userName);

        if($userID === -1) { return null; }

        $statement = $this->database->query("SELECT * FROM BlogList WHERE userId = '$userID' LIMIT $blogsPerPage OFFSET " . ($pageNumber - 1) * $blogsPerPage);

        return  $statement->fetchAll();
    }


    public function getBlogIDByName($userID, $blogName) {
        $statement = $this->database->query("SELECT login as username, blogid FROM BlogList JOIN Users ON userID = '$userID' AND title = '$blogName'");
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return ($result ? $result['blogid'] : -1);
    }

    public function getPostsByUser($blogID, $pageNumber, $blogsPerPage) {
        $statement = $this->database->query("SELECT * FROM BlogRecords WHERE blogid = $blogID ORDER BY createDate");
        return  $statement->fetchAll();
    }

    public function getBlogsByRegion($regName, $pageNumber, $blogsPerPage) {

        $statement = $this->database->query("SELECT login as username, title, description, createDate, region FROM BlogList JOIN Users ON userID = id WHERE region = '$regName' LIMIT  $blogsPerPage OFFSET " . ($pageNumber - 1) * $blogsPerPage);
        return $statement->fetchAll();

    }

    public function onInitialize() {}

    public function requireDataBase()
    {
       return true;
    }
}