<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Tarea</title>
</head>
<body>
    <h2>Crear Tarea</h2>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <label>Título:<br>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </label><br><br>

        <label>Descripción:<br>
            <textarea name="description">{{ old('description') }}</textarea>
        </label><br><br>

        <label>Estado:<br>
            <select name="status">
                <option value="pending">Pendiente</option>
                <option value="completed">Completada</option>
            </select>
        </label><br><br>

        <button type="submit">Guardar</button>
        <a href="{{ route('tasks.index') }}">Cancelar</a>
    </form>
</body>
</html>