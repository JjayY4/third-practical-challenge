<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Editar Tarea</h4></div>
                <div class="card-body">

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?controller=task&action=update">
                        <input type="hidden" name="id" value="<?= $task['id'] ?>">

                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input type="text" name="title" class="form-control" required
                                   value="<?= htmlspecialchars($_POST['title'] ?? $task['title']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($_POST['description'] ?? $task['description']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select name="status" class="form-select">
                                <option value="pending"   <?= ($task['status'] == 'pending'   ? 'selected' : '') ?>>Pendiente</option>
                                <option value="completed" <?= ($task['status'] == 'completed' ? 'selected' : '') ?>>Completada</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning">Actualizar</button>
                        <a href="index.php?controller=task&action=index" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>