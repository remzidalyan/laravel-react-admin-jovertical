<?php

namespace App\Jobs;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TaskStartJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $tasks = Task::whereDate('start_date', '<=', now())->where('task_status_id', 1)->get();
            $tasks->each(function ($task) {
                $task->update(['task_status_id' => 2]);
            });

            Log::info('TaskStartJob executed successfully.');

        } catch (\Exception $e) {
            // Handle any exceptions that may occur during the task execution
            Log::error('TaskStartJob failed: ' . $e->getMessage());
        }
    }
}
