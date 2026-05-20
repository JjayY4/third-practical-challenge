<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - TaskOrganizer</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=auth&action=login" novalidate>
        <label>Correo:<br>
            <input type="email" name="email" required
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </label><br><br>

        <label>Contraseña:<br>
            <input type="password" name="password" required minlength="6">
        </label><br><br>

        <button type="submit">Entrar</button>
    </form>

    <p>¿No tienes cuenta? <a href="index.php?controller=auth&action=register">Regístrate</a></p>
</body>
</html>