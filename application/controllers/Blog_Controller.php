<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;

class Blog_Controller extends Controller
{

    /* All pages
     * cov-blog.in.ua/blogs/{userName}
     * cov-blog.in.ua/blogs/{userName}/{blogName/blogid}/{page}
     * cov-blog.in.ua/blogs/{regionName}
     * cov-blog.in.ua/blogs/{regionName}/{page}
     *
     * cov-blog.in.ua/view/{userName}/{blogName/blogid}
     *
     * cov-blog.in.ua/edit/{blogid}
     * cov-blog.in.ua/add
    */

    public function onInitialize() {}

    public function index_Action($args) {
        View::redirect('/blogs');
    }

    public function blogs_Action($args) {

    }

    public function view_Action($args) {

    }

    public function edit_Action($args) {

    }

    public function add_Action($args) {

    }


}