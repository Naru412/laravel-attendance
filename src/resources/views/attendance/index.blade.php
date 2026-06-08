@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance">
    <p class="status">勤務外</p>
    <p class="date">{{ $now->format('Y年n月j日') }}</p>
    <p class="time">{{ $now->format('H:i') }}</p>
    <button class="work-button">
        出勤
    </button>
</div>
@endsection
