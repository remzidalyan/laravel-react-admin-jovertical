<?php

namespace App;

use App\Observers\TaskStatusObserver as Observer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskStatus extends Model
{
    use SoftDeletes;

    protected $table = 'laravel-react-admin.task_statuses';

    protected $fillable = [
        'name'
    ];

    public static function boot(): void
    {
        parent::boot();

        parent::observe(Observer::class);
    }
}
