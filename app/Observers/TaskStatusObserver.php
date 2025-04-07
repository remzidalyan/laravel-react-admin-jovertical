<?php

namespace App\Observers;

use App\TaskStatus as Model;
use Illuminate\Support\Str;

class TaskStatusObserver
{
    public function updating(Model $model): void
    {
        if ($model->getOriginal('name') !== $model->getAttribute('name')) {
            $model->name = Str::trUppercaseWords(Str::cleanSpaces($model->name));
        }
    }
}
