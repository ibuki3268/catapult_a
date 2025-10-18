<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Task App')</title>
    <meta name="description" content="タスク管理アプリ">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="ba-[#FFFFFF] background-size: cover; background-position: center; background-attachment: fixed;" class="text-white min-h-screen">    
    <header class="bg-[#D5528E] border-b border-gray-800 fixed top-0 left-0 right-0 z-50">       
        <div class="max-w-screen-xl mx-auto px-5 h-16 flex items-center justify-between">
            
            <!-- ロゴ -->
            <a href="{{ route('welcome') }}" class="block">
                <img src="{{ asset('images/common/nezumi.jpg') }}" alt="Task App Logo" class="h-8 w-auto">
            </a>

            <h1 class="text-2xl font-bold text-white absolute left-1/2 transform -translate-x-1/2">ToDo List</h1>
            
            <!-- メニュー(PC表示) -->
            <nav class="hidden md:block">
                <ul class="flex gap-8">
                    <li><a href="{{ route('tasks.index') }}" class="text-black hover:text-teal-600 transition">タスク一覧</a></li>
                    <li><a href="{{ route('tasks.create') }}" class="text-black hover:text-teal-600 transition">新規作成</a></li>
                    <li><a href="{{ route('mypage') }}" class="text-black hover:text-teal-600 transition">マイページ</a></li>
                    <li><a href="{{ route('shared.members') }}" class="text-black hover:text-teal-600 transition">共有メンバー</a></li>
                </ul>
            </nav>
            
            <!-- ハンバーガーボタン(スマホ表示) -->
            <button id="menuToggle" class="md:hidden w-10 h-10 flex flex-col justify-center items-center gap-1.5">
                <span class="w-6 h-0.5 bg-black"></span>
                <span class="w-6 h-0.5 bg-black"></span>
                <span class="w-6 h-0.5 bg-black"></span>
            </button>
        </div>
        
        <!-- スマホメニュー -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-100">
            <ul class="py-4">
                <li><a href="{{ route('tasks.index') }}" class="block px-5 py-3 text-black hover:bg-gray-100 transition">タスク一覧</a></li>
                <li><a href="{{ route('tasks.create') }}" class="block px-5 py-3 text-black hover:bg-gray-100 transition">新規作成</a></li>
                <li><a href="{{ route('mypage') }}" class="block px-5 py-3 text-black hover:bg-gray-100 transition">マイページ</a></li>
                <li><a href="{{ route('shared.members') }}" class="block px-5 py-3 text-black hover:bg-gray-100 transition">共有メンバー</a></li>
            </ul>
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main class="pt-20 pb-28 px-4 max-w-screen-xl mx-auto">
        
        <!-- エラーメッセージ -->
        @if ($errors->any())
        <div class="bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <!-- 成功メッセージ -->
        @if (session('success'))
        <div class="bg-green-900 border border-green-700 text-green-200 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
        @endif

        @yield('content')
    </main>

    <!-- フッター -->
    <footer class="bg-[#D5528E] text-gray-400 text-center py-5 mt-10  fixed bottom-0 left-0 right-0 border-t border-pink-200 shadow-md backdrop-blur-sm">
        <p class="text-sm">&copy; 2025 Task App</p>
    </footer>

    <!-- 固定ボタン(画面下部) -->
    <div class="fixed bottom-8 left-0 right-0 flex justify-between px-8 pointer-events-none">
        <!-- ゴミ箱ボタン -->
            <a href="{{ route('tasks.deleteCompleted.view') }}" 
           class="pointer-events-auto w-16 h-16 flex items-center justify-center hover:scale-110 transition  bg-white"
           onclick="return confirm('完了したタスクを削除しますか?');">
            <svg class="w-12 h-12 text-[#5BCCF8] drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </a>
        
        <!-- プラスボタン -->
        <a href="{{ route('tasks.create') }}" 
           class="pointer-events-auto w-16 h-16 flex items-center justify-center hover:scale-110 transition">
            <svg class="w-8 h-8 text-[#5BCCF8] drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
            </svg>
        </a>
    </div>

    <!-- JavaScript -->
    <script>
        // ハンバーガーメニュー
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>