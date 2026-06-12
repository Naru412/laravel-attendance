<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\BreakTime;


class AttendanceController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();

        $break = null;
        
        if ($attendance) {
            $break = BreakTime::where('attendance_id', $attendance->id)
                ->whereNull('break_end')
                ->first();
        }

        if (!$attendance) {
            $status = '勤務外';
        }   elseif ($break) {
            $status = '休憩中';
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

    public function breakIn()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();

        BreakTime::create([
            'attendance_id' => $attendance->id, 
            'break_start' => now(),
        ]);
        return redirect('/attendance');
    }

    public function breakOut()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();

        $break = BreakTime::where('attendance_id', $attendance->id)
            ->whereNull('break_end')
            ->first();
            
        $break->update([
            'break_end' => now(),
        ]);

        return redirect('/attendance');
    }

    public function clockOut()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();

        $attendance->update([
            'clock_out' => now(),
        ]);
        
        return redirect('/attendance')
            ->with('message', 'お疲れさまでした。');
    }
}
