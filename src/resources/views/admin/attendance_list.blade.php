@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_attendance_list.css') }}">
@endsection

@section('content')
<main class="attendance-list">
    <h2>{{ \Carbon\Carbon::parse($date)->format('Y年n月j日') }}の勤怠</h2>

    <div class="month-nav">
        <a href="">← 前月</a>
        <p>2023/06</p>
        <a href="">翌月 →</a>
    </div>

    <table class="attendance-table">
        <tr>
            <th>名前</th>
            <th>出勤</th>
            <th>退勤</th>
            <th>休憩</th>
            <th>合計</th>
            <th>詳細</th>
        </tr>

        @foreach($attendance as $attendance)
        <tr>
            <td>{{ $attendance->user->name }}</td>
            <td>{{ \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') }}</td>
            <td>{{ \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') }}</td>
            <td>
                @php
                    $breakMinutes = 0;

                    foreach ($attendance->breaks as $break) {
                        if ($break->break_start && $break->break_end) {
                            $breakMinutes += \Carbon\Carbon::parse($break->break_start)
                                ->diffInMinutes(\Carbon\Carbon::parse($break->break_end)); 
                        }
                    }

                    $breakHours = floor($breakMinutes /60);
                    $breakMinute = $breakMinutes % 60;
                @endphp

                @if ($breakMinutes > 0)
                    {{ sprintf('%02d:%02d', $breakHours, $breakMinute) }}
                @endif
            </td>
            <td>
                @if($attendance->clock_in && $attendance->clock_out)
                    @php
                        $workMinutes = \Carbon\Carbon::parse($attendance->clock_in)
                            ->diffInMinutes(\Carbon\Carbon::parse($attendance->clock_out));

                        $totalMinutes = $workMinutes - $breakMinutes;
                        $hours = floor($totalMinutes / 60);
                        $minutes = $totalMinutes % 60;
                    @endphp

                    {{ sprintf('%02d:%02d', $hours, $minutes) }}
                @endif
            </td>
            <td>詳細</td>
        </tr>
        @endforeach
    </table>
</main>
@endsection

