<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardAssignmentsTable extends Migration
{
    protected $connection = 'laravel-react-admin';
    protected $table = 'board_assignments';

    public function up()
    {
        Schema::connection($this->getConnection())->create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('board_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            // Add unique constraint to prevent duplicate assignments
            $table->unique(['board_id', 'user_id'], 'unique_board_user_assignment');
        });

        // Add foreign key constraints
        Schema::connection($this->getConnection())->table($this->table, function (Blueprint $table) {
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::connection($this->getConnection())->table($this->table, function (Blueprint $table) {
            $table->dropForeign(['board_id']);
            $table->dropForeign(['user_id']);
            $table->dropUnique('unique_board_user_assignment');
        });
        Schema::connection($this->getConnection())->dropIfExists($this->table);
    }
}
