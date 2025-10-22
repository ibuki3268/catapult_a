@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
<div class="min-h-[calc(100vh-160px)] flex items-center justify-center py-8">
  <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-900 dark:text-gray-100">ログイン</h1>
    
    <form class="space-y-4">
      <div>
        <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">メールアドレス</label>
        <input 
          type="email"
          name="email" 
          placeholder="メールアドレス" 
          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
        >
      </div>
      
      <div>
        <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">パスワード</label>
        <input 
          type="password"
          name="password" 
          placeholder="パスワード" 
          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
        >
      </div>
      
      <div>
        <button 
          type="submit" 
          class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200"
        >
          ログイン
        </button>
      </div>
      
      <div class="text-center mt-4">
        <p class="text-sm text-gray-600 dark:text-gray-400">
          アカウントをお持ちでない方は
          <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-700 font-semibold">
            新規登録
          </a>
        </p>
      </div>
    </form>
  </div>
</div>
@endsection