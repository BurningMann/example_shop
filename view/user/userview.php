<?php


class Userview {
    private $requestObject;
    private $dataObject;
    
    public function __construct($requestObject, $dataObject) {
        $this->requestObject = $requestObject;
        $this->dataObject = $dataObject;
    }
    
    public function render() {
        $this->{$this->requestObject->command}();
    }
    
    private function login() {
        header("Content-type: application/json");
        $answer['error'] = $this->dataObject->error;
        echo (json_encode($answer));
    }
    
    private function logout() {
        header("Location: http://{$_SERVER['SERVER_NAME']}{$_SERVER['SCRIPT_NAME']}");
        exit();
    }
}
