<?php
class Guestbook extends Model {
    
    protected $sessionUser;
    
   public function __construct($dsn, $user, $password) {
        parent::__construct($dsn, $user, $password);
        $this->selectSQL = 'select id, name, title, collor, prise, picture from anorak order by id desc';
        $this->countSQL = 'select count(*) from anorak';
        $this->insertSQL = 'insert into anorak (name, title, collor, prise, picture, description, material) values (?, ?, ?, ?, ?, ?, ?)';
        $this->updateformSQL = 'select name, title, collor, prise, picture, description, material from anorak where id=?';
        $this->updateSQL = 'update anorak set name=?, title=?, collor=?, prise=?, picture=?, description=?, material=? where id=?';
        $this->deleteSQL = 'delete from anorak where id=?';
        $this->aboutSQL = 'select name, title, collor, prise, picture, description, material from anorak where id=?';
        $this->sessionUser = new User($dsn, $user, $password);
    }
    protected function checkData() {
        //Проверка полученных данных с установкой сообщения об ошибках
        if (!isset($_POST['name']) || !isset($_POST['collor']) || !isset($_POST['prise']) || !isset($_POST['picture']) || !isset($_POST['description']) || !isset($_POST['material'])) {
            $this->dataObject->error = 'Данные не получены<br>';
            return false;
        }
        $this->dataObject->dataArray['name'] = trim($_POST['name']);
        $this->dataObject->dataArray['title'] = trim($_POST['title']);
        $this->dataObject->dataArray['collor'] = trim($_POST['collor']);
        $this->dataObject->dataArray['prise'] = trim($_POST['prise']);
        $this->dataObject->dataArray['picture'] = trim($_POST['picture']);
        $this->dataObject->dataArray['description'] = trim($_POST['description']);
        $this->dataObject->dataArray['material'] = trim($_POST['material']);
		if (!$this->dataObject->dataArray['name']) $this->dataObject->error .= 'Имя должно быть заполнено<br>';
        if (mb_strlen($this->dataObject->dataArray['name']) > 40) $this->dataObject->error .= 'Имя должно содержать не более 40 символов<br>';
        if (!$this->dataObject->dataArray['description']) $this->dataObject->error .= 'Сообщение должно быть заполнено<br>';
        if (mb_strlen($this->dataObject->dataArray['description']) > 1000) $this->dataObject->error .= 'Сообщение должно содержать не более 1000 символов<br>';
        if ($this->dataObject->error) {
            return false;
        } else {
            foreach ($this->dataObject->dataArray as &$item) {
                $item = htmlspecialchars($item, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }
            return true;
        }
    } 
    protected function setParameters() {
        switch ($this->requestObject->command) {
            case 'create': 
                if ($this->requestObject->isPOST) {
                    $this->parameters = [$this->dataObject->dataArray['name'], $this->dataObject->dataArray['title'], $this->dataObject->dataArray['collor'], $this->dataObject->dataArray['prise'], $this->dataObject->dataArray['picture'], $this->dataObject->dataArray['description'], $this->dataObject->dataArray['material']];
                } else {
                    $this->dataObject->dataArray['name'] = '';
                    $this->dataObject->dataArray['title'] = '';
                    $this->dataObject->dataArray['collor'] = '';  
                    $this->dataObject->dataArray['prise'] = '';  
                    $this->dataObject->dataArray['picture'] = '';  
                    $this->dataObject->dataArray['description'] = '';  
                    $this->dataObject->dataArray['material'] = '';  
                    $this->parameters = null;
                }
                break;
            case 'update':
                if ($this->requestObject->isPOST) {
                    $this->parameters = [$this->dataObject->dataArray['name'], $this->dataObject->dataArray['title'], $this->dataObject->dataArray['collor'], $this->dataObject->dataArray['prise'], $this->dataObject->dataArray['picture'], $this->dataObject->dataArray['description'], $this->dataObject->dataArray['material'], $this->requestObject->id];
                } else {
                    $this->parameters = [$this->requestObject->id];
                }
                break;
			case 'about':
                if ($this->requestObject->isPOST) {
                    $this->parameters = [$this->dataObject->dataArray['name'], $this->dataObject->dataArray['title'], $this->dataObject->dataArray['collor'], $this->dataObject->dataArray['prise'], $this->dataObject->dataArray['picture'], $this->dataObject->dataArray['description'], $this->dataObject->dataArray['material'], $this->requestObject->id];
                } else {
                    $this->parameters = [$this->requestObject->id];
                }
                break;
            case 'delete':
                $this->parameters = [$this->requestObject->id];
                break;
            default:
                $this->parameters = null;
        }
    }
    
  /*   protected function checkCommand() {
        parent::checkCommand();
        $this->sessionUser->checkUser();
        $status = $this->dataObject->session->getUser()['status'];
        $command = $this->requestObject->command;
        if (!($command == 'read' || ($command == 'create' && $status) || $command != 'about' || $status == 'admin')) {
            throw new Exception("Нет прав для выполнения команды");
        }
    } */
}