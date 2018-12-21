<?php

class Session { //singleton
    private static $instance;
    
    private function __construct() {
        session_start();
        if (!isset($_SESSION['user'])) {
            $this->setDefaultUser();
        }
    }
    
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getSessionItem($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }
    
    public function getSessionItems() {
        return $_SESSION;
    }
    
    public function setSessionItem($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public function getUser() {
        return $this->getSessionItem('user');
    }
    
    public function setUser($value) {
        $this->setSessionItem('user', $value);
    }
    
    public function setDefaultUser() {
            $_SESSION['user'] = ['id'=>0, 'login'=>'', 'status'=>''];
    }
    
    public function destroy() {
        session_unset();
        session_destroy();
        $this->setDefaultUser();
    }
}
