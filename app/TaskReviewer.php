<?php

namespace App;

use App\Observers\TaskReviewerObserver as Observer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskReviewer extends Model
{
    protected $table = 'laravel-react-admin.task_reviewers';

    protected $fillable = [
        'user_id',
        'task_id'
    ];

    public static function boot(): void
    {
        parent::boot();

        parent::observe(Observer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
