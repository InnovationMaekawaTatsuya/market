@extends('layouts.default')

@section('title, $title')

@section('content')
    <h1>{{ $title }}</h1>

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
        @if($item->isOrderedBy($item) === false)
            <a class="order_btn">購入</a>
            <form method="post" action="{{ route('items.order_confirm', $item) }}">
                @csrf
                @method('patch')
            </form>
        @else
            <p>売り切れ</p>
        @endif
    </div>

    <script>
        /* global $ */
        $('.order_btn').each(function(){
            $(this).on('click', function(){
            $(this).next().submit();
            });
        });
    </script>
@endsection