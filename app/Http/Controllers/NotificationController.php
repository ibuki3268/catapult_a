<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    private function currentUserId(): int
    {
        $id = Auth::id();
        if ($id) {
            return $id;
        }

        $user = \App\Models\User::first();
        return $user ? $user->id : 1;
    }

    // 通知一覧を取得
    public function index()
    {
        $userId = $this->currentUserId();

        $notifications = Notification::where('user_id', $userId)
                                     ->orderBy('created_at', 'desc')
                                     ->limit(20)
                                     ->get();

        $unreadCount = Notification::where('user_id', $userId)
                                   ->where('is_read', false)
                                   ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    // 既読にする
    public function markAsRead($id)
    {
        $userId = $this->currentUserId();

        $notification = Notification::where('id', $id)
                                    ->where('user_id', $userId)
                                    ->first();

        if ($notification) {
            $notification->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }
}