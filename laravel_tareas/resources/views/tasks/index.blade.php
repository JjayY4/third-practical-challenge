@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-semibold mb-0">My Tasks</h5>
    <a href="{{ route('tasks.create') }}" class="btn btn-indigo btn-sm px-3">+ New Task</a>
</div>

@if(session('success'))
    <div class="alert alert-success py-2 small">{{ session('success') }}</div>
@endif

<div class="card">
    @if($tasks->isEmpty())
        <div class="text-center py-5 text-secondary">
            <p class="mb-1">No tasks yet.</p>
            <p class="small">Create your first task to get started.</p>
        </div>
    @else
        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td class="align-middle fw-medium">{{ $task->title }}</td>
                    <td class="align-middle text-secondary small">{{ $task->description }}</td>
                    <td class="align-middle">
                        @if($task->status == 'completed')
                            <span class="badge rounded-pill badge-completed">Completed</span>
                        @else
                            <span class="badge rounded-pill badge-pending">Pending</span>
                        @endif
                    </td>
                    <td class="align-middle">
                        <div class="d-flex gap-2">
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Delete this task?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection