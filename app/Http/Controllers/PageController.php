<?php

namespace App\Http\Controllers;
use App\Models\TaskList;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // 既存メソッドがあればそのまま
    public function welcome() {
    return view('welcomeUI');
    } 

    public function login() {
    return view('auth.loginUI');
    }

    
    public function taskCreate() {
    return view('tasks.createUI');
    }

    public function taskEdit() {
    return view('tasks.editUI');
    }

    public function mypage() {
        // ログインユーザー取得（開発環境ならUser::first()）
        $user = \Auth::user() ?? \App\Models\User::first();
        $userId = $user ? $user->id : null;

        // タスク統計
        $totalTasks = $userId ? \App\Models\Task::where('user_id', $userId)->count() : 0;
        $completedTasks = $userId ? \App\Models\Task::where('user_id', $userId)->where('done', true)->count() : 0;
        $pendingTasks = $userId ? \App\Models\Task::where('user_id', $userId)->where('done', false)->count() : 0;

        return view('users.mypageUI', compact('user', 'totalTasks', 'completedTasks', 'pendingTasks'));
    }

    public function register() {
    return view('auth.registerUI');
    }

    public function sharedMembers() {
      // 現在のログインユーザーを取得
      $user = Auth::user() ?? \App\Models\User::first();

      // ユーザーの共有相手一覧を取得
      $sharedMembers = $user->sharedUsers()->get();
      
      return view('shared.membersUI', [
        'sharedMembers' => $sharedMembers
      ]);
    }

    public function taskIndex(Request $request)
    {
      // ログインユーザーのリスト一覧を取得
      $userId = Auth::id() ?? 1; // ← ログインしてなければ1(仮)
      $lists = TaskList::where('user_id', Auth::id())->get();
      
      

      // 現在表示するリストID
      $currentListId = $request->get('list_id', $lists->first()->id ?? null);

      // 現在のリスト情報
      $currentList = $currentListId ? TaskList::find($currentListId) : null;
      $currentListName = $currentList ? $currentList->name : 'やること';

      // タスク取得
      $tasks = $currentListId 
        ? Task::where('list_id', $currentListId)->get() 
        : [];

      return view('tasks.indexUI', compact('lists', 'currentListId', 'currentListName', 'tasks'));
   }

    // 他ページを作る場合はここに追加
    // public function todo() { return view('tasks.index'); }
}
