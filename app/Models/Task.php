<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}