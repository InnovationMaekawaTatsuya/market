@extends('layouts.default')

@section('title, $title')

@section('content')
    <h1>プロフィール編集</h1>

    <form method="post" action="{{ route('users.update', $user) }}">
        @csrf
        @method('patch')
        <div>
            <label>ユーザー名：<input type="text" name="name" value="{{ $user->name }}"></label>
        </div>
        <div>
            <label>プロフィール：<textarea name="profile" cols="30" rows="10">{{ $user->profile }}</textarea></label>
        </div>
        <div>
            <input type="submit" value="更新">
        </div>
    </form>
@endsection