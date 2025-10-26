@extends('layouts.app')

@section('title', 'マイページ')

@section('content')
<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white/90 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg">
      <div class="p-6 text-gray-900">
        <h2 class="font-semibold text-xl mb-6">マイページ</h2>
        
        <div class="space-y-6">
          <!-- ユーザー情報 -->
          <div class="border-b border-gray-200 pb-4">
            <h3 class="text-lg font-semibold mb-3">ユーザー情報</h3>
            <div class="space-y-2">
              <p><span class="font-bold">名前:</span> {{ $user->name ?? 'ユーザー名' }}</p>
              <p><span class="font-bold">メールアドレス:</span> {{ $user->email ?? 'user@example.com' }}</p>
            </div>
          </div>

          <!-- タスク統計 -->
          <div class="border-b border-gray-200 pb-4">
            <h3 class="text-lg font-semibold mb-3">タスク統計</h3>
            <div class="grid grid-cols-3 gap-4">
              <div class="bg-blue-100 p-4 rounded">
                <p class="text-2xl font-bold">{{ $totalTasks ?? 0 }}</p>
                <p class="text-sm">総タスク数</p>
              </div>
              <div class="bg-green-100 p-4 rounded">
                <p class="text-2xl font-bold">{{ $completedTasks ?? 0 }}</p>
                <p class="text-sm">完了</p>
              </div>
              <div class="bg-yellow-100 p-4 rounded">
                <p class="text-2xl font-bold">{{ $pendingTasks ?? 0 }}</p>
                <p class="text-sm">未完了</p>
              </div>
            </div>
          </div>

          <!-- アクション -->
          <div class="flex flex-col gap-4 sm:items-center">
            <a href="{{ route('tasks.index') }}" 
               class="bg-[#D5528E] hover:bg-[#b84477] text-white font-bold py-2 px-4 rounded text-center transition w-full sm:w-1/2">
                タスク一覧へ
            </a>
  
          <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-1/2">
             @csrf
           <button type="submit" 
                class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition">
                ログアウト
          </button>
          </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection