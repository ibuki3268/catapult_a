@extends('layouts.app')

@section('title', '共有メンバー')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">共有メンバー</h2>
    
    <!-- 現在の共有メンバー -->
    <div class="bg-white/90 backdrop-blur-sm rounded-lg p-6 shadow-md mb-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">メンバー一覧</h3>
        <div class="space-y-3">
            @forelse ($members ?? [] as $member)
            <div class="bg-gray-50 rounded-lg p-4 flex items-center justify-between border border-gray-200">
                <div class="flex items-center gap-3">
                    <!-- アバター -->
                    <div class="w-10 h-10 rounded-full bg-[#D5528E] flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">{{ $member->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $member->email }}</p>
                    </div>
                </div>
                <button onclick="confirmRemoveMember('{{ $member->id }}')" class="text-red-500 hover:text-red-700 font-semibold transition">
                    削除
                </button>
            </div>
            @empty
            <p class="text-gray-500 text-center py-6">共有メンバーがいません</p>
            @endforelse
        </div>
    </div>

    <!-- メンバー追加ボタン -->
    <button onclick="openAddMemberModal()" class="w-full bg-[#D5528E] text-white font-bold py-3 rounded-lg hover:bg-[#b84477] transition shadow-md">
        + メンバーを追加
    </button>
</div>

<!-- モーダル: メンバー追加 -->
<div id="addMemberModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg w-full max-w-md shadow-xl">
        <!-- ヘッダー -->
        <div class="bg-[#D5528E] text-white px-6 py-4 rounded-t-lg flex items-center justify-between">
            <h2 class="text-xl font-bold">メンバーを追加</h2>
            <button onclick="closeAddMemberModal()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- 検索フォーム -->
        <div class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2 text-gray-700">メールアドレスで検索</label>
                <div class="flex gap-2">
                    <input 
                        type="email" 
                        id="searchEmail" 
                        placeholder="例: user@example.com" 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D5528E]"
                    >
                    <button onclick="searchMember()" class="bg-[#D5528E] text-white px-4 py-2 rounded-lg hover:bg-[#b84477] transition">
                        検索
                    </button>
                </div>
            </div>

            <!-- 検索結果 -->
            <div id="searchResults" class="hidden">
                <h3 class="text-sm font-semibold mb-2 text-gray-700">検索結果</h3>
                <div id="searchResultContent" class="space-y-2">
                    <!-- JavaScriptで動的に追加 -->
                </div>
            </div>

            <!-- ローディング -->
            <div id="searchLoading" class="hidden text-center py-4">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[#D5528E]"></div>
                <p class="text-sm text-gray-500 mt-2">検索中...</p>
            </div>

            <!-- エラーメッセージ -->
            <div id="searchError" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mt-4">
                <p class="text-sm"></p>
            </div>
        </div>
    </div>
</div>


<script>
    const modal = document.getElementById('addMemberModal');
    const emailInput = document.getElementById('searchEmail');
    const resultsDiv = document.getElementById('searchResults');
    const contentDiv = document.getElementById('searchResultContent');
    const loadingDiv = document.getElementById('searchLoading');
    const errorDiv = document.getElementById('searchError');
    
    // -----------------------------------------------------------------
    // 1. モーダルの表示/非表示関数
    // -----------------------------------------------------------------
    function openAddMemberModal() {
        modal.classList.remove('hidden');
        // モーダルを開くたびにフォームをリセット
        emailInput.value = '';
        resultsDiv.classList.add('hidden');
        errorDiv.classList.add('hidden');
    }

    function closeAddMemberModal() {
        modal.classList.add('hidden');
    }

    // -----------------------------------------------------------------
    // 2. メンバー検索処理 (searchMember() は onclick で呼ばれる)
    // -----------------------------------------------------------------
    async function searchMember() {
        const email = emailInput.value.trim();
        contentDiv.innerHTML = '';
        errorDiv.classList.add('hidden');
        
        if (!email) {
            errorDiv.querySelector('p').textContent = 'メールアドレスを入力してください。';
            errorDiv.classList.remove('hidden');
            return;
        }

        loadingDiv.classList.remove('hidden');
        resultsDiv.classList.add('hidden');

        try {
            // メールアドレスをエンコードしてURLに直接埋め込む 
            const encodedEmail = encodeURIComponent(email);

            // ここでLaravelのAPIを呼び出してユーザーを検索 
            const response = await fetch(`/share/search/${encodedEmail}`, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            loadingDiv.classList.add('hidden');

            // if (!response.ok) {
            //     // 4xx, 5xx エラー
            //     throw new Error('サーバーエラーが発生しました。');
            // }

            const data = await response.json();
            
            if (data.error) {
                 // ユーザーが見つからないなどのカスタムエラー
                 errorDiv.querySelector('p').textContent = data.error;
                 errorDiv.classList.remove('hidden');
            } else if (data.user) {
                // ユーザーが見つかった場合の表示
                displaySearchResult(data.user);
            } else {
                errorDiv.querySelector('p').textContent = 'そのメールアドレスのユーザーは見つかりませんでした。';
                errorDiv.classList.remove('hidden');
            }

        } catch (error) {
            loadingDiv.classList.add('hidden');
            errorDiv.querySelector('p').textContent = error.message;
            errorDiv.classList.remove('hidden');
            console.error('Search failed:', error);
        }
    }
    
    // -----------------------------------------------------------------
    // 3. 検索結果表示のヘルパー関数
    // -----------------------------------------------------------------
    function displaySearchResult(user) {
        const initial = user.name.toUpperCase().substring(0, 1);
        
        // ユーザー情報を表示し、「追加」ボタンを設置
        contentDiv.innerHTML = `
            <div class="bg-blue-50 rounded-lg p-4 flex items-center justify-between border border-blue-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">${initial}</div>
                    <div>
                        <h3 class="font-medium text-gray-800">${user.name}</h3>
                        <p class="text-sm text-gray-500">${user.email}</p>
                    </div>
                </div>
                <button 
                    onclick="addMember(${user.id})" 
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition font-semibold"
                >
                    追加
                </button>
            </div>
        `;
        resultsDiv.classList.remove('hidden');
    }
    
    // -----------------------------------------------------------------
    // 4. メンバー追加処理 (addMember(userId) が onclick で呼ばれる)
    // -----------------------------------------------------------------
    async function addMember(userId) {
        // CSRFトークンを取得
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        try {
            // ★ ここで /share/{user} ルートを呼び出して共有を実行 ★
            const response = await fetch(`/share/${userId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // CSRFトークンを送信
                },
                body: JSON.stringify({}) // 空のボディを送信
            });
            
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'メンバーの追加に失敗しました。');
            }
            
            // 成功メッセージを表示し、モーダルを閉じて画面をリロード
            const data = await response.json();
            alert(data.message); 
            closeAddMemberModal();
            window.location.reload(); 

        } catch (error) {
            errorDiv.querySelector('p').textContent = error.message;
            errorDiv.classList.remove('hidden');
            console.error('Add member failed:', error);
            errorMsg = error.message;
            
        }

    }
</script>

@endsection