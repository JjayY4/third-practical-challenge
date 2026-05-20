<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - TaskOrganizer</title>
</head>
<body>
    <h2>Crear Cuenta</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=auth&action=register" novalidate>
        <label>Nombre:<br>
            <input type="text" name="name" required
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </label><br><br>

        <label>Correo:<br>
            <input type="email" name="email" required
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </label><br><br>

        <label>Contraseña:<br>
            <input type="password" name="password" required minlength="6">
        </label><br><br>

        <label>Confirmar contraseña:<br>
            <input type="password" name="confirm" required minlength="6">
        </label><br><br>

        <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="index.php?controller=auth&action=login">Inicia sesión</a></p>
</body>
</html>