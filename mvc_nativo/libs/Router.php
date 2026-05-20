<?php
class Router {
    public static function route() {
        $controller = $_GET['controller'] ?? 'auth';
        $action     = $_GET['action']     ?? 'login';

        $controller = preg_replace('/[^a-zA-Z]/', '', $controller);
        $action     = preg_replace('/[^a-zA-Z]/', '', $action);

        $file = __DIR__ . '/../controllers/' . ucfirst($controller) . 'Controller.php';

        if (file_exists($file)) {
            require_once $file;
            $class = ucfirst($controller) . 'Controller';
            $obj   = new $class();
            if (method_exists($obj, $action)) {
                $obj->$action();
            } else {
                die("Acción '$action' no encontrada.");
            }
        } else {
            die("Controlador '$controller' no encontrado.");
        }
    }
}