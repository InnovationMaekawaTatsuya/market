@extends('layouts.default')

@section('title, $title')

@section('content')
    <h1>{{ $title }}</h1>

    @if($item->image != '')
        <img src="{{ \Storage::url($item->image) }}">
    @else
        <p>画像がありません。</p>
    @endif
    
    <form method="post" action="{{route('items.update_image', $item)}}" enctype='multipart/form-data'>
        @csrf
        @method('patch')
        <label>画像：<input type="file" name="image" value="{{ $item->image }}"></label><br>
        <input type="submit" value="更新">
    </form>
@endsection