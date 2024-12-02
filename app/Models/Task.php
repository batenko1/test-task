<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'reader_user_id',
        'title',
        'status',
        'text',
        'created_at',
        'deadline_date',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'deadline' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reader_user_id');
    }
}
