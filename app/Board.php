<?php

namespace App;

use App\Observers\BoardObserver as Observer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use SoftDeletes;

    protected $table = 'boards';

    protected $fillable = [
        'name'
    ];

    public static function boot(): void
    {
        parent::boot();

        parent::observe(Observer::class);
    }
}
