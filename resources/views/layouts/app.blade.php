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
    <header class="bg-[#D5528E] border-b border-[#D5528E] fixed top-0 left-0 right-0 z-50">
        <div class="max-w-screen-xl mx-auto px-5 h-16 flex items-center justify-between">

            <!-- ロゴ -->
            <a href="{{ route('welcome') }}" class="block">
                <img src="{{ asset('images/common/onna.png') }}" alt="Task App Logo" class="h-8 w-auto" height="32" style="height:32px;width:auto;">
            </a>

            <h1 class="text-2xl font-bold text-white absolute left-1/2 transform -translate-x-1/2">ToDo List</h1>

            <!-- メニュー(PC表示) -->
            <nav class="hidden md:block">
                <ul class="flex gap-8">
                    <li><a href="{{ route('tasks.index') }}" class="text-[#FFFFFF] hover:text-teal-600 transition">タスク一覧</a></li>
                    <li><a href="{{ route('tasks.create') }}" class="text-[#FFFFFF] hover:text-teal-600 transition">新規作成</a></li>
                    <li><a href="{{ route('mypage') }}" class="text-[#FFFFFF] hover:text-teal-600 transition">マイページ</a></li>
                    <li><a href="{{ route('shared.members') }}" class="text-[#FFFFFF] hover:text-teal-600 transition">共有メンバー</a></li>
                </ul>
<div class="relative">
        <button onclick="toggleNotifications()" id="notificationBtn" class="relative text-white hover:text-teal-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <!-- 未読バッジ -->
            <span id="notificationBadge" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
        </button>

        <!-- 通知ドロップダウン -->
        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-[100] max-h-96 overflow-y-auto">
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-semibold text-gray-800">通知</h3>
            </div>
            <div id="notificationList" class="divide-y divide-gray-200">
                <!-- ここに通知が表示される -->
                <div class="p-4 text-center text-gray-500">通知を読み込み中...</div>
                </div>
            </div>
        </div>

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
        <div class="bg-[#F5D530] border-2 border-[#FFFFFF] text-[#5A4A00] px-4 py-3 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
<!-- 成功メッセージ -->
        @if (session('success'))
        <div class="bg-[#F5D530] border-2 border-[#FFFFFF] text-[#5A4A00] px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
        @endif

        @yield('content')
    </main>

    <!-- フッター -->
    <footer class="bg-[#D5528E] text-[#FFFFFF] text-center py-5 mt-10  fixed bottom-0 left-0 right-0 border-t border-pink-200 shadow-md backdrop-blur-sm">
        <p class="text-sm">&copy; 2025 Task App</p>
    </footer>

   <!-- 固定ボタン(画面下部) -->



    <!-- JavaScript -->
    <script>
        // ハンバーガーメニュー
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // 通知機能
let unreadCount = 0;

// 通知ドロップダウンの表示切り替え
function toggleNotifications() {
    const dropdown = document.getElementById('notificationDropdown');
    dropdown.classList.toggle('hidden');

    if (!dropdown.classList.contains('hidden')) {
        loadNotifications();
    }
}

// 通知を読み込む
function loadNotifications() {
    fetch('/notifications')
        .then(res => res.json())
        .then(data => {
            const list = document.getElementById('notificationList');
const badge = document.getElementById('notificationBadge');

            if (data.notifications.length === 0) {
                list.innerHTML = '<div class="p-4 text-center text-gray-500">通知はありません</div>';
                badge.classList.add('hidden');
                return;
            }

            // 未読件数を表示
            unreadCount = data.unread_count;
            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }

            // 通知一覧を表示
            list.innerHTML = data.notifications.map(notif => 
                <div class="p-4 hover:bg-gray-50 transition ${notif.is_read ? 'bg-white' : 'bg-blue-50'}" onclick="markAsRead(${notif.id})">
                    <p class="text-sm text-gray-800">${notif.message}</p>
                    <p class="text-xs text-gray-500 mt-1">${formatDate(notif.created_at)}</p>
                </div>
            ).join('');
        })
        .catch(err => {
            console.error('通知の取得に失敗:', err);
        });
}

// 既読にする
function markAsRead(notificationId) {
    fetch(/notifications/${notificationId}/read, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(() => {
        loadNotifications();
    });
}

// 日付フォーマット
function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diff = now - date;
    const minutes = Math.floor(diff / 60000);
    const hours = Math.floor(diff / 3600000);
    const days = Math.floor(diff / 86400000);

    if (minutes < 60) return ${minutes}分前;
    if (hours < 24) return ${hours}時間前;
    if (days < 7) return ${days}日前;
    return date.toLocaleDateString('ja-JP');
}
// ページ読み込み時に通知をチェック
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();

    // 5分ごとに通知をチェック
    setInterval(loadNotifications, 5 * 60 * 1000);
});

// ドロップダウンの外側クリックで閉じる
document.addEventListener('click', (e) => {
    const dropdown = document.getElementById('notificationDropdown');
    const btn = document.getElementById('notificationBtn');
    if (dropdown && !dropdown.contains(e.target) && !btn.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});
</script>

</body>
</html>