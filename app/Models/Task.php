<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class Task extends Model
{
    use HasFactory;

    /**
     * @var string[]
     *
     */
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

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime',
        'deadline' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     *
     * Relation Author by User
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * @return BelongsTo
     *
     * Relation Reader by User
     */
    public function reader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reader_user_id');
    }

    /**
     * @param Builder $builder
     * @param int $id
     * @return Builder
     *
     * Find by id scope
     */
    public function scopeId(Builder $builder, int $id): Builder
    {
        return $builder->whereId($id);
    }
}
