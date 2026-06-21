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

    public function list()
    {
        $attendances = Attendance::where('user_id', auth()->id())
            ->orderBy('work_date', 'desc')
            ->get();

        return view('attendance.list', compact('attendances'));
    }

    public function show($id)
    {
        $attendance = Attendance::findOrFail($id);
        
        return view('attendance.detail',compact('attendance'));
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendance->update([
            'clock_in' => $attendance->work_date . ' ' . $request->clock_in,
            'clock_out' => $attendance->work_date . ' ' . $request->clock_out,
        ]);

        //休憩更新
        foreach ($request->break_ids as $index => $breakId) {

            $break = BreakTime::findOrFail($breakId);

            $break->update([
                'break_start' => $attendance->work_date . ' ' . $request->break_starts[$index],
                'break_end' => $attendance->work_date . ' ' . $request->break_ends[$index],
            ]);
        }
        
        return redirect('/attendance/' .$id);
    }
}