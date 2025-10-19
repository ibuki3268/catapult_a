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
    return view('users.mypageUI');
    }

    public function register() {
    return view('auth.registerUI');
    }

    public function sharedMembers() {
    return view('shared.membersUI');
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
