@extends('layouts.default')

@section('content')
    <h1>お気に入り商品一覧</h1>
    <div>
        @forelse($likeItems as $likeItem)
            @if($likeItem->image != null)
                <a href="{{ route('items.show', $likeItem) }}"><img src="{{ asset('storage/' . $likeItem->image) }}"></a>
            @else
                <a href="{{ route('items.show', $likeItem) }}"><img src="{{ asset('images/no_image.png') }}"></a>
            @endif
            <p>{{ $likeItem->description }}</p>
            <div>
                <p>商品名：{{ $likeItem->name }}　{{ $likeItem->price }}円</p>
            </div>
            <div>
                <p>カテゴリ：{{ $likeItem->category->name }}</p>
            </div>
        @empty
            <p>いいねした商品がありません。</p>
        @endforelse
    </div>
@endsection