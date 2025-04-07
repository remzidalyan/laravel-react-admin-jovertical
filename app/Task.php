<?php

namespace App;

use App\Observers\TaskObserver as Observer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $table = 'laravel-react-admin.tasks';

    protected $fillable = [
        'board_id',
        'task_status_id',
        'user_id',

        'title',
        'description',
        'start_date',
        'due_date',
    ];

    public static function boot(): void
    {
        parent::boot();

        parent::observe(Observer::class);
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function task_status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function task_reviewers(): HasMany
    {
        return $this->hasMany(TaskReviewer::class);
    }
}
