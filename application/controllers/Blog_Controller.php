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

                $this->view->render("Blogs of " . $args[0] . " region", ['blogs' => $result, 'isRegion' => true], ["/public/js/Blog/createBlogButton.js"], ["/public/styles/pagination.css", "/public/styles/Blog/blog.css"]);

                $pagination = new Pagination($this->model->getBlogsCountByRegion($args[0]), $blogsPerPage);

                $pagination->setRedirectURL('/blogs/'.$args[0]);
                $pagination->setPageNumber($pageNumber);
                $pagination->renderPagination();

            } else {

                $result = $this->model->getBlogsByUser($args[0], $pageNumber, $blogsPerPage);
                if(isset($result)) { //Check if first argument is valid user

                    //echo "Блоги пользователя: $args[0] | Страница: $pageNumber <hr>";

                    $this->view->render(ucfirst($args[0]) . "'s blogs", ['blogs' => $result, 'userName' => $args[0], 'isRegion' => false], ["/public/js/Blog/addBlogButton"], ["/public/styles/pagination.css", "/public/styles/Blog/blog.css"]);

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

        $canEdit = false;

        if(isset($_SESSION['userID']) && $this->model->hasAccessToBlog($_SESSION['userID'], $blogID)) {
            $canEdit = true;
        }

        $this->view->render(("View blog of " . $args[1]),
            ["userid" => $userID, "description" => $description, "blogid" => $blogID, "canEdit" => $canEdit, "results" => $result, "page" => $pageNumber, "title" => str_replace('-', ' ', $args[1])],
            ["/public/js/ckeditor/ckeditor.js", "/public/js/Blog/editRecordButton.js", "/public/js/Blog/addRecordButton.js"],
            ["/public/styles/pagination.css", "/public/styles/Blog/blogView.css"]
        );

        $pagination = new Pagination($this->model->getRecordsCount($blogID), $blogsPerPage);

        $pagination->setRedirectURL("/view/" . $args[0]. "/" . $args[1]);
        $pagination->setPageNumber($pageNumber);
        $pagination->renderPagination();

    }

    // /add/{blogName}
    public function add_Action($args) {

        if(empty($_POST)) {
            View::redirect('/');
        }

        if(!isset($_SESSION['userID'])) {
            View::sendMessage("Error", "You must be authorize to do that", 3);
        }

        if(count($args) == 0) {
            View::sendMessage("Error", ["Arguments not found", "Please contact administrator"], 3);
        }

        $blogID = $this->model->getBlogIDByName($_SESSION['userID'], str_replace("-", " ", $args[0]));

        if($blogID === -1) {
            View::sendMessage("Error", ["Blog with that name not found", "If it system error please contact administrator"], 3, -1, '/');
        }

        if(!empty($_POST)) {

            $errors = [];

            if(!isset($_POST['title']) || strlen(str_replace(' ', '', $_POST['title'])) < 5) {
                array_push($errors, "Too short title. Required at least 5 chars");
            }
            else if(strlen($_POST['title']) > 180) {
                array_push($errors, "Too big title. Max 180 symbols");
            }

            //If count of chars (without space) less than 5 -> show error
            if(!isset($_POST['text']) || strlen(str_replace(' ', '', strip_tags($_POST['text']))) < 5) {
                array_push($errors, "Too short record. Required at least 5 chars");
            } else if(strlen($_POST['text'] > 5000)) {
                array_push($errors, "Too big record");
            }

            if(count($errors) > 0) {
                View::sendMessage("Error", $errors, 3);
            }

            $this->model->database->query("INSERT INTO `BlogRecords` (`blogid`, `title`, `text`) values ($blogID, :title, :text)", ["title" => $_POST['title'], "text" => $_POST['text']]);

            $blogConfig = require 'application/config/blog.php';
            $pagination = new Pagination($this->model->getRecordsCount($blogID), $blogConfig['blog-view']);
            View::sendMessage("Success", "Record to blog added", 1, 1000, ('/view/'.$_SESSION['userName'].'/'. $args[0] . '/' . $pagination->getPageCount()));
        }
    }


    public function create_Action($args) {

        if(!empty($_POST)) {

            //If its click on button "CREATE BLOG"
            //Redirect to login form if user not authorized
            //Else redirect to create blog form
            if(isset($_POST['buttonHandle'])) {

                if(!isset($_SESSION['userID'])) {
                    View::sendMessage("Error", "You must be authorize to create blog", 2, 3000, '/login');
                } else View::location('/blog/create');

                return;
            }


            if(!isset($_SESSION['userID'])) {
                View::sendMessage("Error", "You must authorize to do that", 3, -1, '/login');
            }

            if (!preg_match("/[A-Za-zА-Яа-я0-9 ]/", $_POST['title'])) {
                View::sendMessage("Error", "Form contains incorrect symbols", 3);
            }

            if(strlen($_POST['title']) < 5) {
                View::sendMessage("Error", "Too short title. At least 5 symbols required");
            }

            if(strlen($_POST['description']) > 180) {
                View::sendMessage("Error", "Too big description. Max length -> 180 chars");
            }

            //If blog with that name already exists... send Error message
            if($this->model->getBlogIDByName($_SESSION['userID'], str_replace("-", " ", $_POST['title'])) !== -1) {
                View::sendMessage("Error", "Blog with that name already exists", 3);
            }

            if($_FILES['file-input']['size'] != 0) { //If file exists

                //If size of file large than 2MB
                if ($_FILES['file-input']['size'] > 2097152) {
                    View::sendMessage("Warning", "Image size cant be bigger than 2mb", 3);
                }

                $extension = pathinfo($_FILES['file-input']['name'], PATHINFO_EXTENSION);

                if ($extension != "png" && $extension !== "jpg" && $extension !== "jpeg") {
                    View::sendMessage("Warning", "Allowed formats only png and jpg", 3);
                }
            }

            $this->model->database->query("INSERT INTO `BlogList` (`userid`, `title`, `description`, `region`) values (:user, :title, :description, :region)", ["user" => $_SESSION['userID'], "title" => $_POST['title'], "description" => $_POST['description'], "region" => $_POST['region']]);

            if($_FILES['file-input']['size'] != 0) {
                $blogID = $this->model->database->lastInsertId();
                imagepng(imagecreatefromstring(file_get_contents($_FILES['file-input']['tmp_name'])), "public/images/userdata/blogs/" . $blogID . ".png");
            }

            View::sendMessage("Success", "Blog created", 1, 1000, ('/view/' . $_SESSION['userName'] .'/'. str_replace(" ", "-", $_POST['title'])));
        }

        if(!isset($_SESSION['userID'])) {
            View::error(403);
        }

        $this->view->render("Create blog", [],
            ['/public/js/formHandler.js', '/public/js/patternHandler.js'],
            ["/public/styles/Blog/create.css", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]);

    }

    // edit/{recordID}
    public function edit_Action($args) {

        if(empty($_POST)) {
            View::redirect("/");
        }

        $argsLength = count($args);

        if($argsLength == 0) {
            View::sendMessage("Error", ["Not enough arguments", "Please contact site administrator"], 3);
        }

        if(!isset($_SESSION['userID'])) {
            View::sendMessage("Error", "You not authorized to do that", 3);
        }

        if(!is_numeric($args[0]) || $args[0] < 0) {
            View::sendMessage("Error", "Value must be numeric and bigger than 0", 3);
        }

        $blogID = $this->model->getBlogIDByRecord($args[0]);

        if($blogID === -1) {
            View::sendMessage("Error", "Incorrect record id", 3);
        }


        if(!$this->model->hasAccessToBlog($_SESSION['userID'], $blogID)) {
           View::sendMessage("Error", "You haven't enough permissions to edit this blog", 3);
        }

        $errors = [];

        if(!isset($_POST['title']) || strlen(str_replace(' ', '', $_POST['title'])) < 5) {
            array_push($errors, "Too short title. Required at least 5 chars");
        }
        else if(strlen($_POST['title']) > 180) {
            array_push($errors, "Too big title. Max 180 symbols");
        }

        //If count of chars (without space) less than 5 -> show error
        if(!isset($_POST['text']) || strlen(str_replace(' ', '', strip_tags($_POST['text']))) < 5) {
            array_push($errors, "Too short record. Required at least 5 chars");
        } else if(strlen($_POST['text'] > 5000)) {
            array_push($errors, "Too big record");
        }

        if(count($errors) > 0) {
            View::sendMessage("Error", $errors, 3);
        }

        $this->model->database->query("UPDATE BlogRecords SET title = :title, text = :text WHERE blogid = :blogid AND recordid = :recordid", ["title" => $_POST['title'], "text" => $_POST['text'], "blogid" => $blogID, "recordid" => $args[0]]);

        View::sendJson(["status" => "OK"]);
    }

    // /settings/{blogid}
    public function settings_Action($args) {
        $argsLength = count($args);


        $this->view->render('Settings blog',
            ["blogName" => "test", "blogRegion" => "kiev", "blogDescription" => "test description"],
            ["/public/js/formHandler.js"]);

    }


}