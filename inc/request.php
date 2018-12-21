<?php
class Request {
    public $model;
    public $command;
    public $page = 1;
    public $id = 0;
    public $isPOST = false;
    
    public function __construct($defaultModel, $defaultCommand) {
        $this->model = $defaultModel;
        $this->command = $defaultCommand;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->isPOST = true;
        }
    }
}