@extends('layouts.app')

@section('title', 'やること')

@section('content')
<!-- タブ -->
<div class="flex border-b border-gray-700 mb-6">
    <button class="px-6 py-3 border-b-2 border-teal-400 text-teal-400 font-semibold">やること</button>
    <button class="px-6 py-3 text-gray-400">+</button>
</div>

<!-- 編集・その他ボタン -->
<div class="flex justify-end gap-4 mb-4 text-sm text-gray-400">
    <button class="flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
        編集
    </button>
    <button class="flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
        </svg>
        その他
    </button>
</div>

<!-- タスクリスト -->
<div class="space-y-3">
    @forelse ($tasks ?? [] as $task)
    <div class="bg-gray-900 rounded-lg p-4 flex items-start gap-3 hover:bg-gray-800 transition">
        <!-- チェックボックス -->
        <input type="checkbox" class="w-5 h-5 mt-1 rounded border-gray-600 text-teal-400 focus:ring-teal-400 focus:ring-offset-gray-900">
        
        <div class="flex-1">
            <h3 class="font-medium">{{ $task->title }}</h3>
            @if($task->description)
            <p class="text-sm text-gray-400 mt-1">{{ $task->description }}</p>
            @endif
        </div>

        <a href="{{ route('tasks.edit', $task->id) }}" class="text-gray-400 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
    @empty
    <div class="text-center py-20">
        <p class="text-gray-500 text-lg">ToDoはありません</p>
    </div>
    @endforelse
</div>
@endsection