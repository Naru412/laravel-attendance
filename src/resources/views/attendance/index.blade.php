@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance">
    <p class="status">{{ $status }}</p>
    <p class="date">{{ $now->format('Y年n月j日') }}</p>
    <p class="time">{{ $now->format('H:i') }}</p>

    @if($status === '勤務外')
        <form action="/attendance/clock-in" method="post">
        @csrf
        <button type="submit" class="work-button">
        出勤
        </button>
        </form>
    @endif

    @if($status === '出勤中')
        <div class="button-area">
            <button class="work-button">退勤</button>
            <button class="break-button">休憩入</button>
        </div>
    @endif
</div>
@endsection
