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
        <table border="1" cellpadding="8" id="tabla-tareas">
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Cambiar Estado</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($tasks as $task): ?>
            <tr id="fila-<?= $task['id'] ?>">
                <td><?= htmlspecialchars($task['title']) ?></td>
                <td><?= htmlspecialchars($task['description']) ?></td>
                <td id="estado-<?= $task['id'] ?>">
                    <?= $task['status'] == 'completed' ? 'Completada' : 'Pendiente' ?>
                </td>
                <td>
                    <button onclick="cambiarEstado(<?= $task['id'] ?>, '<?= $task['status'] ?>')">
                        <?= $task['status'] == 'completed' ? 'Marcar Pendiente' : 'Marcar Completada' ?>
                    </button>
                </td>
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

    <script>
    function cambiarEstado(id, estadoActual) {
        const nuevoEstado = estadoActual === 'pending' ? 'completed' : 'pending';

        fetch('index.php?controller=ajax&action=updateStatus', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + id + '&status=' + nuevoEstado
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('estado-' + id).textContent =
                    nuevoEstado === 'completed' ? 'Completada' : 'Pendiente';

                const btn = document.querySelector('#fila-' + id + ' button');
                btn.textContent = nuevoEstado === 'completed' ? 'Marcar Pendiente' : 'Marcar Completada';
                btn.setAttribute('onclick', `cambiarEstado(${id}, '${nuevoEstado}')`);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(err => {
            alert('Error de conexión');
            console.error(err);
        });
    }
    </script>
</body>
</html>