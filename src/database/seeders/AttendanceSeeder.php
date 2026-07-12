<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
        {
            $user = User::where('email', 'user1@example.com')->firstOrFail();
            //過去５か月
            for ($monthOffset = 5; $monthOffset >= 1; $monthOffset--) {
                $date = Carbon::now()
                ->subMonths($monthOffset)
                ->startOfMonth();

                $createdCount = 0;

                while ($createdCount < 15) {
                    if ($date->isWeekday()) {
                        Attendance::create([
                            'user_id' => $user->id,
                            'work_date' => $date->toDateString(),
                            'clock_in' => $date->copy()->setTime(9, 0),
                            'clock_out' => $date->copy()->setTime(18, 0),
                        ]);
                        $createdCount++;
                    }
                    $date->addDay();
                }
            }

            //当月１７日分
            $date = Carbon::now()->startOfMonth();
            $createdCount = 0;

            while ($createdCount < 17) {
                if ($date->isWeekday()) {
                    if ($createdCount < 10) {
                        //通常勤務１０日
                        $clockInHour = 9;
                        $clockInMinute = 0;
                        $clockOutHour = 18;
                        $clockOutMinute = 0;
                    } elseif ($createdCount < 13) {
                        //残業３日
                        $clockInHour = 9;
                        $clockInMinute = 0;
                        $clockOutHour = 20;
                        $clockOutMinute = 0;
                    } elseif ($createdCount < 15) {
                        //遅刻２日
                        $clockInHour = 9;
                        $clockInMinute = 30;
                        $clockOutHour = 18;
                        $clockOutMinute = 0;
                    } elseif ($createdCount < 16) {
                        //早退１日
                        $clockInHour = 9;
                        $clockInMinute = 0;
                        $clockOutHour = 17;
                        $clockOutMinute = 0;
                    } else {
                        //長時間労働
                        $clockInHour = 8;
                        $clockInMinute = 0;
                        $clockOutHour = 21;
                        $clockOutMinute = 0;
                    }

                    Attendance::create([
                        'user_id' => $user->id,
                        'work_date' => $date->toDateString(),
                        'clock_in' => $date->copy()->setTime($clockInHour, $clockInMinute),
                        'clock_out' => $date->copy()->setTime($clockOutHour, $clockOutMinute),
                    ]);

                    $createdCount++;
                }
                $date->addDay();
            }
        }
    }
    