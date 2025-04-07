<?php

use App\Board;
use Illuminate\Database\Seeder;

class BoardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $board = new Board;
        $board->name = 'Task Board';
        $board->save();
    }
}
