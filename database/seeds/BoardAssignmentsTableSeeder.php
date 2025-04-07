<?php

use App\Board;
use App\BoardAssignment;
use App\User;
use Illuminate\Database\Seeder;

class BoardAssignmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $board = Board::first();

        if ($board === null) {
            $this->command->error('No boards found. Please run the BoardsTableSeeder first.');
            return;
        }

        $users = User::all();

        foreach ($users as $user) {
            $boardAssignment = new BoardAssignment;
            $boardAssignment->user_id = $user->id;
            $boardAssignment->board_id = $board->id;
            $boardAssignment->save();
        }

    }
}
