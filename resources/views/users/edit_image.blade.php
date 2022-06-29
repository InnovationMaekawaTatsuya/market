@extends('layouts.default')

@section('title, $title')

@section('content')
    <h1>プロフィール画像編集</h1>

    @if($user->image !== null)
            <img src="{{ \Storage::url($user->image) }}" class="center">
        @else
            画像はありません。
        @endif
        <form method="post" action="{{ route('users.update_image') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div>
                <label>
                    画像を選択:
                    <input type="file" name="image">
                </label>
            </div>
            <div>
                <input type="submit" value="更新">
            </div>
        </form>
    </div>
@endsection