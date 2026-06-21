@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<main class="attendance-detail">
    <h2>勤怠詳細</h2>

    <form action="/attendance/{{ $attendance->id }}" method="post">
        @csrf

        <table class="detail-table">
            <tr>
                <th>名前</th>
                <td>{{ $attendance->user->name }}</td>
            </tr>

            <tr>
                <th>日付</th>
                <td>
                    {{ \Carbon\Carbon::parse($attendance->work_date)->format('Y年') }}
                    {{ \Carbon\Carbon::parse($attendance->work_date)->format('n月j日') }}
                </td>
            </tr>

            <tr>
                <th>出勤・退勤</th>
                <td>
                    <input type="time" name="clock_in" value="{{ \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') }}">
                    ～
                    <input type="time" name="clock_out"  value="{{ \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') }}">
                </td>
            </tr>

            <tr>
                <th>休憩</th>
                <td>
                    @foreach($attendance->breaks as $break)
                        <input type="hidden" name="break_ids[]" value="{{ $break->id }}">
                        <input type="time" name="break_starts[]" value="{{ \Carbon\Carbon::parse($break->break_start)->format('H:i') }}">
                        ～
                        <input type="time" name="break_ends[]" value="{{ \Carbon\Carbon::parse($break->break_end)->format('H:i') }}">
                    @endforeach
                </td>
            </tr>

            <tr>
                <th>備考</th>
                <td>
                    <textarea></textarea>
                </td>
            </tr>
        </table>

        <div class="button-area">
            <button type="submit" class="update-btn">
                修正
            </button>
        </div>
    </form>
</main>
@endsection