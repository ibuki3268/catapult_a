@extends('layouts.app')

@section('title', 'タスク作成')

@section('content')
<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6 text-gray-900 dark:text-gray-100">
        <h2 class="font-semibold text-xl mb-6">タスク作成</h2>
        <!--名称変更-->
        <form method="POST" action="{{ route('tasks.store') }}">
          @csrf
          <div class="mb-4">
            <label for="title" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">タイトル</label>
            <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            @error('title')
            <span class="text-red-500 text-xs italic">{{ $message }}</span>
            @enderror
          </div>

          <div class="mb-4">
            <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">説明</label>
            <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            @error('description')
            <span class="text-red-500 text-xs italic">{{ $message }}</span>
            @enderror
          </div>

          <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">作成</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection