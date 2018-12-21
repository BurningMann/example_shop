<?php

class Users extends Model {
    
    protected $sessionUser;
    
    public function __construct($dsn, $user, $password) {
        parent::__construct($dsn, $user, $password);
        $this->selectSQL = 'select id, login, password, status from users order by login';
        $this->countSQL = 'select count(*) from users';
        $this->insertSQL = 'insert into users (login, password, status) values (?, ?, ?)';
        $this->updateformSQL = 'select login, status from users where id=?';
        $this->updateSQL = 'update users set login=?, password=if(""=?,password,?), status=? where id=?';
        $this->deleteSQL = 'delete from users where id=?';
        $this->sessionUser = new User($dsn, $user, $password);
    }
    
    protected function checkData() {
        //Проверка полученных данных с установкой сообщения об ошибках
        if (!isset($_POST['login']) || !isset($_POST['password']) 
                || !isset($_POST['password1']) || !isset($_POST['status'])) {
            $this->dataObject->error = 'Данные не получены<br>';
            return false;
        }
        $this->dataObject->dataArray['login'] = $_POST['login'];
        $this->dataObject->dataArray['password'] = $_POST['password'];
        $this->dataObject->dataArray['status'] = $_POST['status'];
        if (preg_match('/[^A-Za-z0-9_]/', $this->dataObject->dataArray['login'])) 
                $this->dataObject->error .= 'Логин должен должен содержать только латинские буквы, цифры и знак подчеркивания<br>';
        if ($this->dataObject->dataArray['password']) {
            if ($this->dataObject->dataArray['password'] != $_POST['password1']) 
                $this->dataObject->error .= 'Введенные пароли не совпадают<br>';
            if (mb_strlen($this->dataObject->dataArray['password']) < 3) 
                $this->dataObject->error .= 'Длина пароля должна быть не менее 3 символов<br>';
            $this->dataObject->dataArray['password'] = password_hash($this->dataObject->dataArray['password'], PASSWORD_BCRYPT);
        } else {
            if ($this->requestObject->command == 'create') $this->dataObject->error .= 'Пароль не может быть пустым<br>';
        }
        if (!in_array($this->dataObject->dataArray['status'], ['user', 'admin'])) $this->dataObject->error .= 'Неверный статус<br>';
        if ($this->dataObject->error) {
            return false;
        } else {
            return true;
        }
    }
    
    protected function setParameters() {
        switch ($this->requestObject->command) {
            case 'create': 
                if ($this->requestObject->isPOST) {
                    $this->parameters = [$this->dataObject->dataArray['login'], 
                        $this->dataObject->dataArray['password'], $this->dataObject->dataArray['status']];
                } else {
                    $this->dataObject->dataArray['login'] = '';
                    $this->dataObject->dataArray['password'] = '';
                    $this->dataObject->dataArray['status'] = '';
                    $this->parameters = null;
                }
                break;
            case 'update':
                if ($this->requestObject->isPOST) {
                    $this->parameters = [$this->dataObject->dataArray['login'], $this->dataObject->dataArray['password'], 
                        $this->dataObject->dataArray['password'], $this->dataObject->dataArray['status'], $this->requestObject->id];
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
    
    protected function checkCommand() {
        parent::checkCommand();
        $this->sessionUser->checkUser();
        if ($this->dataObject->session->getUser()['status'] != 'admin') {
            throw new Exception("Нет прав для выполнения команды");
        }
    }
}
