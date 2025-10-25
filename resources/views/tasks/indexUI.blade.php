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
<div class="flex justify-end gap-4 mb-4 text-sm relative">
    <!-- 編集ボタン -->
    <button onclick="toggleEditMode()" id="editModeBtn" class="flex items-center gap-1 bg-white/80 backdrop-blur-sm px-3 py-1.5 rounded-lg hover:bg-white transition cursor-pointer">
    <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
    <span class="text-gray-700" id="editModeText">編集</span>
    </button>
    <!-- その他ボタン(メニュー付き) -->
    <div class="relative z-50">
        <button onclick="toggleOtherMenu()" id="otherMenuBtn" class="flex items-center gap-1 bg-white/80 backdrop-blur-sm px-3 py-1.5 rounded-lg hover:bg-white transition cursor-pointer">
            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
            </svg>
            <span class="text-gray-700">その他</span>
        </button>
        <!-- その他メニュー -->
        <div id="otherMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-[100]">
            <ul class="py-2">
                <li>
                    <button onclick="openEditListModal(); toggleOtherMenu();" class="w-full text-left px-4 py-2 hover:bg-gray-100 transition flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        <span class="text-gray-700">リスト名変更</span>
                    </button>
                </li>
                <li>
                    <!-- 変更後 -->
                <form action="{{ route('lists.destroy', $currentListId ?? 1) }}" method="POST" onsubmit="return confirm('このリストを削除しますか？リスト内のタスクもすべて削除されます。');">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 transition flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span class="text-red-600">リスト削除</span>
                    </button>
                </form>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- タスクリスト -->
<div class="space-y-3">
    @forelse ($tasks ?? [] as $task)
    <div class="bg-white/90 backdrop-blur-sm rounded-lg p-4 flex items-start gap-3 hover:bg-white transition shadow-md">
        <!-- 完了チェックボックス（通常時） -->
        <input type="checkbox"
            class="w-5 h-5 mt-1 rounded border-gray-400 text-[#03588C] focus:ring-[#03588C] cursor-pointer task-done-checkbox"
            data-task-id="{{ $task->id }}"
            @if($task->done) checked @endif
        >
        
        <!-- 選択チェックボックス（編集モード時・非表示） -->
        <input type="checkbox"
            class="w-5 h-5 mt-1 rounded border-gray-400 text-[#03588C] focus:ring-[#03588C] cursor-pointer task-select-checkbox hidden"
            data-task-id="{{ $task->id }}"
        >
        
        <div class="flex-1">
            <h3 class="font-medium text-gray-800">{{ $task->title }}</h3>
            @if($task->description)
            <p class="text-sm text-gray-600 mt-1">{{ $task->description }}</p>
            @endif
            @if($task->deadline)
            @php
                $deadline = $task->deadline;
            @endphp
            <p class="text-sm mt-2">
                @if(!$task->done && $deadline->isPast())
                    <span class="text-red-600 font-semibold">期限切れ: {{ $deadline->format('Y/m/d') }}</span>
                @else
                    <span class="text-gray-500">期限: {{ $deadline->format('Y/m/d') }}</span>
                @endif
            </p>
            @endif
        </div>
        <a href="{{ route('tasks.edit', $task->id) }}" class="text-gray-500 hover:text-[#03588C] transition task-edit-link">
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

<!-- 一括操作バー（編集モード時のみ表示） -->
<div id="bulkActionBar" class="hidden fixed bottom-24 left-0 right-0 bg-white border-t border-gray-200 shadow-lg p-4 z-[70]">
    <div class="max-w-screen-xl mx-auto flex justify-between items-center">
        <span class="text-gray-700 font-semibold"><span id="selectedCount">0</span>件選択中</span>
        <div class="flex gap-3">
            <button onclick="bulkComplete()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition">完了にする</button>
            <button onclick="bulkDelete()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">削除</button>
        </div>
    </div>
