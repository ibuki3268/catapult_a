<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Task App</title>
    <meta name="viewport" content="width=device-width">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <a class="header-logo" href="/">
                <img src="{{ asset('images/common/logo-header-2.png') }}" alt="Task App Logo">
            </a>
            <nav class="site-menu">
                <ul>
                    <li><a href="{{ route('tasks.index') }}">タスク一覧</a></li>
                    <li><a href="{{ route('tasks.create') }}">新規作成</a></li>
                    <li><a href="{{ route('mypage') }}">マイページ</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">
        @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- 成功メッセージ(全ページ共通) -->
        @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
        @endif
        @yield('content')
    </main>

    <footer class="footer">
        <p class="copyright"><small>&copy; 2025 Task App</small></p>
    </footer>
</body>
</html>