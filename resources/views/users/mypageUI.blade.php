@extends('layouts.app')

@section('title', 'マイページ')

@section('content')
<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6 text-gray-900 dark:text-gray-100">
        <h2 class="font-semibold text-xl mb-6">マイページ</h2>
        
        <div class="space-y-6">
          <!-- ユーザー情報 -->
          <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
            <h3 class="text-lg font-semibold mb-3">ユーザー情報</h3>
            <div class="space-y-2">
              <p><span class="font-bold">名前:</span> {{ $user->name ?? 'ユーザー名' }}</p>
              <p><span class="font-bold">メールアドレス:</span> {{ $user->email ?? 'user@example.com' }}</p>
            </div>
          </div>

          <!-- タスク統計 -->
          <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
            <h3 class="text-lg font-semibold mb-3">タスク統計</h3>
            <div class="grid grid-cols-3 gap-4">
              <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded">
                <p class="text-2xl font-bold">{{ $totalTasks ?? 0 }}</p>
                <p class="text-sm">総タスク数</p>
              </div>
              <div class="bg-green-100 dark:bg-green-900 p-4 rounded">
                <p class="text-2xl font-bold">{{ $completedTasks ?? 0 }}</p>
                <p class="text-sm">完了</p>
              </div>
              <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded">
                <p class="text-2xl font-bold">{{ $pendingTasks ?? 0 }}</p>
                <p class="text-sm">未完了</p>
              </div>
            </div>
          </div>

          <!-- アクション -->
          <div>
            <a href="{{ route('tasks.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              タスク一覧へ
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection