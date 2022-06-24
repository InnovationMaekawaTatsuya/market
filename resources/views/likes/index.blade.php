@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>
    <div>
        @forelse($like_items as $like_item)
            @if($like_item->image != null)
                <a href="{{ route('items.show', $like_item) }}"><img src="{{ asset('storage/' . $like_item->image) }}"></a>
            @else
                <a href="{{ route('items.show', $like_item) }}"><img src="{{ asset('images/no_image.png') }}"></a>
            @endif
        @empty
            <p>いいねした商品がありません。</p>
        @endforelse
        <p>{{ $like_item->description }}</p>
    </div>
    <div>
        <p>商品名：{{ $like_item->name }}　{{ $like_item->price }}円</p>
    </div>
    <div>
        <p>カテゴリ：{{ $like_item->category->name }}（{{ $like_item->created_at }}）</p>
    </div>
@endsection