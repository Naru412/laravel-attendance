<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attendance::create([
            'user_id' => 1,
            'work_date' => '2026-06-01',
            'clock_in' => '2026-06-01 09:00:00',
            'clock_out' => '2026-06-01 18:00:00',
        ]);
    }
}