</div>
<!-- モーダル: 新規リスト作成 -->
<div id="createListModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96 shadow-xl">
        <h2 class="text-xl font-bold mb-4 text-gray-800">新しいリストを作成</h2>
        <form action="{{ route('lists.store') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="リスト名を入力" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:ring-2 focus:ring-[#03588C]" required>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-[#03588C] text-white py-2 rounded-lg hover:bg-[#024D73] transition">作成</button>
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
            <input type="text" name="name" value="{{ $currentListName ?? 'やること' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:ring-2 focus:ring-[#03588C] text-gray-800" required>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-[#03588C] text-white py-2 rounded-lg hover:bg-[#024D73] transition">変更</button>
                <button type="button" onclick="closeEditListModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition">キャンセル</button>
            </div>
        </form>
    </div>
</div>
<script>
    let isEditMode = false;

// 編集モード切り替え
function toggleEditMode() {
    isEditMode = !isEditMode;
    const doneCheckboxes = document.querySelectorAll('.task-done-checkbox');
    const selectCheckboxes = document.querySelectorAll('.task-select-checkbox');
    const editLinks = document.querySelectorAll('.task-edit-link');
    const bulkActionBar = document.getElementById('bulkActionBar');
    const editModeText = document.getElementById('editModeText');
    
    if (isEditMode) {
        // 編集モードON
        doneCheckboxes.forEach(cb => cb.classList.add('hidden'));
        selectCheckboxes.forEach(cb => cb.classList.remove('hidden'));
        editLinks.forEach(link => link.classList.add('hidden'));
        bulkActionBar.classList.remove('hidden');
        editModeText.textContent = '完了';
    } else {
        // 編集モードOFF
        doneCheckboxes.forEach(cb => cb.classList.remove('hidden'));
        selectCheckboxes.forEach(cb => {
            cb.classList.add('hidden');
            cb.checked = false;
        });
        editLinks.forEach(link => link.classList.remove('hidden'));
        bulkActionBar.classList.add('hidden');
        editModeText.textContent = '編集';
        updateSelectedCount();
    }
}

// 選択数更新
function updateSelectedCount() {
    const count = document.querySelectorAll('.task-select-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = count;
}

// 一括完了
function bulkComplete() {
    const selectedIds = Array.from(document.querySelectorAll('.task-select-checkbox:checked'))
        .map(cb => cb.dataset.taskId);
    
    if (selectedIds.length === 0) {
        alert('タスクを選択してください');
        return;
    }
    
    if (!confirm(`${selectedIds.length}件のタスクを完了にしますか？`)) {
        return;
    }
    
    fetch('/tasks/bulk-complete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ task_ids: selectedIds })
    })
    .then(res => res.json())
    .then(data => {
        location.reload();
    })
    .catch(err => {
        alert('エラーが発生しました');
    });
    }

// 一括削除
function bulkDelete() {
    const selectedIds = Array.from(document.querySelectorAll('.task-select-checkbox:checked'))
        .map(cb => cb.dataset.taskId);
    
    if (selectedIds.length === 0) {
        alert('タスクを選択してください');
        return;
    }
    
    if (!confirm(`${selectedIds.length}件のタスクを削除しますか？`)) {
        return;
    }
    
    fetch('/tasks/bulk-delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ task_ids: selectedIds })
    })
    .then(res => res.json())
    .then(data => {
        location.reload();
    })
    .catch(err => {
        alert('エラーが発生しました');
    });
    }
    // タスクdoneトグル
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.task-done-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const taskId = this.dataset.taskId;
                const done = this.checked ? 1 : 0;
                fetch(`/tasks/${taskId}/toggle-done`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ done })
                })
                .then(res => {
                    if (!res.ok) throw new Error('更新に失敗しました');
                    return res.json();
                })
                .then(data => {
                    // 成功時は何もしない（UIは既に反映済み）
                })
                .catch(err => {
                    alert('更新に失敗しました');
                    this.checked = !this.checked; // 元に戻す
                });
            });
        });
    });

    // 選択チェックボックスの変更を監視
    document.querySelectorAll('.task-select-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectedCount);
    });
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
    // その他メニュー
    function toggleOtherMenu() {
        const menu = document.getElementById('otherMenu');
        menu.classList.toggle('hidden');
    }
    // メニュー外クリックで閉じる
    document.addEventListener('click', (e) => {
        const menu = document.getElementById('otherMenu');
        const btn = document.getElementById('otherMenuBtn');
        if (menu && !menu.contains(e.target) && !btn.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
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
<div class="fixed bottom-8 left-0 right-0 flex justify-between px-8 pointer-events-none z-[60]">
    <!-- ゴミ箱ボタン -->
    <a href="{{ route('tasks.deleteCompleted.view') }}"
       class="pointer-events-auto w-16 h-16 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition shadow-lg"
       onclick="return confirm('完了したタスクを削除しますか?');">
        <svg class="w-8 h-8 text-[#5BCCF8]" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="32" height="32" style="width:32px;height:32px" aria-hidden="true" focusable="false">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
    </a>
    <!-- プラスボタン -->
    <a href="{{ route('tasks.create', ['list_id' => $currentListId ?? null]) }}"
       class="pointer-events-auto w-16 h-16 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition shadow-lg">
        <svg class="w-8 h-8 text-[#5BCCF8]" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="32" height="32" style="width:32px;height:32px" aria-hidden="true" focusable="false">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
        </svg>
    </a>
</div>
