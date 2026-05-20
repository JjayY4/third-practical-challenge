<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasks — TaskOrganizer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f0f0f; }
        .navbar { background: #1a1a1a !important; border-bottom: 1px solid #2a2a2a; }
        .navbar-brand { color: #6366f1 !important; font-weight: 700; }
        .card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 12px; }
        .table { --bs-table-bg: transparent; --bs-table-border-color: #2a2a2a; color: #f1f1f1; }
        .table thead th { color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #2a2a2a; }
        .table tbody tr:hover td { background: #1f1f1f; }
        .btn-indigo { background: #6366f1; color: #fff; border: none; border-radius: 8px; font-weight: 600; }
        .btn-indigo:hover { background: #4f46e5; color: #fff; }
        .badge-pending { background: #2a2200; color: #fbbf24; border: 1px solid #3a3200; }
        .badge-completed { background: #0a2a1a; color: #34d399; border: 1px solid #0f3a20; }
        .btn-outline-logout { color: #f87171; border: 1px solid #5a2a2a; font-size: 0.8rem; border-radius: 6px; }
        .btn-outline-logout:hover { background: #2a1a1a; color: #f87171; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark mb-4">
    <div class="container">
        <span class="navbar-brand">TaskOrganizer</span>
        <div class="d-flex align-items-center gap-3">
            <span class="text-secondary small"><?= htmlspecialchars($userName) ?></span>
            <a href="index.php?controller=auth&action=logout" class="btn btn-sm btn-outline-logout">Sign out</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold mb-0">My Tasks</h5>
        <a href="index.php?controller=task&action=create" class="btn btn-indigo btn-sm px-3">+ New Task</a>
    </div>

    <div class="card">
        <?php if (empty($tasks)): ?>
            <div class="text-center py-5 text-secondary">
                <p class="mb-1">No tasks yet.</p>
                <p class="small">Create your first task to get started.</p>
            </div>
        <?php else: ?>
            <table class="table table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                    <tr id="fila-<?= $task['id'] ?>">
                        <td class="align-middle fw-medium"><?= htmlspecialchars($task['title']) ?></td>
                        <td class="align-middle text-secondary small"><?= htmlspecialchars($task['description']) ?></td>
                        <td class="align-middle" id="estado-<?= $task['id'] ?>">
                            <?php if ($task['status'] == 'completed'): ?>
                                <span class="badge rounded-pill badge-completed">Completed</span>
                            <?php else: ?>
                                <span class="badge rounded-pill badge-pending">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-secondary"
                                        onclick="cambiarEstado(<?= $task['id'] ?>, '<?= $task['status'] ?>')">
                                    <?= $task['status'] == 'completed' ? '↩ Pending' : '✓ Complete' ?>
                                </button>
                                <a href="index.php?controller=task&action=edit&id=<?= $task['id'] ?>"
                                   class="btn btn-sm btn-outline-warning">Edit</a>
                                <form method="POST" action="index.php?controller=task&action=delete">
                                    <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                    <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Delete this task?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
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
            document.getElementById('estado-' + id).innerHTML = nuevoEstado === 'completed'
                ? '<span class="badge rounded-pill badge-completed">Completed</span>'
                : '<span class="badge rounded-pill badge-pending">Pending</span>';
            const btn = document.querySelector('#fila-' + id + ' .btn-outline-secondary');
            btn.textContent = nuevoEstado === 'completed' ? '↩ Pending' : '✓ Complete';
            btn.setAttribute('onclick', `cambiarEstado(${id}, '${nuevoEstado}')`);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(() => alert('Connection error'));
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>