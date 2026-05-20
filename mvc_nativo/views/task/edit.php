<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarea</title>
</head>
<body>
    <h2>Editar Tarea</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=task&action=update">
        <input type="hidden" name="id" value="<?= $task['id'] ?>">

        <label>Título:<br>
            <input type="text" name="title" required
                   value="<?= htmlspecialchars($_POST['title'] ?? $task['title']) ?>">
        </label><br><br>

        <label>Descripción:<br>
            <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? $task['description']) ?></textarea>
        </label><br><br>

        <label>Estado:<br>
            <select name="status">
                <option value="pending"   <?= ($task['status'] == 'pending'   ? 'selected' : '') ?>>Pendiente</option>
                <option value="completed" <?= ($task['status'] == 'completed' ? 'selected' : '') ?>>Completada</option>
            </select>
        </label><br><br>

        <button type="submit">Actualizar</button>
        <a href="index.php?controller=task&action=index">Cancelar</a>
    </form>
</body>
</html>