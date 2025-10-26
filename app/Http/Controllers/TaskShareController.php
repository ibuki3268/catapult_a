<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;

class TaskShareController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, User $user)
    {
        // 共有相手が自分でないかチェック
        if (auth()->id() === $user->id) {
        return response()->json(['error' => '自分自身を共有相手には追加できません。'], 400);
    }

        // タスクの共有相手の追加を行う
        auth()->user()->sharedUsers()->attach($user->id);

        return response()->json(['message' => 'メンバーが正常に追加されました。']);
    }

    /**
     * メールアドレスで共有相手となるユーザーを検索するAPI
     */
    public function search(Request $request, string $email)
    {
        try {
            // ユーザーの検索
            $user = User::where('email', $email)->first();
    
            
            if (!$user) {
                // ユーザーが見つからない場合
                return response()->json([
                    'error' => '指定されたメールアドレスのユーザーは見つかりませんでした。'
                ], 404); 
            }
    
       
            if (auth()->check() && auth()->id() === $user->id) {
                return response()->json([
                    'error' => '自分自身を共有相手には追加できません。'
                ], 400);
            }
    
            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
        } catch (\Exception $e) {
            // エラーハンドリング
            return response()->json([
                'error' => 'サーバーエラーが発生しました。'
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        auth()->user()->sharedUsers()->detach($user->id);
        return redirect()->route('shared.members');
    }
}
    