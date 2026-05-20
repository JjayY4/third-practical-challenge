<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskOrganizer — Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f0f0f; }
        .navbar { background: #1a1a1a !important; border-bottom: 1px solid #2a2a2a; }
        .navbar-brand { color: #6366f1 !important; font-weight: 700; }
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
        .table { --bs-table-bg: transparent; --bs-table-border-color: #2a2a2a; color: #f1f1f1; }
        .table thead th { color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
        .table tbody tr:hover td { background: #1f1f1f; }
        .btn-indigo { background: #6366f1; color: #fff; border: none; border-radius: 8px; font-weight: 600; }
        .btn-indigo:hover { background: #4f46e5; color: #fff; }
        .badge-pending { background: #2a2200; color: #fbbf24; border: 1px solid #3a3200; }
        .badge-completed { background: #0a2a1a; color: #34d399; border: 1px solid #0f3a20; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('tasks.index') }}">TaskOrganizer</a>
            <span class="text-secondary small">Laravel</span>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>