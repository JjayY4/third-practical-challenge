<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:150',
            'description' => 'nullable|string',
            'status'      => 'in:pending,completed',
        ]);

        Task::create([
            'user_id'     => 1,
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status ?? 'pending',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarea creada.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return redirect()->route('tasks.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'       => 'required|max:150',
            'description' => 'nullable|string',
            'status'      => 'in:pending,completed',
        ]);

        $task->update($request->only('title', 'description', 'status'));
        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada.');
    }

}
