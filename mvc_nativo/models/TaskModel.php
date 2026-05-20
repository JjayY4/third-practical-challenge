<?php
require_once __DIR__ . '/../config/database.php';

class TaskModel {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getAllByUser($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id, $user_id) {
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($user_id, $title, $description, $status) {
        $stmt = $this->db->prepare(
            "INSERT INTO tasks (user_id, title, description, status) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$user_id, $title, $description, $status]);
    }

    public function update($id, $user_id, $title, $description, $status) {
        $stmt = $this->db->prepare(
            "UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ? AND user_id = ?"
        );
        return $stmt->execute([$title, $description, $status, $id, $user_id]);
    }

    public function delete($id, $user_id) {
        $stmt = $this->db->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $user_id]);
    }
}