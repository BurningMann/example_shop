<?php
class Data {
    public $dataArray = array();
    public $session;
    public $itemsCount = 0;
    public $itemsPerPage = 1;
    public $pagesCount = 1;
    public $currentPage = 1;
    public $error = '';
    
    public function __construct() {
        $this->session = Session::getInstance();
    }
}
