@extends('layouts.app')

@section('title', 'やること')

@section('content')
<!-- タブ(リスト一覧) -->
<div class="flex border-b border-gray-800 mb-6 bg-white/80 backdrop-blur-sm rounded-t-lg overflow-x-auto">
    @forelse ($lists ?? [] as $list)
    <a href="{{ route('tasks.index', ['list_id' => $list->id]) }}" 
       class="px-6 py-3 border-b-2 {{ $currentListId == $list->id ? 'border-[#03588C] text-[#03588C]' : 'border-transparent text-gray-700' }} font-semibold hover:text-[#03588C] transition whitespace-nowrap">
        {{ $list->name }}
    </a>
    @empty
    <button class="px-6 py-3 border-b-2 border-[#03588C] text-[#03588C] font-semibold">やること</button>
    @endforelse
    
    <!-- +ボタン(新規リスト作成) -->
    <button onclick="openCreateListModal()" class="px-6 py-3 text-gray-700 hover:text-[#03588C] transition">+</button>
</div>

<!-- リスト名変更ボタン -->
<div class="flex justify-end gap-4 mb-4 text-sm">
    <button onclick="alert('編集機能は準備中です')" class="flex items-center gap-1 bg-white/80 backdrop-blur-sm px-3 py-1.5 rounded-lg hover:bg-white transition cursor-pointer">
        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
        </svg>
        <span class="text-gray-700">編集</span>
    </button>
    <div class="relative z-50">
        <button onclick="toggleDropdown()" class="flex items-center gap-1 bg-white/80 backdrop-blur-sm px-3 py-1.5 rounded-lg hover:bg-white transition cursor-pointer">
            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
            </svg>
            <span class="text-gray-700">その他</span>
        </button>
        <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
            <button onclick="openRenameListModal(); toggleDropdown();" class="w-full text-left px-4 py-2.5 hover:bg-gray-50 transition flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                <span class="text-gray-700">リスト名変更</span>
            </button>
            <button onclick="alert('この機能はまだ実装されていません'); toggleDropdown();" class="w-full text-left px-4 py-2.5 hover:bg-gray-50 transition flex items-center gap-2 border-t border-gray-100">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                </svg>
                <span class="text-gray-700">共有設定</span>
            </button>
            <button onclick="alert('この機能はまだ実装されていません'); toggleDropdown();" class="w-full text-left px-4 py-2.5 hover:bg-gray-50 transition flex items-center gap-2 border-t border-gray-100">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <span class="text-gray-700">エクスポート</span>
            </button>
        </div>
    </div>
</div>



<!-- タスクリスト -->
<div class="space-y-3">
    @forelse ($tasks ?? [] as $task)
    <div class="bg-white/90 backdrop-blur-sm rounded-lg p-4 flex items-start gap-3 hover:bg-white transition shadow-md">
        <input type="checkbox" class="w-5 h-5 mt-1 rounded border-gray-400 text-[#03588C] focus:ring-[#03588C] cursor-pointer">
        
        <div class="flex-1">
            <h3 class="font-medium text-gray-800">{{ $task->title }}</h3>
            @if($task->description)
            <p class="text-sm text-gray-600 mt-1">{{ $task->description }}</p>
            @endif
        </div>

        <a href="{{ route('tasks.edit', $task->id) }}" class="text-gray-500 hover:text-[#03588C] transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
    @empty
    <div class="text-center py-20 bg-white/80 backdrop-blur-sm rounded-lg">
        <p class="text-gray-600 text-lg">ToDoはありません</p>
    </div>
    @endforelse
</div>

<!-- モーダル: 新規リスト作成 -->
<div id="createListModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96 shadow-xl">
        <h2 class="text-xl font-bold mb-4 text-gray-800">新しいリストを作成</h2>
        <form action="{{ route('lists.store') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="リスト名を入力" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:ring-2 focus:ring-[#03588C]" required>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-[#03588C] text-white py-2 rounded-lg hover:bg-[#024d73] transition">作成</button>
                <button type="button" onclick="closeCreateListModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition">キャンセル</button>
            </div>
        </form>
    </div>
</div>

<!-- モーダル: リスト名変更 -->
<div id="editListModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96 shadow-xl">
        <h2 class="text-xl font-bold mb-4 text-gray-800">リスト名を変更</h2>
        <form action="{{ route('lists.update', $currentListId ?? 1) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="name" value="{{ $currentListName ?? 'やること' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:ring-2 focus:ring-[#03588C]" required>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-[#03588C] text-white py-2 rounded-lg hover:bg-[#024d73] transition">変更</button>
                <button type="button" onclick="closeEditListModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition">キャンセル</button>
            </div>
        </form>
    </div>
</div>

<script>
    // 新規リスト作成モーダル
    function openCreateListModal() {
        document.getElementById('createListModal').classList.remove('hidden');
    }
    function closeCreateListModal() {
        document.getElementById('createListModal').classList.add('hidden');
    }

    // リスト名変更モーダル
    function openEditListModal() {
        document.getElementById('editListModal').classList.remove('hidden');
    }
    function closeEditListModal() {
        document.getElementById('editListModal').classList.add('hidden');
    }

    // ドロップダウンメニュー（追加）
    function toggleDropdown() {
        document.getElementById('dropdownMenu').classList.toggle('hidden');
    }

    function openRenameListModal() {
        openEditListModal(); // 既存の関数を使う
        toggleDropdown(); // ドロップダウンを閉じる
    }

    // モーダル外クリックで閉じる
    document.getElementById('createListModal').addEventListener('click', (e) => {
        if (e.target === e.currentTarget) closeCreateListModal();
    });
    document.getElementById('editListModal').addEventListener('click', (e) => {
        if (e.target === e.currentTarget) closeEditListModal();
    });

    // ドロップダウンの外側クリックで閉じる
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdownMenu');
        const button = event.target.closest('button[onclick*="toggleDropdown"]');
        
        if (dropdown && !dropdown.contains(event.target) && !button) {
            dropdown.classList.add('hidden');
        }
    });
</script>
@endsection