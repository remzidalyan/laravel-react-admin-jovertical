<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTaskStatusesTable extends Migration
{
    protected $connection = 'laravel-react-admin';
    protected $table = 'task_statuses';
    protected $columns = ['id', 'name'];
    protected $data = [
        [1, 'Pending'],
        [2, 'In Progress'],
        [3, 'Completed']
    ];

    public function up()
    {
        Schema::connection($this->getConnection())->create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
        });

        $this->seed();
    }

    protected function seed(): void
    {
        $columns = collect($this->columns);
        $chunks = collect($this->data)->map(function ($item) use ($columns) {
            return $columns->combine($item)->toArray();
        })->chunk(1000);

        foreach ($chunks as $chunk) {
            DB::connection($this->getConnection())->table($this->table)->insert($chunk->toArray());
        }
    }

    public function down()
    {
        Schema::connection($this->getConnection())->dropIfExists($this->table);
    }
}
