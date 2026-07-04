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
            <td></td>
            <td></td>
            <td>詳細</td>
        </tr>
        @endforeach
    </table>
</main>
@endsection

