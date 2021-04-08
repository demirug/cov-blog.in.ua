<?php

namespace application\libs;

class Pagination
{

    public $view = "default";
    private $url = "#";

    private $currentPage = 1;

    private $notesCount = 0;
    private $pageCount = 0;

    public function __construct($notesCount, $notesPerPage) {
        $this->notesCount = $notesCount;
        $this->pageCount = ceil($this->notesCount / $notesPerPage);
    }

    public function getNotesCount() {
        return $this->notesCount;
    }

    public function getPageCount() {
        return $this->pageCount;
    }

    public function setPageNumber($pageNumber) {
        $this->currentPage = $pageNumber;
    }

    public function setRedirectURL($url) {
        $this->url = $url;
    }

    public function renderPagination() {
        $curPage = $this->currentPage;
        $pageCount = $this->pageCount;
        $url = $this->url;
        require 'application/views/pagination/' . $this->view . '.php';
    }

}