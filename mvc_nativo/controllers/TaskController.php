<?php
require_once __DIR__ . '/../libs/Session.php';

class TaskController {
    public function __construct() {
        Session::requireLogin();
    }

    public function index() {
        $userName = Session::get('user_name');
        require_once __DIR__ . '/../views/task/index.php';
    }
}