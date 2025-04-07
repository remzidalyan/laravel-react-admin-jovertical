<?php

namespace App\Observers;

use App\Notifications\TaskStatusChangeNotification;
use App\Task as Model;
use Illuminate\Support\Facades\Cache;


class TaskObserver
{
    public function saving(Model $model)
    {
        Cache::forget('tasks');

        //task-status-id change
        if ($model->isDirty('task_status_id')) {
            $oldStatusId = $model->getOriginal('task_status_id');
            $newStatusId = $model->getAttribute('task_status_id');

            if ($oldStatusId !== null && $newStatusId !== null) {
                $model->user->notify(new TaskStatusChangeNotification($model, $oldStatusId));

                $model->task_reviewers->each(function ($reviewer) use ($model, $oldStatusId) {
                    $reviewer->notify(new TaskStatusChangeNotification($model, $oldStatusId));
                });
            }

        }
    }
}
