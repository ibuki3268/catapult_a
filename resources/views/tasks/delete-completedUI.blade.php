@extends('layouts.app')

@section('title', '完了タスク削除')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">完了したタスクを削除</h2>
    
    <div class="bg-gray-900 rounded-lg p-6 mb-6">
        <p class="mb-4">以下の完了済みタスクを削除しますか?</p>
        <p class="text-3xl font-bold text-teal-400">{{ $completedCount ?? 0 }}件</p>
        @if(($completedCount ?? 0) === 0)
        <p class="text-sm text-gray-400 mt-2">削除対象のタスクがありません</p>
        @endif
    </div>

    @if(($completedCount ?? 0) > 0)
    <form method="POST" action="{{ route('tasks.deleteCompleted.execute') }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="w-full bg-red-500 text-white font-bold py-3 rounded-lg hover:bg-red-600 mb-3">
            削除する
        </button>
    </form>
    @else
    <button disabled class="w-full bg-gray-500 text-gray-300 font-bold py-3 rounded-lg mb-3 cursor-not-allowed opacity-50">
        削除する
    </button>
    @endif

    <a href="{{ route('tasks.index') }}" class="block text-center text-gray-400 hover:text-white">
        キャンセル
    </a>
</div>
@endsection