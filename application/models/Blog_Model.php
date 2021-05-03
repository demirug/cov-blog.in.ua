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

    public function getBlogsCountByUser($userName) {
        $userID = $this->getUserID($userName);

        if($userID === -1) return 0;
        $statement = $this->database->query("SELECT COUNT(*) as count FROM `BlogList` WHERE userId = '$userID'");

        return $statement->fetch()['count'];
    }

    public function getRecordsCount($blogID) {
        $statement = $this->database->query("SELECT COUNT(*) as count FROM `BlogRecords` WHERE blogID = '$blogID'");
        return $statement->fetch()['count'];
    }

    public function getBlogIDByName($userID, $blogName) {
        $statement = $this->database->query("SELECT blogid FROM BlogList WHERE userid = '$userID' and title = '$blogName'");
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return ($result ? $result['blogid'] : -1);
    }

    public function getBlogByID($blogID) {
        $statement = $this->database->query("SELECT * FROM BlogList WHERE blogid = '$blogID'");
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function getPostsByUser($blogID, $pageNumber, $blogsPerPage) {
        $statement = $this->database->query("SELECT * FROM BlogRecords WHERE blogid = $blogID ORDER BY createDate LIMIT $blogsPerPage OFFSET " . ($pageNumber - 1) * $blogsPerPage);
        return  $statement->fetchAll();
    }

    public function getBlogDescription($blogID) {
        $statement = $this->database->query("SELECT description FROM BlogList WHERE blogid = '$blogID'");
        return $statement->fetch(\PDO::FETCH_ASSOC)["description"];
    }

    public function getBlogsByRegion($regName, $pageNumber, $blogsPerPage) {

        $statement = $this->database->query("SELECT login as username, blogid, title, description, createDate, region FROM BlogList JOIN Users ON userID = id WHERE region = '$regName' LIMIT  $blogsPerPage OFFSET " . ($pageNumber - 1) * $blogsPerPage);
        return $statement->fetchAll();
    }

    public function getBlogsCountByRegion($regName) {
        $statement = $this->database->query("SELECT COUNT(*) as count FROM BlogList WHERE region = '$regName'");

        return $statement->fetch()['count'];
    }

    public function onInitialize() {}

    public function requireDataBase()
    {
       return true;
    }
}