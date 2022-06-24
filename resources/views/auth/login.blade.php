@extends('layouts.default')

@section('content')
    <h1>ログイン</h1>

    <form method="post" action="{{ route('login') }}">
        @csrf
        <div>
            <label>メールアドレス：<input type="email" name="email"></label>
        </div>
        <div>
            <label>パスワード：<input type="password" name="password"></label>
        </div>
        <div>
            <input type="submit" value="ログイン">
        </div>
    </form>
@endsection