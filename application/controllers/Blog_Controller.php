<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;

class Blog_Controller extends Controller
{

    /*
     * All available requests
     *
     * cov-blog.in.ua/blogs/{userName}
     * cov-blog.in.ua/blogs/{userName}/{blogName/blogid}/{page}
     *
     * cov-blog.in.ua/blogs/{regionName}
     * cov-blog.in.ua/blogs/{regionName}/{page}
     *
     * cov-blog.in.ua/view/{userName}/{blogName/blogid}/{page}
     *
     * cov-blog.in.ua/edit/{blogid}
     * cov-blog.in.ua/add/{blogName}
    */

    public function onInitialize() {}

    public function index_Action($args) {
        View::redirect('/');
    }

    public function blogs_Action($args) {

        $argsLength = count($args); //Getting count of arguments

        if($argsLength == 0) { //Return to main page if arguments not getted
            View::redirect('/');
        } else {

            //Getting current page number and the number of blogs that can be displayed on page
            $blogConfig = require 'application/config/blog.php';
            $blogsPerPage = $blogConfig['blog-list']['blogs-rows'] * $blogConfig['blog-list']['blogs-columns'];
            $pageNumber = 1;

            if($argsLength > 1 && is_numeric($args[1]) && $args[1] >= 1) {
                $pageNumber = $args[1];
            }


            if($this->model->hasRegion($args[0])) { //If first arguments is region

                $result = $this->model->getBlogsByRegion($args[0], $pageNumber, $blogsPerPage); //Getting all blogs by region
                echo "Блоги пользователей по области: $args[0] | Страница: $pageNumber <hr>";

                foreach ($result as $value) {
                    echo 'Author: ' . $value['username'] . ' | ' .$value['title'] . ' | ' . $value['description'] . ' | Created: ' . $value['createDate'] . '<br>';
                    echo "<span>To read blog <a href='/view/" . $value['username'] . '/' . str_replace(' ', '-', $value['title']) . "'>click here</a></span><br><hr>";
                }


            } else {

                $result = $this->model->getBlogsByUser($args[0], $pageNumber, $blogsPerPage);
                if(isset($result)) { //Check if first argument is username

                    echo "Блоги пользователя: $args[0] | Страница: $pageNumber <hr>";

                    foreach ($result as $value) {
                        echo  $value['title'] . ' | ' . $value['description'] . ' | Created: ' . $value['createDate'] . '<br>';
                        echo "<span>To read blog <a href='/view/$args[0]/" . str_replace(' ', '-', $value['title']) . "'>click here</a></span><br><hr>";
                    }

                } else {
                    View::error(404);
                }
            }
        }
    }

    public function view_Action($args) {

        $argsLength = count($args);

        if($argsLength == 0) {
            View::redirect('/');
        }

        if($argsLength == 1) { //If blog name not setted redirect to all user blogs
            View::redirect('/blogs/' . $args[0]);
        }

        $userID = $this->model->getUserID($args[0]);

        if($userID === -1) {
            View::error(404);
        }

        $blogID = $this->model->getBlogIDByName($userID, str_replace('-', ' ', $args[1]));
        if($blogID === -1) {
            View::redirect('/blogs/' . $args[0]);
        }

        $result = $this->model->getPostsByUser($blogID, 1, 5);

        echo "<center><h1>" . str_replace('-', ' ', $args[1]) ."</h1></center>";

        if(count($result) == 0) {
         echo '<hr><center>Blog is empty!<br>Soon here will be text :D</center>';
        } else {

            foreach ($result as $value) {
                echo "<hr><h3>" . $value['title'] . "</h3>" . "<span>" . $value['text'] . "</span><br>" . $value['createDate'] . "<hr>";
            }
        }

        //If current user is blog author.. Adding button for creation new record to current blog
        if(isset($_SESSION['userID']) && $_SESSION['userID'] === $userID) {
            echo "<center><input type='button' onclick=\"location.href='/add/$args[1]';\" value='Add record'></center>";
        }
    }

    public function add_Action($args) {

        if(!isset($_SESSION['userID'])) {
            View::error(403);
        }

        if(count($args) == 0) {
            View::redirect('/');
        }

        $blogID = $this->model->getBlogIDByName($_SESSION['userID'], str_replace("-", " ", $args[0]));

        if($blogID === -1) {
            View::error(403);
        }

        if(!empty($_POST)) {

            if(!isset($_POST['text']) || strip_tags($_POST['text']) === '') { //If text of blog record is empty... send warning message
                View::sendMessage("Info", "Blog record must contain text!", 2, 2500);
            }

            $this->model->database->query("INSERT INTO `BlogRecords` (`blogid`, `title`, `text`) values ($blogID, :title, :text)", ["title" => $_POST['title'], "text" => $_POST['text']]);
            View::sendMessage("Success", "Record to blog added", 1, 1000, ('/view/'.$_SESSION['userName'].'/'. $args[0]));
        }

        $this->view->render("Add record", ["blogName" => str_replace("-", " ", $args[0])], ['/public/js/formHandler.js']);
    }


    public function create_Action($args) {

        if(!isset($_SESSION['userID'])) {
            View::error(403);
        }

        if(!empty($_POST)) {

            //If blog with that name already exists... send Error message
            if($this->model->getBlogIDByName($_SESSION['userID'], str_replace("-", " ", $_POST['title'])) !== -1) {
                View::sendMessage("Error", "Blog with that name already exists", 3);
            }

            $this->model->database->query("INSERT INTO `BlogList` (`userid`, `title`, `description`, `region`) values (:user, :title, :description, :region)", ["user" => $_SESSION['userID'], "title" => $_POST['title'], "description" => $_POST['description'], "region" => $_POST['region']]);
            View::sendMessage("Success", "Blog created", 1, 1000, ('/view/' . $_SESSION['userName'] .'/'. str_replace(" ", "-", $_POST['title'])));
        }

        $this->view->render("Create blog", [], ['/public/js/formHandler.js']);

    }

    public function edit_Action($args) {

    }


}