<?php

class Usersview{
    private $requestObject;
    private $dataObject;
    private $path = __DIR__ . DIRECTORY_SEPARATOR;
    
    public function __construct($requestObject, $dataObject) {
        $this->requestObject = $requestObject;
        $this->dataObject = $dataObject;
    }
    
    public function render() {
        $this->{$this->requestObject->command}();
    }
    
    private function read() {
        include $this->path . '../header.php';
        include $this->path . 'userlist.php';
        include $this->path . '../pagination.php';
        include $this->path . '../footer.php';
    }
    
    private function create() {
        if ($this->requestObject->isPOST && !$this->dataObject->error) {
            $this->redirect(1);
        } else {
            $url = $_SERVER['SCRIPT_NAME'] . '?model=users&command=create&page=' . $this->requestObject->page;
            $caption = 'Добавить пользователя';
            $this->form($url, $caption);
        }
    }

    private function update() {
        if ($this->requestObject->isPOST && !$this->dataObject->error) {
            $this->redirect($this->requestObject->page);
        } else {
            $url = $_SERVER['SCRIPT_NAME'] . '?model=users&command=update&page=' . $this->requestObject->page . '&id=' . $this->requestObject->id;
            $caption = 'Редактировать данные пользователя';
            $this->form($url, $caption);
        }        
    }

    private function delete() {
        $this->redirect($this->requestObject->page);
    }
    
    private function form($url, $caption) {
        include $this->path . '../header.php';
        include $this->path . 'form.php';
        include $this->path . '../footer.php';
    }
    
    private function redirect($page) {
        header("Location: http://{$_SERVER['SERVER_NAME']}{$_SERVER['SCRIPT_NAME']}?model=users&page=$page");
        exit();
    }
}

