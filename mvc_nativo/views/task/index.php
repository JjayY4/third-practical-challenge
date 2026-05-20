<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Tareas</title>
</head>
<body>
    <h2>Bienvenido, <?= htmlspecialchars($userName) ?></h2>
    <p>Tareas</p>
    <a href="/taskorganizer/mvc_nativo/index.php?controller=auth&action=logout">Cerrar sesión</a>
</body>
</html>