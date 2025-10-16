<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Task App')</title>
    <meta name="description" content="タスク管理アプリ">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<!-- 画面下部に固定されるアヒル -->
<div id="duck" style="
    position: fixed;
    bottom: 20px;
    left: 50px;
    font-size: 60px;
    cursor: pointer;
    z-index: 9999;
    transition: all 0.3s ease;
">
    🦆
</div>

<!-- 音声ファイル（クワック音） -->
<audio id="quackSound" preload="auto">
    <source src="https://cdn.freesound.org/previews/607/607290_1648170-lq.mp3" type="audio/mpeg">
</audio>

<!-- 画面下部を歩くアヒル -->
<div id="duck" style="
    position: fixed;
    bottom: 20px;
    left: 0px;
    font-size: 60px;
    cursor: pointer;
    z-index: 9999;
    transition: transform 0.3s ease;
">
    🦆
</div>

<!-- 音声ファイル（クワック音） -->
<audio id="quackSound" preload="auto">
    <source src="https://cdn.freesound.org/previews/607/607290_1648170-lq.mp3" type="audio/mpeg">
</audio>

<script>
const duck = document.getElementById('duck');
const quackSound = document.getElementById('quackSound');
let isAnimating = false;
let position = 0;
let direction = 1; // 1=右へ、-1=左へ
let walkInterval;

// 普段は下を左右に歩く
function walk() {
    if (isAnimating) return;
    
    position += direction * 2;
    
    // 画面端に到達したら反対向きに
    if (position >= window.innerWidth - 80) {
        direction = -1;
        duck.style.transform = 'scaleX(-1)'; // 左向き
    } else if (position <= 0) {
        direction = 1;
        duck.style.transform = 'scaleX(1)'; // 右向き
    }
    
    duck.style.left = position + 'px';
}

// 歩き始める
walkInterval = setInterval(walk, 30);

// クリックしたら暴れる
duck.addEventListener('click', function() {
    if (isAnimating) return;
    isAnimating = true;
    
    // 歩くのを一時停止
    clearInterval(walkInterval);
    
    // 音を鳴らす
    quackSound.currentTime = 0;
    quackSound.play().catch(e => console.log('音声再生エラー'));
    
    // ジャンプして回転
    duck.style.transition = 'all 0.5s ease';
    duck.style.transform = 'translateY(-150px) scale(1.5) rotate(360deg)';
    duck.style.bottom = '20px';
    
    setTimeout(() => {
        duck.style.transform = 'translateY(0) scale(1) rotate(0deg)';
    }, 500);
    
    // ランダムに画面上を飛び回る
    setTimeout(() => {
        const randomX = Math.random() * (window.innerWidth - 100);
        const randomY = Math.random() * (window.innerHeight / 2); // 上半分だけ
        
        duck.style.left = randomX + 'px';
        duck.style.bottom = randomY + 'px';
        
        // くるくる回る
        duck.style.transition = 'all 1s ease';
        duck.style.transform = 'rotate(720deg) scale(1.8)';
        
        setTimeout(() => {
            // 元の位置（下）に戻る
            duck.style.transition = 'all 0.8s ease';
            duck.style.bottom = '20px';
            duck.style.left = position + 'px';
            duck.style.transform = direction === 1 ? 'scaleX(1)' : 'scaleX(-1)';
            
            setTimeout(() => {
                // 歩き再開
                isAnimating = false;
                walkInterval = setInterval(walk, 30);
            }, 800);
        }, 1000);
    }, 600);
});

// マウスを乗せたら少し大きくなる
duck.addEventListener('mouseenter', function() {
    if (!isAnimating) {
        const currentScale = direction === 1 ? 'scaleX(1.2)' : 'scaleX(-1.2)';
        duck.style.transform = currentScale + ' scaleY(1.2)';
    }
});

duck.addEventListener('mouseleave', function() {
    if (!isAnimating) {
        duck.style.transform = direction === 1 ? 'scaleX(1)' : 'scaleX(-1)';
    }
});
</script>

<body class="bg-[#D6D9CC] text-white min-h-screen">
    
    <!-- ヘッダー -->
    <header class="bg-white border-b border-gray-800 fixed top-0 left-0 right-0 z-50">
        <div class="max-w-screen-xl mx-auto px-5 h-16 flex items-center justify-between">
            
            <!-- ロゴ -->
            <a href="{{ route('welcome') }}" class="block">
                <img src="{{ asset('images/common/nezumi.jpg') }}" alt="Task App Logo" class="h-8 w-auto">
            </a>
            
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
    <footer class="bg-gray-900 text-gray-400 text-center py-5 mt-10">
        <p class="text-sm">&copy; 2025 Task App</p>
    </footer>

    <!-- 固定ボタン(画面下部) -->
    <div class="fixed bottom-8 left-0 right-0 flex justify-between px-8 pointer-events-none">
        <!-- ゴミ箱ボタン -->
        <a href="{{ route('tasks.deleteCompleted') }}" 
           class="pointer-events-auto w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center hover:bg-gray-700 transition shadow-lg"
           onclick="return confirm('完了したタスクを削除しますか?');">
            <svg class="w-8 h-8 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </a>
        
        <!-- プラスボタン -->
        <a href="{{ route('tasks.create') }}" 
           class="pointer-events-auto w-16 h-16 bg-teal-400 rounded-full flex items-center justify-center hover:bg-teal-500 transition shadow-lg">
            <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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