<?php

abstract class Model {
    protected $requestObject;
    protected $dataObject;
    protected $selectSQL;
    protected $countSQL;
    protected $insertSQL;
    protected $updateformSQL;
    protected $updateSQL;
    protected $deleteSQL;
    protected $parameters;
    protected $aboutSQL;
    protected $commands = ['read', 'create', 'update', 'delete', 'about'];
    
    public function __construct($dsn, $user, $password) {
        Database::init($dsn, $user, $password);
        $this->dataObject = new Data();
    }
    
    public function execute($requestObject, $itemsPerPage = 1) {
        $this->requestObject = $requestObject;
        $this->dataObject->itemsPerPage = $itemsPerPage;
        $this->dataObject->currentPage = $this->requestObject->page;
        $this->checkCommand();
        $this->{$this->requestObject->command}();
    }
    
    protected function countItems() {
        $this->dataObject->itemsCount = Database::count($this->countSQL, $this->parameters);
    }
    
    protected function countPages() {
        $this->countItems();
        $this->dataObject->pagesCount = ceil($this->dataObject->itemsCount / $this->dataObject->itemsPerPage);
        if ($this->dataObject->pagesCount < 1) {
            $this->dataObject->pagesCount = 1;
        }
    }
    
    protected function read() {
        $this->setParameters();
        $this->countPages();
        $firstItem = ($this->dataObject->currentPage - 1) * $this->dataObject->itemsPerPage;
        $sql = $this->selectSQL . ' limit ' . $firstItem . ',' . $this->dataObject->itemsPerPage;
        $this->dataObject->dataArray = Database::select($sql, $this->parameters);
    }
    protected function about() {
       $this->setParameters();
        $result = Database::select($this->aboutSQL, $this->parameters);
		if (!$result) {
                throw new Exception('Не найдены данные для редактирования');
            }
		$this->dataObject->dataArray = $result[0];
    }
    protected abstract function checkData();
    
    protected function create() {
        if ($this->requestObject->isPOST) {
            if (!$this->checkData()) return;
            //Добавление данных
            $this->setParameters();
            Database::exec($this->insertSQL, $this->parameters);
        } else {
            $this->setParameters();
        }
    }

    protected function update() {
        if ($this->requestObject->isPOST) {
            if (!$this->checkData()) return;
            //Изменение данных
            $this->setParameters();
            Database::exec($this->updateSQL, $this->parameters);
        } else {
            $this->setParameters();
            $result = Database::select($this->updateformSQL, $this->parameters);
            if (!$result) {
                throw new Exception('Не найдены данные для редактирования');
            }
            $this->dataObject->dataArray = $result[0];
        }
    }

    protected function delete() {
        $this->setParameters();
        Database::exec($this->deleteSQL, $this->parameters);
    }
    
    protected function checkCommand() {
        if (!in_array($this->requestObject->command, $this->commands)) {
            throw new Exception("Недопустимая команда");
        }
    }
    
    public function getDataObject() {
        return $this->dataObject;
    }
    
    protected abstract function setParameters();
}
