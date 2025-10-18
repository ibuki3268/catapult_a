@extends('layouts.app')

@section('title', 'ようこそ')

@section('content')
<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
      <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
        <h1 class="text-4xl font-bold mb-4 text-[#933F15]">ToDolist</h1>
        <p class="text-lg mb-8">タスク管理アプリへようこそ。さあ、始めましょう!</p>

        <div class="flex justify-center gap-4">
          <a href="{{ route('login') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded">
            ログインページへ
          </a>
          <a href="{{ route('tasks.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded">
            タスク一覧へ
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection