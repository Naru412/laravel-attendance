@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_attendance_list.css') }}">
@endsection

@section('content')
<main class="attendance-list">
    <h2>{{ $user->name }}さんの勤怠</h2>
</main>
@endsection