@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_request_detail.css') }}">
@endsection

@section('content')
<main class="attendance-detail">
    <h2>勤怠詳細</h2>
        <table class="detail-table">
            <tr>
                <th>名前</th>
                <td>{{ $correction->attendance->user->name }}</td>
            </tr>

            <tr>
                <th>日付</th>
                <td>
                    <span class="date-year">
                        {{ \Carbon\Carbon::parse($correction->attendance->work_date)->format('Y年') }}
                    </span>
                    <span class="date-day">
                        {{ \Carbon\Carbon::parse($correction->attendance->work_date)->format('n月j日') }}
                    </span>
                </td>
            </tr>

            <tr>
                <th>出勤・退勤</th>
                <td>
                    <input class="time-input" type="time" name="clock_in" value="{{ old('clock_in', $correction->requested_clock_in ? \Carbon\Carbon::parse($correction->requested_clock_in)->format('H:i') : '') }}">
                    <span class="time-separator">～</span>
                    <input class="time-input" type="time" name="clock_out"  value="{{ old('clock_out', $correction->requested_clock_out ?  \Carbon\Carbon::parse($correction->requested_clock_out)->format('H:i') : '') }}">

                    @error('clock_in')
                        <p class="error-message">{{ $message }}</p>
                    @enderror

                    @error('clock_out')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </td>
            </tr>

            @foreach($correction->breakCorrections as $index => $breakCorrection)
            <tr>
                <th>
                    @if($index === 0)
                        休憩
                    @else
                        休憩{{ $index + 1 }}
                    @endif
                </th>
                <td>
                    <input type="hidden" name="break_ids[]" value="{{ $breakCorrection->break_id }}">

                    <input class="time-input" type="time" name="break_starts[]" value="{{ old('break_starts.' . $index, $breakCorrection->requested_break_start ? \Carbon\Carbon::parse($breakCorrection->requested_break_start)->format('H:i') : '') }}">
                    <span class="time-separator">～</span>
                    <input class="time-input" type="time" name="break_ends[]" value="{{ old('break_ends.' . $index, $breakCorrection->requested_break_end ? \Carbon\Carbon::parse($breakCorrection->requested_break_end)->format('H:i') : '') }}">    

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
                <th>休憩{{ $correction->breakCorrections->count() + 1 }}</th>
                <td>
                    <input type="hidden"  name="break_ids[]" value="">
                    <input class="time-input" type="time" name="break_starts[]" value="{{ old('break_starts.' . $correction->breakCorrections->count()) }}">
                    <span class="time-separator">～</span>
                    <input class="time-input" type="time" name="break_ends[]" value="{{ old('break_ends.' . $correction->breakCorrections->count()) }}">
                </td>
            </tr>
                    
            <tr>
                <th>備考</th>
                <td>
                    <textarea name="remark">{{ old('remark', $correction->remarks) }}</textarea>
                    @error('remark')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </td>
            </tr>
        </table>

        <div class="button-area">
            <form action="/admin/stamp_correction_request/{{ $correction->id }}/approve" method="post">
                @csrf
                <button type="submit" class="approve-btn">
                承認
                </button>
            </form>
        </div>
</main>
@endsection
