@extends('layouts.default')

@section('title, $title')

@section('content')
    <h1>購入する商品の情報を確認</h1>

    <div>
        <p>商品名：{{ $item->name }}</p>
    </div>
    <div>
        @if($item->image !== null)
            <a href="{{ route('items.show', $item) }}"><img src="{{ asset('storage/' . $item->image) }}"></a>
        @else
            <a href="{{ route('items.show', $item) }}"><img src="{{ asset('images/no_image.png') }}"></a>
        @endif
    </div>
    <div>
        {{-- カテゴリ --}}
        <p>カテゴリ：{{ $item->category->name }}</p>
    </div>
    <div>
        <p>価格：{{ $item->price }}</p>
    </div>
    <div>
        <p>説明：{{ $item->description }}</p>
    </div>
    <div>
        {{-- 購入ボタン --}}
        <form method="post" action="{{ route('items.orderd', $item) }}">
            @csrf
            @method('patch')
            <input type="submit" value="内容を確認して、購入する">
        </form>
    </div>
@endsection