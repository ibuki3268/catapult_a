@extends('layouts.app')

@section('title', 'ログイン')

@section('content')

<div class="min-h-[calc(100vh-160px)] flex items-center justify-center py-8">
  <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-900 dark:text-gray-100">ログイン</h1>
    
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf {{-- フォーム保護のためのCSRFトークン --}}

      {{-- 1. メールアドレス入力欄 --}}
      <div class="mt-4">
          <x-input-label for="email" :value="__('メールアドレス')" />
          
          <x-text-input 
              id="email" 
              class="block mt-1 w-full" 
              type="email" 
              name="email" 
              :value="old('email')" {{-- フォーム送信エラー時に値を保持 --}}
              required 
              autofocus {{-- ページロード時にフォーカスを当てる --}}
              placeholder="メールアドレス" 
              autocomplete="username" 
          />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>
      
      {{-- 2. パスワード入力欄 --}}
      <div class="mt-4">
          <x-input-label for="password" :value="__('パスワード')" />
          
          <x-text-input 
              id="password" 
              class="block mt-1 w-full" 
              type="password" 
              name="password" 
              required 
              placeholder="パスワード" 
              autocomplete="current-password" 
          />
          <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>
      
      {{-- 3. ログインボタン --}}
      <div class="mt-6">
          <x-primary-button class="w-full justify-center">
              {{ __('ログイン') }}
          </x-primary-button>
      </div>
      
      {{-- 4. 新規登録リンク --}}
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