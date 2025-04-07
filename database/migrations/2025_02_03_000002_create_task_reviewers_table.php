<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskReviewersTable extends Migration
{
    protected $connection = 'laravel-react-admin';
    protected $table = 'task_reviewers';

    public function up()
    {
        Schema::connection($this->getConnection())->create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('task_id');
            $table->unsignedInteger('user_id');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            // Add unique constraint to prevent duplicate reviewers
            $table->unique(['task_id', 'user_id'], 'unique_task_user_reviewer');
        });

        // Add foreign key constraints
        Schema::connection($this->getConnection())->table($this->table, function (Blueprint $table) {
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Drop foreign key constraints
        Schema::connection($this->getConnection())->table($this->table, function (Blueprint $table) {
            $table->dropForeign(['task_id']);
            $table->dropForeign(['user_id']);
            $table->dropUnique('unique_task_user_reviewer');
        });

        Schema::connection($this->getConnection())->dropIfExists($this->table);
    }
}
