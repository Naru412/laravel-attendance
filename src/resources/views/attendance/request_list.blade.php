@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/request_list.css') }}">
@endsection

@section('content')
<main class="request-list">
    <h2 class="request-list__title">申請一覧</h2>

    <div class="request-tabs">
        <a href="/stamp_correction_request/list?status=pending" class="request-tabs__item {{ $status === 'pending' ? 'request-tabs__item--active' : ' ' }}">
            承認待ち
        </a>

        <a href="/stamp_correction_request/list?status=approved" class="request-tabs__item {{ $status === 'approved' ? 'request-tabs__item--active' : ' ' }}">
            承認済み
        </a>
    </div>

    <table class="request-table">
        <tr>
            <th>状態</th>
            <th>名前</th>
            <th>対象日時</th>
            <th>申請理由</th>
            <th>申請日時</th>
            <th>詳細</th>
        </tr>

        @foreach($corrections as $correction)
        <tr>
            <td>承認待ち</td>
            <td>{{ $correction->user->name }}</td>
            <td>{{ \Carbon\Carbon::parse($correction->attendance->work_date)->format('Y/m/d') }}</td>
            <td>{{ $correction->remarks }}</td>
            <td>{{ $correction->created_at->format('Y/m/d') }}</td>
            <td>
                <a href="">詳細</a>
            </td>
        </tr>
        @endforeach
    </table>
</main>
@endsection