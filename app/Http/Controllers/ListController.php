<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    // リスト作成
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|max:255',
        ]);

        // リスト作成
        TaskList::create([
            'name' => $request->name,
            'user_id' => Auth::id()??1,  // ログインユーザーのID
        ]);

        return redirect()->route('tasks.index')->with('success', 'リストを作成しました');
    }

    // リスト名変更
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|max:255',
        ]);

        // リストを取得
        $list = TaskList::findOrFail($id);

        // 自分のリストか確認
        if ($list->user_id !== Auth::id()) {
            abort(403, '権限がありません');
        }

        // リスト名を更新
        $list->update([
            'name' => $request->name,
        ]);

        return redirect()->route('tasks.index')->with('success', 'リスト名を変更しました');
    }

    // リスト削除
    public function destroy($id)
{
    // リストを取得
    $list = TaskList::findOrFail($id);

    // 自分のリストか確認（nullの場合は1として扱う）
    $userId = Auth::id() ?? 1;
    if ($list->user_id !== $userId) {
        abort(403, '権限がありません');
    }

    // リスト削除
    $list->delete();

    return redirect()->route('tasks.index')->with('success', 'リストを削除しました');
}
}