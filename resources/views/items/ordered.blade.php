@extends('layouts.default')

@section('content')
    <h1>ご購入ありがとうございました</h1>

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
        <a href="{{ route('items.top') }}">トップに戻る</a>
    </div>
@endsection