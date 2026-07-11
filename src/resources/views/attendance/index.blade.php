@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance">
    <p class="status">{{ $status }}</p>
    <p class="date">{{ $now->locale('ja')->isoFormat('YYYY年M月D日(ddd)') }}</p>
    <p class="time">{{ $now->format('H:i') }}</p>
    @if(session('message'))
        <p class="message">
            {{ session('message') }}
        </p>
    @endif

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
            <form action="/attendance/clock-out" method="post">
                @csrf
                <button type="submit" class="work-button">
                    退勤
                </button>
            </form>

            <form action="/attendance/break-in" method="post">
                @csrf
                <button type="submit" class="break-button">
                    休憩入
                </button>
            </form>
        </div>
    @endif

    @if($status === '休憩中')
        <form action="/attendance/break-out" method="post">
            @csrf
            <button type="submit" class="break-button">
                休憩戻
            </button>
        </form>
    @endif
</div>
@endsection