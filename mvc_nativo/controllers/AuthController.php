<?php
require_once __DIR__ . '/../libs/Session.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        Session::start();
        $this->userModel = new UserModel();
    }

    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email']    ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!$email || !$password) {
                $error = 'Todos los campos son obligatorios.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Correo inválido.';
            } else {
                $user = $this->userModel->findByEmail($email);
                if ($user && password_verify($password, $user['password'])) {
                    Session::set('user_id',   $user['id']);
                    Session::set('user_name', $user['name']);
                    header('Location: index.php?controller=task&action=index');
                    exit;
                } else {
                    $error = 'Credenciales incorrectas.';
                }
            }
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function register() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = trim($_POST['name']     ?? '');
            $email    = trim($_POST['email']    ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirm  = trim($_POST['confirm']  ?? '');

            if (!$name || !$email || !$password || !$confirm) {
                $error = 'Todos los campos son obligatorios.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Correo inválido.';
            } elseif (strlen($password) < 6) {
                $error = 'La contraseña debe tener al menos 6 caracteres.';
            } elseif ($password !== $confirm) {
                $error = 'Las contraseñas no coinciden.';
            } elseif ($this->userModel->findByEmail($email)) {
                $error = 'El correo ya está registrado.';
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $this->userModel->create($name, $email, $hashed);
                header('Location: /taskorganizer/mvc_nativo/index.php?controller=task&action=index');
                exit;
            }
        }
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function logout() {
        Session::destroy();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}