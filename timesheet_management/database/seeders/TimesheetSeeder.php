<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimesheetSeeder extends Seeder
{
    public function run()
    {
        DB::table('timesheets')->insert([
            [
                'task_name' => 'Design Database',
                'date' => '2024-03-01',
                'hours' => 8,
                'user_id' => 1,
                'project_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'task_name' => 'Develop API',
                'date' => '2024-03-02',
                'hours' => 6,
                'user_id' => 1,
                'project_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'task_name' => 'Create Marketing Strategy',
                'date' => '2024-04-01',
                'hours' => 5,
                'user_id' => 2,
                'project_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
