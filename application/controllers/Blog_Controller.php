<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\libs\Pagination;

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
     * cov-blog.in.ua/edit/{blogid}/{recordDate}
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
            $blogsPerPage = $blogConfig['blog-list'];
            $pageNumber = 1;

            if($argsLength > 1 && is_numeric($args[1]) && $args[1] >= 1) {
                $pageNumber = $args[1];
            }


            if($this->model->hasRegion($args[0])) { //If first arguments is region

                $result = $this->model->getBlogsByRegion($args[0], $pageNumber, $blogsPerPage); //Getting all blogs by region

                // If count of blogs == 0 show 404
                // but if it's first page (blogs at that region not exists at all)
                // dont show 404 page
                if(count($result) == 0 && $pageNumber != 1) {
                    View::error(404);
                }

                //echo "Блоги пользователей по области: $args[0] | Страница: $pageNumber <hr>";

                $this->view->render("Blogs of " . $args[0] . " region", ['blogs' => $result, 'isRegion' => true], [], ["/public/styles/Blog/blog.css"]);

                $pagination = new Pagination($this->model->getBlogsCountByRegion($args[0]), $blogsPerPage);

                $pagination->setRedirectURL('/blogs/'.$args[0]);
                $pagination->setPageNumber($pageNumber);
                $pagination->renderPagination();

            } else {

                $result = $this->model->getBlogsByUser($args[0], $pageNumber, $blogsPerPage);
                if(isset($result)) { //Check if first argument is valid user

                    //echo "Блоги пользователя: $args[0] | Страница: $pageNumber <hr>";

                    $this->view->render(ucfirst($args[0]) . "'s blogs", ['blogs' => $result, 'userName' => $args[0], 'isRegion' => false], [], ["/public/styles/Blog/blog.css"]);

                    $pagination = new Pagination($this->model->getBlogsCountByUser($args[0]), $blogsPerPage);

                    $pagination->setRedirectURL('/blogs/'.$args[0]);
                    $pagination->setPageNumber($pageNumber);
                    $pagination->renderPagination();

                } else {
                    View::error(404);
                }
            }
        }
    }

    public function view_Action($args)
    {

        $argsLength = count($args);

        if ($argsLength == 0) {
            View::redirect('/');
        }

        if ($argsLength == 1) {

            View::redirect('/blogs/' . $args[0]);
        }

        $userID = $this->model->getUserID($args[0]);

        if ($userID === -1) {
            View::error(404);
        }

        $blogID = $this->model->getBlogIDByName($userID, str_replace('-', ' ', $args[1]));

        if ($blogID === -1) {
            View::redirect('/blogs/' . $args[0]);
        }

        $blogConfig = require 'application/config/blog.php';
        $blogsPerPage = $blogConfig['blog-view'];
        $pageNumber = 1;

        if($argsLength > 2 && is_numeric($args[2]) && $args[2] >= 1) {
            $pageNumber = $args[2];
        }

        $result = $this->model->getPostsByUser($blogID, $pageNumber, $blogsPerPage);

        $description = "";

        if($pageNumber == 1) {
            $description = $this->model->getBlogDescription($blogID);
        }

        if(count($result) === 0 && $pageNumber !== 1) {
            View::error(404);
        }

        $this->view->render(("View blog of " . $args[1]), ["description" => $description, "blogid" => $blogID, "results" => $result, "page" => $pageNumber, "title" => str_replace('-', ' ', $args[1])], [], ["/public/styles/pagination.css", "/public/styles/Blog/blogView.css"]);

        $pagination = new Pagination($this->model->getRecordsCount($blogID), $blogsPerPage);

        $pagination->setRedirectURL("/view/" . $args[0]. "/" . $args[1]);
        $pagination->setPageNumber($pageNumber);
        $pagination->renderPagination();

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

            if (!preg_match("/[A-Za-zА-Яа-я0-9 ]/", $_POST['title'])) {
                View::sendMessage("Error", "Form contains incorrect symbols", 3);
            }

            if(strlen($_POST['title']) < 5) {
                View::sendMessage("Error", "Too short title. At least 5 symbols required");
            }

            //If blog with that name already exists... send Error message
            if($this->model->getBlogIDByName($_SESSION['userID'], str_replace("-", " ", $_POST['title'])) !== -1) {
                View::sendMessage("Error", "Blog with that name already exists", 3);
            }

            $this->model->database->query("INSERT INTO `BlogList` (`userid`, `title`, `description`, `region`) values (:user, :title, :description, :region)", ["user" => $_SESSION['userID'], "title" => $_POST['title'], "description" => $_POST['description'], "region" => $_POST['region']]);
            View::sendMessage("Success", "Blog created", 1, 1000, ('/view/' . $_SESSION['userName'] .'/'. str_replace(" ", "-", $_POST['title'])));
        }

        $this->view->render("Create blog", [], ['/public/js/formHandler.js', '/public/js/patternHandler.js']);

    }

    public function edit_Action($args) {

        $argsLength = count($args);

        if($argsLength == 0) {
            View::redirect('/');
        }

        if(!isset($_SESSION['userID'])) {
            View::error(403);
        }

        $blogID = $this->model->getBlogIDByName($_SESSION['userID'],  str_replace("-", " ", $args[0]));

        if($blogID === -1) {
            View::error(403);
        }

        $blog = $this->model->getBlogByID($blogID);

        if(!empty($_POST)) {
            $this->model->database->query("UPDATE BlogList SET title = :title, description = :description, region = :region WHERE blogid = :blogid", ["title" => $_POST['title'], "description" => $_POST['description'], "region" => $_POST['region'], "blogid" => $blogID]);
            View::sendMessage("Success", "Blog configuration updated", 1, 1000, ('/view/' . $_SESSION['userName'] .'/'. str_replace(" ", "-", $_POST['title'])));
        }

        $this->view->render("Edit blog", ["blogName"=> $blog['title'], "blogDescription"=> $blog['description'], "blogRegion" => $blog['region']], ['/public/js/formHandler.js']);

    }


}