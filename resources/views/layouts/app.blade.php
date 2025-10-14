<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Task App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-black text-white min-h-screen">
    <!-- トップバー -->
    <header class="fixed top-0 left-0 right-0 bg-black z-50 px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- ハンバーガーメニュー -->
            <button id="menuBtn" class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <div class="flex gap-3">
                <!-- 検索ボタン -->
                <button id="searchBtn" class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- 設定ボタン -->
                <button id="settingsBtn" class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- サイドメニュー(ハンバーガー) -->
    <div id="sideMenu" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden">
        <div class="fixed left-0 top-0 bottom-0 w-64 bg-gray-900 transform -translate-x-full transition-transform duration-300" id="menuPanel">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-6">メニュー</h2>
                <nav class="space-y-4">
                    <a href="{{ route('tasks.index') }}" class="block py-2 px-4 rounded hover:bg-gray-800">タスク一覧</a>
                    <a href="{{ route('tasks.create') }}" class="block py-2 px-4 rounded hover:bg-gray-800">新規作成</a>
                    <a href="{{ route('mypage') }}" class="block py-2 px-4 rounded hover:bg-gray-800">マイページ</a>
                    <a href="{{ route('shared.members') }}" class="block py-2 px-4 rounded hover:bg-gray-800">共有メンバー</a>
                </nav>
            </div>
        </div>
    </div>

    <!-- 設定パネル -->
    <div id="settingsPanel" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden">
        <div class="fixed right-0 top-0 bottom-0 w-64 bg-gray-900 transform translate-x-full transition-transform duration-300" id="settingsPanelContent">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-6">設定</h2>
                <nav class="space-y-4">
                    <a href="{{ route('mypage') }}" class="block py-2 px-4 rounded hover:bg-gray-800">マイページ</a>
                    <a href="{{ route('shared.members') }}" class="block py-2 px-4 rounded hover:bg-gray-800">共有メンバー確認</a>
                    <a href="{{ route('login') }}" class="block py-2 px-4 rounded hover:bg-gray-800">ログアウト</a>
                </nav>
            </div>
        </div>
    </div>

    <!-- メインコンテンツ -->
    <main class="pt-20 pb-24 px-4">
        @if ($errors->any())
        <div class="mb-4 bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        @if (session('success'))
        <div class="mb-4 bg-green-900 border border-green-700 text-green-200 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
        @endif

        @yield('content')
    </main>

    <!-- ボトムボタン -->
    <div class="fixed bottom-6 left-0 right-0 flex justify-between px-6">
        <!-- ゴミ箱ボタン -->
        <button id="deleteCompletedBtn" class="w-16 h-16 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700 shadow-lg">
            <svg class="w-8 h-8 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>

        <!-- プラスボタン -->
        <a href="{{ route('tasks.create') }}" class="w-16 h-16 rounded-full bg-teal-400 flex items-center justify-center hover:bg-teal-500 shadow-lg">
            <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
            </svg>
        </a>
    </div>

    <script>
        // ハンバーガーメニュー
        const menuBtn = document.getElementById('menuBtn');
        const sideMenu = document.getElementById('sideMenu');
        const menuPanel = document.getElementById('menuPanel');

        menuBtn.addEventListener('click', () => {
            sideMenu.classList.remove('hidden');
            setTimeout(() => menuPanel.classList.remove('-translate-x-full'), 10);
        });

        sideMenu.addEventListener('click', (e) => {
            if (e.target === sideMenu) {
                menuPanel.classList.add('-translate-x-full');
                setTimeout(() => sideMenu.classList.add('hidden'), 300);
            }
        });

        // 設定パネル
        const settingsBtn = document.getElementById('settingsBtn');
        const settingsPanel = document.getElementById('settingsPanel');
        const settingsPanelContent = document.getElementById('settingsPanelContent');

        settingsBtn.addEventListener('click', () => {
            settingsPanel.classList.remove('hidden');
            setTimeout(() => settingsPanelContent.classList.remove('translate-x-full'), 10);
        });

        settingsPanel.addEventListener('click', (e) => {
            if (e.target === settingsPanel) {
                settingsPanelContent.classList.add('translate-x-full');
                setTimeout(() => settingsPanel.classList.add('hidden'), 300);
            }
        });

        // 検索ボタン
        const searchBtn = document.getElementById('searchBtn');
        searchBtn.addEventListener('click', () => {
            window.location.href = '{{ route("tasks.search") }}';
        });

        // 完了タスク削除
        const deleteCompletedBtn = document.getElementById('deleteCompletedBtn');
        deleteCompletedBtn.addEventListener('click', () => {
            if (confirm('完了したタスクを削除しますか?')) {
                window.location.href = '{{ route("tasks.deleteCompleted") }}';
            }
        });
    </script>
</body>
</html>