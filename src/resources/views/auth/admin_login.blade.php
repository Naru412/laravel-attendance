@extends('layouts.app')

@section('css')
<link href="{{asset('/css/admin_login.css')}}" rel="stylesheet" >
@endsection

@section('content')
<div class="login-container">
    <div class="login-form__heading">
        <h1>管理者ログイン</h1>
    </div>
    <form class="form" action="{{ route('login') }}" method="post" novalidate autocomplete="off">
        @csrf
        <input type="hidden" name="login_type" value="admin">
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" value="{{ old('email') }}"autocomplete="off">
                </div>
                <div class="form__error">
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">パスワード</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="password" name="password" value="{{ old('password') }}" />
                </div>
                <div class="form__error">
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__button">
            <button class="form__button-submit" type="submit">管理者ログインする</button>
        </div>
    </form>
</div>
@endsection
