@extends('layouts.app')

@section('title', '新規登録')

@section('content')

<div class="min-h-[calc(100vh-160px)] flex items-center justify-center py-8">
  <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-900 dark:text-gray-100">新規登録</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
      @csrf
      
      {{-- 1. 名前入力欄 (元のBladeコンポーネント部分) --}}
      <div class="mt-4">
          <x-input-label for="name" :value="__('名前')" />

          <x-text-input 
              id="name" 
              class="block mt-1 w-full" 
              type="text" 
              name="name" 
              :value="old('name')" 
              required 
              placeholder="名前" 
              autocomplete="name" 
          />
          <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div>
      
      {{-- 2. メールアドレス入力欄 (HTMLからBladeコンポーネントへ変更) --}}
      <div class="mt-4">
          <x-input-label for="email" :value="__('メールアドレス')" />
          
          <x-text-input 
              id="email" 
              class="block mt-1 w-full" 
              type="email" 
              name="email" 
              :value="old('email')" {{-- 値の保持を追加 --}}
              required 
              placeholder="メールアドレス" 
              autocomplete="username" 
          />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>
      
      {{-- 3. パスワード入力欄 (HTMLからBladeコンポーネントへ変更) --}}
      <div class="mt-4">
          <x-input-label for="password" :value="__('パスワード')" />
          
          <x-text-input 
              id="password" 
              class="block mt-1 w-full" 
              type="password" 
              name="password" 
              required 
              placeholder="パスワード" 
              autocomplete="new-password" 
          />
          <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>
      
      {{-- 4. パスワード確認入力欄 (HTMLからBladeコンポーネントへ変更) --}}
      <div class="mt-4">
          <x-input-label for="password_confirmation" :value="__('パスワード確認')" />
          
          <x-text-input 
              id="password_confirmation" 
              class="block mt-1 w-full" 
              type="password" 
              name="password_confirmation" 
              required 
              placeholder="パスワード確認" 
              autocomplete="new-password" 
          />
          <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
      </div>
      
      {{-- 5. 登録ボタン (HTMLからBladeコンポーネントへ変更) --}}
      <div class="mt-6">
          {{-- Tailwind CSSのスタイルを考慮し、x-primary-buttonに置き換え --}}
          <x-primary-button class="w-full justify-center">
              {{ __('登録') }}
          </x-primary-button>
      </div>
      
      {{-- 6. ログインリンク --}}
      <div class="text-center mt-4">
          <p class="text-sm text-gray-600 dark:text-gray-400">
              アカウントをお持ちの方は
              <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700 font-semibold">
                  ログイン
              </a>
          </p>
      </div>
    </form>

  </div>
</div>
@endsection