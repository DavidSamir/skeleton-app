<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        DB::table('projects')->insert([
            [
                'name' => 'Project Alpha',
                'department' => 'Engineering',
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'status' => 'In Progress',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Project Beta',
                'department' => 'Marketing',
                'start_date' => '2024-02-01',
                'end_date' => '2024-12-31',
                'status' => 'Not Started',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
