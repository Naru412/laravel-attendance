<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\BreakTime;
use Carbon\Carbon;

class BreakTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attendances = Attendance::all();

        foreach ($attendances as $attendance) {
            $workDate = Carbon::parse($attendance->work_date);

            BreakTime::create([
                'attendance_id' => $attendance->id,
                'break_start' => $workDate->copy()->setTime(12, 0),
                'break_end' => $workDate->copy()->setTime(13,0),
            ]);
        }
    }
}
