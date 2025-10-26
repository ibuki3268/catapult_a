<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'done',
        'deadline',
        'priority',
        'deadline_notified_at',
    ];

    protected $casts = [
        'done' => 'boolean',
        'deadline' => 'date',
        'priority' => 'integer',
        'deadline_notified_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    // タスクを共有されているユーザーを取得
    public function sharedWithUsers()
    {
        return $this->belongsToMany(
            User::class, 
            'task_share', 
            'user_id', 
            'shared_user_id'
            );

    }

    // // 指定したユーザーが見えるタスクを取得するスコープ
    // public function scopeVisibleTo($query, $userId)
    // {
    //     return $query->where('user_id', $userId) // 1. 自分が作成したタスク
    //                 ->orWhereHas('sharedWithUsers', function ($q) use ($userId) {
    //                     // 2. 自分が共有されているタスク (sharedWithUsersリレーションのフィルター)
    //                     $q->where('shared_with_user_id', $userId);
    //                 });
    // }
}