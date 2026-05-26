@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance">
    <p class="status">勤務外</p>
    <p class="date">2023年6月1日(木)</p>
    <p class="time">08:00</p>
    <button class="work-button">
        出勤
    </button>
</div>
@endsection
