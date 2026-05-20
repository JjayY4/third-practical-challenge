<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarea</title>
</head>
<body>
    <h2>Editar Tarea</h2>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')

        <label>Título:<br>
            <input type="text" name="title" value="{{ old('title', $task->title) }}" required>
        </label><br><br>

        <label>Descripción:<br>
            <textarea name="description">{{ old('description', $task->description) }}</textarea>
        </label><br><br>

        <label>Estado:<br>
            <select name="status">
                <option value="pending"   {{ $task->status == 'pending'   ? 'selected' : '' }}>Pendiente</option>
                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completada</option>
            </select>
        </label><br><br>

        <button type="submit">Actualizar</button>
        <a href="{{ route('tasks.index') }}">Cancelar</a>
    </form>
</body>
</html>