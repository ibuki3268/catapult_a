@extends('layouts.app')

@section('title', 'タスク一覧')

@section('content')
<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6 text-gray-900 dark:text-gray-100">
        <div class="flex justify-between items-center mb-6">
          <h2 class="font-semibold text-xl">タスク一覧</h2>
          <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            新規作成
          </a>
        </div>

        <div class="space-y-4">
          @forelse ($tasks ?? [] as $task)
          <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4">
            <div class="flex justify-between items-start">
              <div class="flex-1">
                <h3 class="text-lg font-semibold mb-2">{{ $task->title }}</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ $task->description }}</p>
              </div>
              <div class="flex gap-2 ml-4">
                <a href="{{ route('tasks.edit', $task->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                  編集
                </a>
                <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" onsubmit="return confirm('本当に削除しますか?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                    削除
                  </button>
                </form>
              </div>
            </div>
          </div>
          @empty
          <p class="text-gray-500 text-center py-8">タスクがありません</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection