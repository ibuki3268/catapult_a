@extends('layouts.app')

@section('title', '完了タスク削除')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">完了したタスクを削除</h2>
    
    <div class="bg-gray-900 rounded-lg p-6 mb-6">
        <p class="mb-4">以下の完了済みタスクを削除しますか?</p>
        <p class="text-3xl font-bold text-teal-400">{{ $completedCount ?? 0 }}件</p>
    </div>

    <form method="POST" action="{{ route('tasks.deleteCompleted') }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="w-full bg-red-500 text-white font-bold py-3 rounded-lg hover:bg-red-600 mb-3">
            削除する
        </button>
    </form>

    <a href="{{ route('tasks.index') }}" class="block text-center text-gray-400 hover:text-white">
        キャンセル
    </a>
</div>
@endsection