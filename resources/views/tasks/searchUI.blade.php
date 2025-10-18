@extends('layouts.app')

@section('title', '検索')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">タスク検索</h2>
    
    <form method="GET" action="{{ route('tasks.search') }}" class="mb-6">
        <div class="flex gap-2">
            <input type="text" name="q" placeholder="検索キーワード" value="{{ request('q') }}" class="flex-1 bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:border-teal-400">
            <button type="submit" class="bg-teal-400 text-black font-bold px-6 py-3 rounded-lg hover:bg-teal-500">
                検索
            </button>
        </div>
    </form>

    <div class="space-y-3">
        @forelse ($results ?? [] as $task)
        <div class="bg-gray-900 rounded-lg p-4">
            <h3 class="font-medium">{{ $task->title }}</h3>
            <p class="text-sm text-gray-400 mt-1">{{ $task->description }}</p>
        </div>
        @empty
        <p class="text-gray-500 text-center py-10">検索結果がありません</p>
        @endforelse
    </div>
</div>
@endsection