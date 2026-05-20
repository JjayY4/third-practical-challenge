<?php
require_once __DIR__ . '/../libs/Session.php';
require_once __DIR__ . '/../models/TaskModel.php';

class TaskController {
    private $taskModel;

    public function __construct() {
        Session::requireLogin();
        $this->taskModel = new TaskModel();
    }

    public function index() {
        $user_id  = Session::get('user_id');
        $userName = Session::get('user_name');
        $tasks    = $this->taskModel->getAllByUser($user_id);
        require_once __DIR__ . '/../views/task/index.php';
    }

    public function create() {
        $error = '';
        require_once __DIR__ . '/../views/task/create.php';
    }

    public function store() {
        $user_id     = Session::get('user_id');
        $title       = trim($_POST['title']       ?? '');
        $description = trim($_POST['description'] ?? '');
        $status      = $_POST['status']           ?? 'pending';
        $error       = '';

        if (!$title) {
            $error = 'El título es obligatorio.';
            require_once __DIR__ . '/../views/task/create.php';
            return;
        }

        if (!in_array($status, ['pending', 'completed'])) {
            $status = 'pending';
        }

        $this->taskModel->create($user_id, $title, $description, $status);
        header('Location: index.php?controller=task&action=index');
        exit;
    }

    public function edit() {
        $user_id = Session::get('user_id');
        $id      = (int)($_GET['id'] ?? 0);
        $task    = $this->taskModel->getById($id, $user_id);
        $error   = '';

        if (!$task) {
            die('Tarea no encontrada.');
        }

        require_once __DIR__ . '/../views/task/edit.php';
    }

    public function update() {
        $user_id     = Session::get('user_id');
        $id          = (int)($_POST['id']          ?? 0);
        $title       = trim($_POST['title']        ?? '');
        $description = trim($_POST['description']  ?? '');
        $status      = $_POST['status']            ?? 'pending';
        $error       = '';

        if (!$title) {
            $task  = $this->taskModel->getById($id, $user_id);
            $error = 'El título es obligatorio.';
            require_once __DIR__ . '/../views/task/edit.php';
            return;
        }

        if (!in_array($status, ['pending', 'completed'])) {
            $status = 'pending';
        }

        $this->taskModel->update($id, $user_id, $title, $description, $status);
        header('Location: index.php?controller=task&action=index');
        exit;
    }

    public function delete() {
        $user_id = Session::get('user_id');
        $id      = (int)($_POST['id'] ?? 0);
        $this->taskModel->delete($id, $user_id);
        header('Location: index.php?controller=task&action=index');
        exit;
    }
}