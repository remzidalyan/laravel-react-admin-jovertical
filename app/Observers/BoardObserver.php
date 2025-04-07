<?php

namespace App\Observers;

use App\Board as Model;
use Illuminate\Support\Str;

class BoardObserver
{
    public function updating(Model $model): void
    {
        if ($model->getOriginal('name') !== $model->getAttribute('name')) {
            $model->name = Str::trUppercaseWords(Str::cleanSpaces($model->name));
        }
    }
}
