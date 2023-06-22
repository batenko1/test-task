<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'body', 'user_id', 'days', 'date_end', 'executor_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function executor() {
        return $this->belongsTo(User::class, 'executor_id');
    }
}
