<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Tarea</title>
</head>
<body>
    <h2>Crear Tarea</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=task&action=store">
        <label>Título:<br>
            <input type="text" name="title" required
                   value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
        </label><br><br>

        <label>Descripción:<br>
            <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </label><br><br>

        <label>Estado:<br>
            <select name="status">
                <option value="pending">Pendiente</option>
                <option value="completed">Completada</option>
            </select>
        </label><br><br>

        <button type="submit">Guardar</button>
        <a href="index.php?controller=task&action=index">Cancelar</a>
    </form>
</body>
</html>