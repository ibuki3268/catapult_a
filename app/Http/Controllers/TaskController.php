<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Notification;

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

    // 通知を作成（テスト用・本番用の両方）
public function createNotifications()
{
    $now = Carbon::now();

    $tasks = Task::where('done', false)
                 ->whereNotNull('deadline')
                 ->get();

    $created = [];

    foreach ($tasks as $task) {
        $deadline = Carbon::parse($task->deadline)->startOfDay();
        $today = $now->copy()->startOfDay();
        $daysUntil = $today->diffInDays($deadline, false);

        // 期限3日前
        if ($daysUntil == 3) {
            $this->createNotificationIfNotExists($task, '期限まであと3日です');
            $created[] = "{$task->title}: 3日前の通知";
        }

        // 期限1日前
        if ($daysUntil == 1) {
            $this->createNotificationIfNotExists($task, '期限まであと1日です！');
            $created[] = "{$task->title}: 1日前の通知";
        }

        // 期限当日
        if ($daysUntil == 0) {
            $this->createNotificationIfNotExists($task, '今日が期限です！');
            $created[] = "{$task->title}: 当日の通知";
        }
    }

    return response()->json([
        'success' => true,
        'checked' => $tasks->count(),
        'created' => $created
    ]);
}

private function createNotificationIfNotExists($task, $message)
{
    $today = Carbon::today();
    $exists = Notification::where('user_id', $task->user_id)
                          ->where('message', 'like', "%{$task->title}%")
                          ->whereDate('created_at', $today)
                          ->exists();

    if (!$exists) {
        Notification::create([
            'user_id' => $task->user_id,
            'message' => "【{$task->title}】{$message}",
            'is_read' => false
        ]);
    }
}
}
