@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('content')
<main class="attendance-list">
    <h2>勤怠一覧</h2>

    <div class="month-nav">
        <a href="">← 前月</a>
        <p>2023/06</p>
        <a href="">翌月 →</a>
    </div>

    <table class="attendance-table">
        <tr>
            <th>日付</th>
            <th>出勤</th>
            <th>退勤</th>
            <th>休憩</th>
            <th>合計</th>
            <th>詳細</th>
        </tr>
        @foreach($attendances as $attendance)
        <tr>
            <td>{{ \Carbon\Carbon::parse($attendance->work_date)->locale('ja')->isoFormat('MM/DD/(ddd)') }}</td>
            <td>{{ \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') }}</td>
            <td>{{ \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') }}</td>
            <td>-</td>
            <td>-</td>
            <td><a href="">詳細</a></td>
        </tr>
        @endforeach
    </table>
</main>
@endsection

