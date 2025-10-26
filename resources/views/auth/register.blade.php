@extends('layouts.app')

@section('title', '新規登録')

@section('content')

<div class="min-h-[calc(100vh-160px)] flex items-center justify-center py-8">
  <div class="max-w-md w-full bg-white/90 backdrop-blur-sm rounded-lg shadow-lg p-8">
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-900">新規登録</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
      @csrf
      
      <!-- 名前 -->
      <div>
        <label for="name" class="block text-sm font-semibold mb-2 text-gray-700">名前</label>
        <input 
          id="name" 
          type="text" 
          name="name" 
          value="{{ old('name') }}"
          placeholder="名前" 
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D5528E]"
          required 
          autofocus
        >
        @error('name')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>
      
      <!-- メールアドレス -->
      <div>
        <label for="email" class="block text-sm font-semibold mb-2 text-gray-700">メールアドレス</label>
        <input 
          id="email" 
          type="email" 
          name="email" 
          value="{{ old('email') }}"
          placeholder="メールアドレス" 
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D5528E]"
          required
        >
        @error('email')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>
      
      <!-- パスワード(目のマーク付き) -->
      <div>
        <label for="password" class="block text-sm font-semibold mb-2 text-gray-700">パスワード</label>
        <div class="relative">
          <input 
            id="password" 
            type="password" 
            name="password" 
            placeholder="パスワード" 
            class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D5528E] text-gray-900"
            required
          >
          <button 
            type="button" 
            onclick="togglePassword('password', 'eyeIcon1')"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
          >
            <svg id="eyeIcon1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <!-- 目を閉じたアイコン(デフォルト) -->
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            </svg>
          </button>
        </div>
        @error('password')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>
      
      <!-- パスワード確認(目のマーク付き) -->
      <div>
        <label for="password_confirmation" class="block text-sm font-semibold mb-2 text-gray-700">パスワード確認</label>
        <div class="relative">
          <input 
            id="password_confirmation" 
            type="password" 
            name="password_confirmation" 
            placeholder="パスワード確認" 
            class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D5528E] text-gray-900"
            required
          >
          <button 
            type="button" 
            onclick="togglePassword('password_confirmation', 'eyeIcon2')"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
          >
            <svg id="eyeIcon2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <!-- 目を閉じたアイコン(デフォルト) -->
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            </svg>
          </button>
        </div>
        @error('password_confirmation')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>
      
      <!-- 登録ボタン -->
      <div>
        <button 
          type="submit" 
          class="w-full bg-[#D5528E] hover:bg-[#b84477] text-white font-bold py-2 px-4 rounded-lg transition duration-200"
        >
          登録
        </button>
      </div>
      
      <!-- ログインリンク -->
      <div class="text-center mt-4">
        <p class="text-sm text-gray-600">
          アカウントをお持ちの方は
          <a href="{{ route('login') }}" class="text-[#D5528E] hover:text-[#b84477] font-semibold">
            ログイン
          </a>
        </p>
      </div>
    </form>

  </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        // 目を開いたアイコンに変更
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    } else {
        input.type = 'password';
        // 目を閉じたアイコンに変更
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    }
}
</script>

@endsection