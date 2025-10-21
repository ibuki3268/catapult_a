<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            overflow: hidden;
            font-family: 'Arial', sans-serif;
        }

        /* ピンク背景 */
        .pink-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: #D5528E;
            z-index: 9999;
        }

        /* 白い丸 */
        .white-circle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            animation: circleExpand 3s ease-out forwards;
        }

        /* 丸の拡大アニメーション */
        @keyframes circleExpand {
            0% {
                transform: translate(-50%, -50%) scale(0) rotate(0deg);
                opacity: 0;
            }
            30% {
                transform: translate(-50%, -50%) scale(1) rotate(360deg);
                opacity: 1;
            }
            70% {
                transform: translate(-50%, -50%) scale(1) rotate(720deg);
            }
            100% {
                transform: translate(-50%, -50%) scale(50);
                opacity: 1;
            }
        }

        /* ウェルカム画面 */
        .welcome-content {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            animation: fadeIn 1s ease-in 2.5s forwards;
            z-index: 10000;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        /* WELCOMEテキストアニメーション */
        .welcome-text {
            font-size: 4rem;
            font-weight: bold;
            color: #D5528E;
            opacity: 0;
            transform: translateY(30px);
            animation: textSlideUp 0.8s ease-out 3s forwards;
        }

        @keyframes textSlideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* サブテキスト */
        .sub-text {
            font-size: 1rem;
            color: #666;
            margin-top: 10px;
            opacity: 0;
            animation: textSlideUp 0.8s ease-out 3.3s forwards;
        }

        /* 3D図形 */
        .shape-3d {
            position: absolute;
            width: 300px;
            height: 300px;
            opacity: 0;
            animation: shapeAppear 1s ease-out 3.2s forwards;
        }

        @keyframes shapeAppear {
            to {
                opacity: 0.3;
            }
        }

        /* ボタンコンテナ */
        .button-container {
            margin-top: 50px;
            display: flex;
            gap: 20px;
            opacity: 0;
            transform: translateY(20px);
            animation: buttonSlideUp 0.8s ease-out 3.6s forwards;
        }

        @keyframes buttonSlideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ボタンスタイル */
        .btn {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-login {
            background: #D5528E;
            color: white;
            border: 2px solid #D5528E;
        }

        .btn-login:hover {
            background: #B8457A;
            transform: scale(1.05);
        }

        .btn-register {
            background: white;
            color: #D5528E;
            border: 2px solid #D5528E;
        }

        .btn-register:hover {
            background: #D5528E;
            color: white;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <!-- ピンク背景と白い丸 -->
    <div class="pink-bg">
        <div class="white-circle"></div>
    </div>

    <!-- ウェルカム画面 -->
    <div class="welcome-content">
        <!-- 3D図形（SVG） -->
        <svg class="shape-3d" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <!-- ダイヤモンド型ワイヤーフレーム -->
            <g stroke="#4DD0E1" stroke-width="1" fill="none">
                <!-- 上部 -->
                <ellipse cx="100" cy="60" rx="80" ry="15" />
                <ellipse cx="100" cy="70" rx="70" ry="13" />
                <ellipse cx="100" cy="80" rx="60" ry="11" />
                <ellipse cx="100" cy="90" rx="50" ry="9" />
                <ellipse cx="100" cy="100" rx="40" ry="7" />
                
                <!-- 中央 -->
                <ellipse cx="100" cy="100" rx="90" ry="5" stroke="#F9A825" />
                
                <!-- 下部 -->
                <ellipse cx="100" cy="110" rx="40" ry="7" />
                <ellipse cx="100" cy="120" rx="50" ry="9" />
                <ellipse cx="100" cy="130" rx="60" ry="11" />
                <ellipse cx="100" cy="140" rx="70" ry="13" />
                <ellipse cx="100" cy="150" rx="80" ry="15" />
                
                <!-- 縦線 -->
                <line x1="100" y1="45" x2="100" y2="155" />
                <line x1="50" y1="70" x2="150" y2="130" />
                <line x1="150" y1="70" x2="50" y2="130" />
            </g>
        </svg>

        <!-- WELCOMEテキスト -->
        <h1 class="welcome-text">ToDo List</h1>
        <p class="sub-text"></p>

        <!-- ボタン -->
        <div class="button-container">
            <a href="/login" class="btn btn-login">ログイン</a>
            <a href="/register" class="btn btn-register">新規登録</a>
        </div>
    </div>
</body>
</html>
