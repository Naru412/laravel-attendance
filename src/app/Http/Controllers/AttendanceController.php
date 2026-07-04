<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\BreakTime;
use App\Http\Requests\AttendanceUpdateRequest;
use App\Models\AttendanceCorrection;
use App\Models\BreakCorrection;


class AttendanceController extends Controller
{
    //日時ステータス表示
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

    //出勤
    public function clockIn()
    {
        Attendance::create([
            'user_id' => auth()->id(),
            'work_date' => now()->toDateString(),
            'clock_in' => now(),
        ]);
        return redirect('/attendance');
    }

    //休憩入り
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

    //休憩戻
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

    //退勤
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

    //勤怠一覧
    public function list()
    {
        $attendances = Attendance::where('user_id', auth()->id())
            ->orderBy('work_date', 'desc')
            ->get();

        return view('attendance.list', compact('attendances'));
    }

    //詳細画面
    public function show($id)
    {
        $attendance = Attendance::findOrFail($id);
        
        return view('attendance.detail',compact('attendance'));
    }

    //出勤退勤更新
    public function update(AttendanceUpdateRequest $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendanceCorrection = AttendanceCorrection::create([
            'user_id' => auth()->id(),
            'attendance_id' => $attendance->id,
            'requested_clock_in' => $attendance->work_date . ' ' . $request->clock_in,
            'requested_clock_out' => $attendance->work_date . ' ' . $request->clock_out,
            'remarks' => $request->remark,
            'status' => 'pending',
        ]);

        /* $attendance->update([
            'clock_in' => $attendance->work_date . ' ' . $request->clock_in,
            'clock_out' => $attendance->work_date . ' ' . $request->clock_out,
        ]);
 */
        //休憩更新
        foreach ($request->break_starts as $index => $breakStart) {

            $breakEnd = $request->break_ends[$index];

            if ($breakStart && $breakEnd) {
                BreakCorrection::create([
                    'attendance_correction_id' => $attendanceCorrection->id,
                    'break_id' => $request->break_ids[$index] ?: null,
                    'requested_break_start' => $attendance->work_date . ' ' . $breakStart,
                    'requested_break_end' => $attendance->work_date . ' ' . $breakEnd,
                ]);
            }

            /* $break->update([
                'break_start' => $attendance->work_date . ' ' . $request->break_starts[$index],
                'break_end' => $attendance->work_date . ' ' . $request->break_ends[$index],
            ]); */
        }
        
        return redirect('/attendance/' .$id);
    }

    //申請一覧
    public function requestList(Request $request)
    {
        $status = $request->query('status', 'pending');

        $corrections = AttendanceCorrection::where('user_id', auth()->id())
            ->where('status', $status)
            ->get();

        return view('attendance.request_list', compact('corrections', 'status'));
    }

    //申請詳細
    public function requestDetail($id)
    {
        $correction = AttendanceCorrection::findOrFail($id);

        return view('attendance.request_detail', compact('correction'));
    }

    //管理者一覧
    public function adminList()
    {
        return view('admin.attendance_list');
    }
}