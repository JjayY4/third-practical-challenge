<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Task — TaskOrganizer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f0f0f; min-height: 100vh; display: flex; align-items: center; }
        .card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 12px; }
        .form-control, .form-select {
            background: #0f0f0f; border: 1px solid #2a2a2a; color: #f1f1f1; border-radius: 8px;
        }
        .form-control:focus, .form-select:focus {
            background: #0f0f0f; color: #f1f1f1;
            border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }
        .form-select option { background: #1a1a1a; }
        .form-label { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: #888; }
        .btn-indigo { background: #6366f1; color: #fff; border: none; border-radius: 8px; font-weight: 600; }
        .btn-indigo:hover { background: #4f46e5; color: #fff; }
        .brand { color: #6366f1; font-weight: 700; font-size: 1.1rem; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <div class="mb-4">
                    <div class="brand mb-1">TaskOrganizer</div>
                    <h5 class="fw-semibold mb-0">Edit Task</h5>
                    <p class="text-secondary small mt-1">Update the details below</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2 small"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?controller=task&action=update">
                    <input type="hidden" name="id" value="<?= $task['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required
                               value="<?= htmlspecialchars($_POST['title'] ?? $task['title']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($_POST['description'] ?? $task['description']) ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending"   <?= $task['status'] == 'pending'   ? 'selected' : '' ?>>Pending</option>
                            <option value="completed" <?= $task['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-indigo flex-fill">Update Task</button>
                        <a href="index.php?controller=task&action=index" class="btn btn-outline-secondary flex-fill">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>