<?php
class Controller {
    private $requestObject;//объект класса request
    private $model;//объект класса модели
    private $view;
    
    public function __construct($defaultModel, $defaultCommand) {
        $this->requestObject = new Request($defaultModel, $defaultCommand);
        $this->setRequestData();
    }
    
    private function setRequestData() {
        if (isset($_GET['model'])) {
            $this->requestObject->model = ucfirst($_GET['model']);
        }
        if (isset($_GET['command'])) {
            $this->requestObject->command = $_GET['command'];
        }
        if (isset($_GET['page'])) {
            $this->requestObject->page = $_GET['page'];
        }
        if (isset($_GET['id'])) {
            $this->requestObject->id = $_GET['id'];
        }
    }
    
    public function run() {
        try {
            ob_start();
            $this->model = new $this->requestObject->model(DSN, DB_USER, DB_PASSWORD);
            $this->model->execute($this->requestObject, ITEMS_PER_PAGE);
            $viewClass = $this->requestObject->model . 'view';
            include 'view/' . $this->requestObject->model . '/' . $viewClass . '.php';
            $this->view = new $viewClass($this->requestObject, $this->model->getDataObject());
            $this->view->render();
            ob_end_flush();
        } catch (Throwable $e) {
            ob_end_clean();
            require 'view/error.php';
        }
    }
}
