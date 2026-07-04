@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance_list.css') }}">
@endsection

@section('content')
<main class="attendance-list">
    <h2>2023年6月1日の勤怠</h2>

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
    </table>
</main>
@endsection

