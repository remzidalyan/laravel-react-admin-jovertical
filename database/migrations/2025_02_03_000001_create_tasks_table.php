<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    protected $connection = 'laravel-react-admin';
    protected $table = 'tasks';

    public function up()
    {
        Schema::connection($this->getConnection())->create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('board_id');
            $table->unsignedBigInteger('task_status_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('due_date')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
        });

        // Add foreign key constraints
        Schema::connection($this->getConnection())->table($this->table, function (Blueprint $table) {
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->foreign('task_status_id')->references('id')->on('task_statuses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        // Drop foreign key constraints
        Schema::connection($this->getConnection())->table($this->table, function (Blueprint $table) {
            $table->dropForeign(['board_id']);
            $table->dropForeign(['task_status_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::connection($this->getConnection())->dropIfExists($this->table);
    }
}
