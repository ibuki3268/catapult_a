@props(['title' => ''])

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }} - Task App</title>
    <meta name="description" content="タスク管理アプリ">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Vite(Tailwind CSS含む) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-image: url('{{ asset('images/common/bg-brown.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;" class="text-white min-h-screen">
    
    <!-- ヘッダー -->
<header class="bg-[#D5528E] border-b border-[#D5528E] fixed top-0 left-0 right-0 z-50">       
    <div class="max-w-screen-xl mx-auto px-5 h-16 flex items-center justify-center">
        <a href="{{ route('welcome') }}">
            <h1 class="text-2xl font-bold text-white">ToDo List</h1>
        </a>
    </div>
</header>

    <!-- メインコンテンツ -->
    <main class="pt-20 pb-32 px-4 max-w-screen-xl mx-auto min-h-[calc(100vh-140px)]">
        <div class="min-h-[calc(100vh-160px)] flex items-center justify-center py-8">
            <div class="max-w-md w-full bg-white/90 backdrop-blur-sm rounded-lg shadow-lg p-8">
                {{ $slot }}
            </div>
        </div>
    </main>

    <!-- フッター -->
    <footer class="bg-[#D5528E] text-white text-center py-5 fixed bottom-0 left-0 right-0 border-t border-pink-200 shadow-md backdrop-blur-sm">
        <p class="text-sm font-semibold">&copy; 2025 Task App</p>
    </footer>
</body>
</html>