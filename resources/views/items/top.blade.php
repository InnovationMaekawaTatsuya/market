@extends('layouts.default')

@section('title, $title')

@section('content')
    <h1>{{ $title }}</h1>

    {{-- 検索フォーム --}}
    <form method="post" action="{{ route('items.search') }}">
        @csrf
        <input type="search" placeholder="ユーザ名を入力" name="search"
        @if(isset($search)){
            {{ $search }}
        }@endif>
        <div>
            <button type="submit">検索</button>
            <button>
                <a href="{{ route('items.top') }}">クリア</a>
            </button>
        </div>
    </form>

    {{--新規出品ボタン--}}
    <form method="get" action="{{ route('items.create', Auth::user()->id ) }}">
        <input type="submit" value="新規出品">
    </form>

    {{-- 商品一覧　--}}
    <div>
        @forelse($items as $item)
            <div>
                @if($item->image != null)
                    <a href="{{ route('items.show', $item) }}"><img src="{{ asset('storage/' . $item->image) }}"></a>
                @else
                    <a href="{{ route('items.show', $item) }}"><img src="{{ asset('images/no_image.png') }}" class="item_img"></a>
                @endif
                <p>{{ $item->description }}</p>
            </div>
            <div>
                <p>商品名：{{ $item->name }}　{{ $item->price }}円</p>
                <p>カテゴリ：{{ $item->category->name }}（{{ $item->created_at }}）</p>
                @csrf
                <p class="favorite-marke">
                @if($like_model->like_exist(\Auth::user()->id, $item->id) === true)
                    <span class="js-like-toggle loved" data-itemid="{{ $item->id }}"><i class="fas fa-heart">@csrf</i></span>
                @else
                    <span class="js-like-toggle" data-itemid="{{ $item->id }}"><i class="fas fa-heart"></i></span>
                @endif
                <span class="likesCount">{{$item->likes_count}}</span>
                </p>
            </div>
        @empty
            <p>出品している商品はありません</p>
        @endforelse
    </div>

    <div>
        {{ $items->links() }}
    </div>
    
    
@endsection