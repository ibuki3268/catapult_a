<?php

namespace App\Http\Controllers;

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

    public function taskIndex() {
    return view('tasks.indexUI');
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
    return view('shared.membersUI');
    }

    // 他ページを作る場合はここに追加
    // public function todo() { return view('tasks.index'); }
}
