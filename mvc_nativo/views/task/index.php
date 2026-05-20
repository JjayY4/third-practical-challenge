<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand">TaskOrganizer</span>
        <div>
            <span class="text-white me-3"><?= htmlspecialchars($userName) ?></span>
            <a href="index.php?controller=auth&action=logout" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Mis Tareas</h2>
        <a href="index.php?controller=task&action=create" class="btn btn-primary">+ Nueva Tarea</a>
    </div>

    <?php if (empty($tasks)): ?>
        <div class="alert alert-info">No tienes tareas aún.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Cambiar Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                <tr id="fila-<?= $task['id'] ?>">
                    <td><?= htmlspecialchars($task['title']) ?></td>
                    <td><?= htmlspecialchars($task['description']) ?></td>
                    <td id="estado-<?= $task['id'] ?>">
                        <?php if ($task['status'] == 'completed'): ?>
                            <span class="badge bg-success">Completada</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary"
                                onclick="cambiarEstado(<?= $task['id'] ?>, '<?= $task['status'] ?>')">
                            <?= $task['status'] == 'completed' ? 'Marcar Pendiente' : 'Marcar Completada' ?>
                        </button>
                    </td>
                    <td>
                        <a href="index.php?controller=task&action=edit&id=<?= $task['id'] ?>"
                           class="btn btn-sm btn-warning">Editar</a>
                        <form method="POST" action="index.php?controller=task&action=delete" style="display:inline">
                            <input type="hidden" name="id" value="<?= $task['id'] ?>">
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar tarea?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

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
            const badge = document.getElementById('estado-' + id);
            badge.innerHTML = nuevoEstado === 'completed'
                ? '<span class="badge bg-success">Completada</span>'
                : '<span class="badge bg-warning text-dark">Pendiente</span>';

            const btn = document.querySelector('#fila-' + id + ' .btn-outline-primary');
            btn.textContent = nuevoEstado === 'completed' ? 'Marcar Pendiente' : 'Marcar Completada';
            btn.setAttribute('onclick', `cambiarEstado(${id}, '${nuevoEstado}')`);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(() => alert('Error de conexión'));
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>