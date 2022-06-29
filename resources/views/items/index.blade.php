@extends('layouts.default')

@section('title, $title')

@section('content')
    <h1>商品一覧</h1>

    {{--新規出品ボタン--}}
    <form method="get" action="{{ route('items.create') }}">
        <input type="submit" value="新規出品">
    </form>
    
    {{--自分の商品一覧--}}
    <div class="myitems">
        @forelse($items as $item)
            <div>
                @if($item->image !== null)
                    <a href="{{ route('items.show', $item) }}"><img src="{{ asset('storage/' . $item->image) }}"></a>
                @else
                    <a href="{{ route('items.show', $item) }}"><img src="{{ asset('images/no_image.png') }}"></a>
                @endif
                <p>{{ $item->description }}</p>
            </div>
            <div>
                <p>商品名：{{ $item->name }}　{{ $item->category->name }}　{{ $item->price }}円</p>
            </div>
            <div>
                <p>[<a href="{{ route('items.edit', $item) }}">編集</a>][<a href="{{ route('items.edit_image', $item) }}">画像を変更</a>]</p>
            </div>
            <div>
            <form class="delete" method="post" action="{{ route('items.destroy', $item) }}">
                @csrf
                @method('DELETE')
                <input type="submit" value="削除">
            </form>
            </div>
        @empty
            <p>出品している商品はありません</p>
        @endforelse
    </div>
@endsection