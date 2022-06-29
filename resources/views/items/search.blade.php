@extends('layouts.default')

@section('content')
    
    <h1>検索結果</h1>

    {{-- 検索フォーム --}}
    <form method="post" action="{{route('items.search')}}">
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
   
    @forelse($searchedItems as $item)
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
            <p>カテゴリ：{{ $item->category->name }}</p>
        </div>
    @empty
        <p>検索結果がありません。</p>
    @endforelse

    {{-- ページネーション --}}
    <div>
        {{ $searchedItems->links() }}
    </div>

@endsection