<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'board_id' => ['nullable', 'int', 'exists:App\Board,id'],
            'task_status_id' => ['nullable', 'int', 'exists:App\TaskStatus,id'],
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date_format:Y-m-d H:i'],
            'due_date' => ['nullable', 'date_format:Y-m-d H:i', 'after_or_equal:start_date'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'board_id' => $this->route('board_id', 1),
            'task_status_id' => $this->route('task_status_id', 1),
        ]);
    }
}
