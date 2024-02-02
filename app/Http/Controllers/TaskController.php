<?php

namespace App\Http\Controllers;

use App\Events\TaskCreated;
use App\Events\TaskDeleted;
use App\Events\TaskUpdated;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $tasks = $user->tasks()->latest()->paginate(10);

        return view('dashboard', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = Task::STATUSES;
        return view('tasks.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        // create task
        $task = Task::create([
            'title' => $request->title,
            'desc' => $request->desc,
            'status' => $request->status,
            'user_id' => auth()->id(),
        ]);
        // broadcast task created event
        broadcast(new TaskCreated($task));

        // redirect to tasks.index
        return redirect()->route('dashboard')->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Task $task
     * @return view
     */
    public function edit(Task $task): View
    {
        $statuses = Task::STATUSES;
        return view('tasks.edit', compact('task', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        // update task
        $task->update([
            'title' => $request->title,
            'desc' => $request->desc,
            'status' => $request->status,
        ]);
        
        broadcast(new TaskUpdated($task));

        // redirect to tasks.index
        return redirect()->route('dashboard')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        $id = $task->id;
        $userID = $task->user_id;
        $task->delete();
        broadcast(new TaskDeleted($userID, $id));
        return redirect()->route('dashboard')->with('success', 'Task deleted successfully.');
    }
}
