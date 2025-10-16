@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
  <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-900 dark:text-gray-100">ログイン</h1>
    
    <form class="space-y-4">
      <div>
        <input 
          type="email" 
          placeholder="メールアドレス" 
          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
        >
      </div>
      
      <div>
        <input 
          type="password" 
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
    </form>
  </div>
</div>
@endsection