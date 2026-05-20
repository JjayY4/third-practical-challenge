<?php
require_once __DIR__ . '/../libs/Session.php';
require_once __DIR__ . '/../models/TaskModel.php';

class AjaxController {
    private $taskModel;

    public function __construct() {
        Session::start();
        header('Content-Type: application/json');
    }

    public function updateStatus() {
        if (!Session::get('user_id')) {
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            exit;
        }

        $user_id  = Session::get('user_id');
        $id       = (int)($_POST['id']     ?? 0);
        $status   = $_POST['status']       ?? '';

        if (!$id || !in_array($status, ['pending', 'completed'])) {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            exit;
        }

        $this->taskModel = new TaskModel();
        $task = $this->taskModel->getById($id, $user_id);

        if (!$task) {
            echo json_encode(['success' => false, 'message' => 'Tarea no encontrada']);
            exit;
        }

        $this->taskModel->update($id, $user_id, $task['title'], $task['description'], $status);
        echo json_encode(['success' => true, 'new_status' => $status]);
        exit;
    }
}