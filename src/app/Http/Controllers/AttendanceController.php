<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();

        if (!$attendance) {
            $status = '勤務外';
        }   elseif ($attendance->clock_in && !$attendance->clock_out) {
            $status = '出勤中';
        }   else {
            $status = '退勤済';
        }      
        return view('attendance.index',compact('now', 'status'));
    }

    public function clockIn()
    {
        Attendance::create([
            'user_id' => auth()->id(),
            'work_date' => now()->toDateString(),
            'clock_in' => now(),
        ]);
        return redirect('/attendance');
    }
}
