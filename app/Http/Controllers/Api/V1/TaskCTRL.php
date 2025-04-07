<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TaskRequest;
use App\Task as Model;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TaskCTRL extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 10);
        $sortBy = $request->get('sortBy', 'id');
        $sortType = $request->get('sortType', 'asc');

        $cacheKey = "tasks_{$perPage}_{$sortBy}_{$sortType}";

        $tasks = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($sortBy, $sortType, $perPage) {
            return Model::withTrashed()->with('task_status')->orderBy($sortBy, $sortType)->paginate($perPage);
        });

        return response()->json([
            'success' => true,
            'message' => 'Task index',
            'data' => $tasks,
        ]);
    }

    public function getAll(): JsonResponse
    {
        $tasks = Model::with([
            'task_status',
            'board',
            'user',
            'task_reviewers'
        ])->get();

        return response()->json([
            'success' => true,
            'message' => 'Task index',
            'data' => $tasks,
        ]);
    }

    public function show($id): JsonResponse
    {
        $task = Model::with([
            'task_status',
            'board',
            'user',
            'task_reviewers'
        ])->findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Task show',
            'data' => $task,
        ]);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $task = new Model();
        $task->fill($request->toArray());
        $task->user_id = auth()->user()->id;
        $task->start_date = $request->input('start_date') ? (Carbon::parse($request->input('start_date'))->format('Y-m-d H:i:s')) : null;
        $task->due_date = $request->input('due_date') ? (Carbon::parse($request->input('due_date'))->format('Y-m-d H:i:s')) : null;
        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Task created',
            'data' => $task,
        ]);
    }

    public function update(TaskRequest $request, $id): JsonResponse
    {
        $task = Model::findOrFail($id);
        $task->fill($request->toArray());
        $task->user_id = auth()->user()->id;
        $task->start_date = $request->input('start_date') ? (Carbon::parse($request->input('start_date'))->format('Y-m-d H:i:s')) : null;
        $task->due_date = $request->input('due_date') ? (Carbon::parse($request->input('due_date'))->format('Y-m-d H:i:s')) : null;
        $task->update();

        return response()->json([
            'success' => true,
            'message' => 'Task updated',
            'data' => $task,
        ]);
    }

    /**
     * @throws Exception
     */
    public function destroy($id): JsonResponse
    {
        $task = Model::withTrashed()->findOrFail($id);

        if (request()->input('is_recovery') === 'true') {
            $task->restore();
            return response()->json([
                'success' => true,
                'message' => 'Task restored',
                'data' => $task,
            ]);
        }

        $task->delete();
        return response()->json([
            'success' => true,
            'message' => 'Task deleted',
            'data' => null,
        ]);
    }

    public function statusChange($id, Request $request): JsonResponse
    {
        $request->validate([
            'status_id' => 'required|int|exists:task_statuses,id',
        ]);

        $task = Model::findOrFail($id);
        $task->task_status_id = $request->input('status_id');
        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Task status changed',
            'data' => $task,
        ]);
    }
}
