<?php

class User extends Model {
    protected $loginSQL = 'select id, login, status from users where login=? limit 1';
    protected $passwordSQL = 'select password from users where id=? limit 1';
    protected $checkUserSQL = 'select id, login, status from users where id=? limit 1';
    
    public function __construct($dsn, $user, $password) {
        parent::__construct($dsn, $user, $password);
        $this->commands = ['login', 'logout'];
    }
    
    protected function login() {
        try {
            if ($this->requestObject->isPOST) {
                $this->checkData();
            }
        } catch(Throwable $e) {
            $this->dataObject->error = $e->getMessage();
        }
    }
    
    public function checkUser() {
        if (!$this->dataObject->session->getUser()['id']) {
            return;
        }
        $this->setParameters();
        $userData = Database::select($this->checkUserSQL, $this->parameters);
        if ($userData) {
            $this->dataObject->session->setUser($userData[0]);
        } else {
            $this->dataObject->session->setDefaultUser();
        }
    }
    
    protected function logout() {
        $this->dataObject->session->destroy();
    }
    
    protected function checkData() {
        $user = json_decode(file_get_contents('php://input'));
        $userData = Database::select($this->loginSQL, [$user->login]);
        if ($userData) {
            $password = Database::select($this->passwordSQL, [$userData[0]['id']]);
            if (password_verify($user->password, $password[0]['password'])) {
                $this->dataObject->session->setUser($userData[0]);
                return;
            }
        }
        throw new Exception('Неверный логин или пароль');
    }
    
    protected function setParameters() {
        $this->parameters = [$this->dataObject->session->getUser()['id']];
    }
}
