@extends('layouts.app')

@section('css')
<link href="{{asset('/css/login.css')}}" rel="stylesheet" >
@endsection

@section('content')
<div class="login-container">
    <div class="login-form__heading">
        <h1>ログイン</h1>
    </div>
    <form class="form" action="{{ route('login') }}" method="post" novalidate autocomplete="off">
        @csrf
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
            <button class="form__button-submit" type="submit">ログインする</button>
        </div>
    </form>

    <div class="register__link">
        <a class="register__button-submit" href="/register">会員登録はこちら</a>
    </div>
</div>
@endsection
