<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BreakTime;

class BreakTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BreakTime::create([
            'attendance_id' => 1,
            'break_start' => '2026-06-01 12:00:00',
            'break_end' => '2026-06-01 13:00:00',
        ]);
    }
}
