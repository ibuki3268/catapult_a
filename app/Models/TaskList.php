<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskList extends Model
{
    protected $table = 'lists';  // テーブル名を指定

    protected $fillable = [
        'name',
        'user_id',
    ];

    // リレーション: このリストは1人のユーザーに属する
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // リレーション: このリストは複数のタスクを持つ
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'list_id');
    }
}