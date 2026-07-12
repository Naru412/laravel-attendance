@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_staff_list.css') }}">
@endsection

@section('content')
<main class="staff-list">
    <h2>スタッフ一覧</h2>
    <table class="staff-table">
        <tr>
            <th>名前</th>
            <th>メールアドレス</th>
            <th>月次勤怠</th>
        </tr>

        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <a href="/admin/staff/{{ $user->id }}">詳細</a>
            </td>
        </tr>
        @endforeach
    </table>      
</main>
@endsection