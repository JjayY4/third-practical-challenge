<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Tareas</title>
</head>
<body>
    <h2>Bienvenido, <?= htmlspecialchars($userName) ?></h2>
    <a href="index.php?controller=task&action=create">Nueva Tarea</a> |
    <a href="index.php?controller=auth&action=logout">Cerrar sesión</a>

    <h3>Mis Tareas</h3>

    <?php if (empty($tasks)): ?>
        <p>No tienes tareas aún.</p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task['title']) ?></td>
                <td><?= htmlspecialchars($task['description']) ?></td>
                <td><?= $task['status'] ?></td>
                <td>
                    <a href="index.php?controller=task&action=edit&id=<?= $task['id'] ?>">Editar</a>
                    <form method="POST" action="index.php?controller=task&action=delete" style="display:inline">
                        <input type="hidden" name="id" value="<?= $task['id'] ?>">
                        <button onclick="return confirm('¿Eliminar tarea?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>