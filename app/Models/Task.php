<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['translated_status', 'status_label'];
    const STATUS_HOLD = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELLED = 3;

    const STATUSES = [
        self::STATUS_HOLD => 'hold',
        self::STATUS_IN_PROGRESS => 'in_progress',
        self::STATUS_COMPLETED => 'completed',
        self::STATUS_CANCELLED => 'cancelled',
    ];

    /**
     * Get the status label for the task
     * @return string
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status];
    }

    /**
     * Get the status label for the task
     * @return string
     */
    public function getTranslatedStatusAttribute(): string
    {
        return __(self::STATUSES[$this->status]);
    }

    /**
     * Get the user that owns the Task
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
