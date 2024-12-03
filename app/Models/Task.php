<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $author_id
 * @property int $reader_user_id
 * @property string $title
 * @property string $status
 * @property string $text
 * @property string $deadline_date
 * @property-read User $author
 * @property-read User $reader
 * @method static TaskFactory factory($count = null, $state = [])
 * @method static Builder<static>|Task id(int $id)
 * @method static Builder<static>|Task newModelQuery()
 * @method static Builder<static>|Task newQuery()
 * @method static Builder<static>|Task query()
 * @method static Builder<static>|Task whereAuthorId($value)
 * @method static Builder<static>|Task whereCreatedAt($value)
 * @method static Builder<static>|Task whereDeadlineDate($value)
 * @method static Builder<static>|Task whereId($value)
 * @method static Builder<static>|Task whereReaderUserId($value)
 * @method static Builder<static>|Task whereStatus($value)
 * @method static Builder<static>|Task whereText($value)
 * @method static Builder<static>|Task whereTitle($value)
 * @method static Builder<static>|Task whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Task extends Model
{
    use HasFactory;

    /**
     * @var string[]
     *
     * Fillable field for create or update by ORM
     *
     */
    protected $fillable = [
        'author_id',
        'reader_user_id',
        'title',
        'status',
        'text',
        'deadline_date',
    ];

    /**
     * @var string[]
     *
     * Types for fields
     */
    protected $casts = [
        'author_id' => 'integer',
        'reader_user_id' => 'integer',
        'title' => 'string',
        'status' => 'string',
        'text' => 'string',
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
