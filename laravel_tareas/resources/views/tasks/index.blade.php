<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tareas - Laravel</title>
</head>
<body>
    <h2>Lista de Tareas</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <a href="{{ route('tasks.create') }}">Nueva Tarea</a>
    <br><br>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        @forelse($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->title }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ $task->status }}</td>
            <td>
                <a href="{{ route('tasks.edit', $task) }}">Editar</a>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('¿Eliminar?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No hay tareas aún.</td>
        </tr>
        @endforelse
    </table>
</body>
</html>