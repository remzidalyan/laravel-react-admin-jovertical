<?php

namespace App;

use App\Observers\BoardAssignmentObserver as Observer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardAssignment extends Model
{
    use SoftDeletes;

    protected $table = 'board_assignments';

    protected $fillable = [
        'user_id',
        'board_id'
    ];

    public static function boot(): void
    {
        parent::boot();

        parent::observe(Observer::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function board(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}
