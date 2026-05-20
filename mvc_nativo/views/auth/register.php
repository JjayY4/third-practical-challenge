<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register — TaskOrganizer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f0f0f; min-height: 100vh; display: flex; align-items: center; }
        .card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 12px; }
        .brand { color: #6366f1; font-weight: 700; font-size: 1.5rem; }
        .form-control {
            background: #0f0f0f; border: 1px solid #2a2a2a; color: #f1f1f1; border-radius: 8px;
        }
        .form-control:focus {
            background: #0f0f0f; color: #f1f1f1;
            border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }
        .btn-primary { background: #6366f1; border: none; border-radius: 8px; font-weight: 600; }
        .btn-primary:hover { background: #4f46e5; }
        .form-label { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: #888; }
        a { color: #6366f1; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card p-4">
                <div class="text-center mb-4">
                    <div class="brand">TaskOrganizer</div>
                    <p class="text-secondary small mt-1">Create your account</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2 small"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?controller=auth&action=register">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required
                               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm" class="form-control" required minlength="6">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Create account</button>
                </form>

                <p class="text-center text-secondary small mt-4 mb-0">
                    Already have an account? <a href="index.php?controller=auth&action=login">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>
</body>
</html>