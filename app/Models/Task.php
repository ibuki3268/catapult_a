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
    ];

    protected $casts = [
        'done' => 'boolean',
        'deadline' => 'date',
        'priority' => 'integer',
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
            'task_id', 
            'shared_with_user_id'
            )->withPivot('premission');

    }

    // 指定したユーザーが見えるタスクを取得するスコープ
    public function scopeVisibleTo($query, $userId)
    {
        return $query->where('user_id', $userId) // 1. 自分が作成したタスク
                    ->orWhereHas('sharedWithUsers', function ($q) use ($userId) {
                        // 2. 自分が共有されているタスク (sharedWithUsersリレーションのフィルター)
                        $q->where('shared_with_user_id', $userId);
                    });
    }
}