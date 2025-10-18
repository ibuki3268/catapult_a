<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TaskController extends Controller
{
    public function __construct()
    {
        // 開発中はログイン不要にするため、本番環境のみ auth を有効化
        if (app()->environment('production')) {
            $this->middleware('auth');
        }
    }

    public function index()
    {
        $tasks = Task::where('user_id', $this->currentUserId())->orderBy('created_at', 'desc')->get();
        return view('tasks.indexUI', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.createUI');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority' => 'nullable|integer',
        ]);

        $task = Task::create([
            'user_id' => $this->currentUserId(),
            'title' => $data['title'],
            'body' => $data['description'] ?? null,
            'deadline' => $data['deadline'] ?? null,
            'priority' => $data['priority'] ?? 1,
            'done' => false,
        ]);

        return redirect()->route('tasks.index')->with('success', 'タスクを作成しました。');
    }

    public function edit(Task $task)
    {
        if ($task->user_id !== $this->currentUserId()) {
            abort(403);
        }

        return view('tasks.editUI', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== $this->currentUserId()) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority' => 'nullable|integer',
            'done' => 'nullable|boolean',
        ]);

        $task->update([
            'title' => $data['title'],
            'body' => $data['description'] ?? null,
            'deadline' => $data['deadline'] ?? null,
            'priority' => $data['priority'] ?? 1,
            'done' => $data['done'] ?? false,
        ]);

        return redirect()->route('tasks.index')->with('success', 'タスクを更新しました。');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== $this->currentUserId()) {
            abort(403);
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'タスクを削除しました。');
    }

    public function deleteCompletedView()
    {
        $completedCount = Task::where('user_id', $this->currentUserId())
            ->where('done', true)
            ->count();

        return view('tasks.delete-completedUI', compact('completedCount'));
    }

    public function deleteCompletedExecute()
    {
        Task::where('user_id', $this->currentUserId())->where('done', true)->delete();
        return redirect()->route('tasks.index')->with('success', '完了タスクをすべて削除しました。');
    }

    // Ajax: チェックボックスでdone状態をトグル
    public function toggleDone(Task $task, Request $request)
    {
        if ($task->user_id !== $this->currentUserId()) {
            return response()->json(['error' => '権限がありません'], 403);
        }
        $validated = $request->validate([
            'done' => 'required|boolean',
        ]);
        $task->done = $validated['done'];
        $task->save();
        return response()->json(['success' => true, 'done' => $task->done]);
    }

    /**
     * Return a user id to use for development when Auth::id() is null.
     * If no user exists, create a simple local dev user.
     */
    private function currentUserId(): int
    {
        $id = Auth::id();
        if ($id) {
            return $id;
        }

        // Use the first existing user if any
        $user = User::first();
        if ($user) {
            return $user->id;
        }

        // Create a local development user (email reserved for local dev)
        $dev = User::create([
            'name' => 'dev',
            'email' => 'dev@local.test',
            'password' => Hash::make('password'),
        ]);

        return $dev->id;
    }
}
