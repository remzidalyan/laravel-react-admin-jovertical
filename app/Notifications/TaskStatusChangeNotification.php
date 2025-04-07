<?php

namespace App\Notifications;

use App\Task as Model;
use App\TaskStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskStatusChangeNotification extends Notification
{
    use Queueable;

    protected $task;
    protected $oldStatus;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Model $task, $oldStatus)
    {
        $this->task = $task;
        $this->oldStatus = $oldStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $oldStatus = TaskStatus::findOrFail($this->oldStatus);
        $newStatus = TaskStatus::findOrFail($this->task->status);

        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'task_description' => $this->task->description,
            'task_status_id' => $this->task->task_status_id,
            'start_date' => $this->task->start_date,
            'due_date' => $this->task->due_date,
            'message' => "Task status changed from {$oldStatus->name} to {$newStatus->name}",
        ];
    }
}
