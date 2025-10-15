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
    return view('users.mypageUI');
    }

    // 他ページを作る場合はここに追加
    // public function todo() { return view('tasks.index'); }
}
