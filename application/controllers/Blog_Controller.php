<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;

class Blog_Controller extends Controller
{

    /*
     * cov-blog.in.ua/blogs/{userName}
     * cov-blog.in.ua/blogs/{userName}/{blogName/blogid}/{page}
     *
     * cov-blog.in.ua/blogs/{regionName}
     * cov-blog.in.ua/blogs/{regionName}/{page}
     *
     * cov-blog.in.ua/view/{userName}/{blogName/blogid}/{page}
     *
     * cov-blog.in.ua/edit/{blogid}
     * cov-blog.in.ua/add
    */

    public function onInitialize() {}

    public function index_Action($args) {
        View::redirect('/');
    }

    public function blogs_Action($args) {

        $argsLength = count($args);

        if($argsLength == 0) {
            View::redirect('/');
        } else {

            $blogConfig = require 'application/config/blog.php';
            $blogsPerPage = $blogConfig['blog-list']['blogs-rows'] * $blogConfig['blog-list']['blogs-columns'];
            $pageNumber = 1;

            if($argsLength > 1 && is_numeric($args[1]) && $args[1] >= 1) {
                $pageNumber = $args[1];
            }


            if($this->model->hasRegion($args[0])) {

                $result = $this->model->getBlogsByRegion($args[0], $pageNumber, $blogsPerPage);
                echo "Блоги пользователей по области: $args[0] | Страница: $pageNumber <hr>";

                foreach ($result as $value) {
                    echo 'Author: ' . $value['username'] . ' | ' .$value['title'] . ' | ' . $value['description'] . ' | Created: ' . $value['createDate'] . '<br>';
                    echo "<span>To read blog <a href='/view/" . $value['username'] . '/' . str_replace(' ', '-', $value['title']) . "'>click here</a></span><br><hr>";
                }


            } else {

                $result = $this->model->getBlogsByUser($args[0], $pageNumber, $blogsPerPage);
                if(isset($result)) {

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
        //cov-blog.in.ua/view/demirug/blogName
        $argsLength = count($args);

        if($argsLength == 0) {
            View::redirect('/');
        }

        if($argsLength == 1) {
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

        foreach ($result as $value) {

            echo "<hr><h3>".$value['title']. "</h3>" . "<span>" . $value['text'] . "</span><br>" . $value['createDate'] . "<hr>";

        }
    }

    public function edit_Action($args) {

    }

    public function add_Action($args) {

    }


}