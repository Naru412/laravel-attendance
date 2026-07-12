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
                    <span class="date-year">
                        {{ \Carbon\Carbon::parse($attendance->work_date)->format('Y年') }}
                    </span>
                    <span class="date-day">
                        {{ \Carbon\Carbon::parse($attendance->work_date)->format('n月j日') }}
                    </span>
                </td>
            </tr>

            <tr>
                <th>出勤・退勤</th>
                <td>
                    <input class="time-input" type="time" name="clock_in" value="{{ old('clock_in', $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '') }}">
                    <span class="time-separator">～</span>
                    <input class="time-input" type="time" name="clock_out"  value="{{ old('clock_out', $attendance->clock_out ?  \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '') }}">

                    @error('clock_in')
                        <p class="error-message">{{ $message }}</p>
                    @enderror

                    @error('clock_out')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </td>
            </tr>

            @foreach($attendance->breaks as $index => $break)
            <tr>
                <th>
                    @if($index === 0)
                        休憩
                    @else
                        休憩{{ $index + 1 }}
                    @endif
                </th>
                <td>
                    <input type="hidden" name="break_ids[]" value="{{ $break->id }}">

                    <input class="time-input" type="time" name="break_starts[]" value="{{ old('break_starts.' . $index, $break->break_start ? \Carbon\Carbon::parse($break->break_start)->format('H:i') : '') }}">
                    <span class="time-separator">～</span>
                    <input class="time-input" type="time" name="break_ends[]" value="{{ old('break_ends.' . $index, $break->break_end ? \Carbon\Carbon::parse($break->break_end)->format('H:i') : '') }}">    

                    @error('break_starts.' . $index)
                        <p class="error-message">{{ $message }}</p>
                    @enderror

                    @error('break_ends.' . $index)
                        <p class="error-message">{{ $message}}</p>
                    @enderror
                </td>
            </tr>
            @endforeach

            <tr>
                <th>休憩{{ $attendance->breaks->count() + 1 }}</th>
                <td>
                    <input type="hidden"  name="break_ids[]" value="">
                    <input class="time-input" type="time" name="break_starts[]" value="{{ old('break_starts.' . $attendance->breaks->count()) }}">
                    <span class="time-separator">～</span>
                    <input class="time-input" type="time" name="break_ends[]" value="{{ old('break_ends.' . $attendance->breaks->count()) }}">
                </td>
            </tr>
                    
            <tr>
                <th>備考</th>
                <td>
                    <textarea name="remark">{{ old('remark', $attendance->remark) }}</textarea>
                    @error('remark')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
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