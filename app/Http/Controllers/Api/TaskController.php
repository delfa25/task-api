<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json(auth()->user()->tasks);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = Task::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date
        ]);

        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,in_progress,completed',
            'due_date' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task->update($request->only(['title', 'description', 'status', 'due_date']));
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}