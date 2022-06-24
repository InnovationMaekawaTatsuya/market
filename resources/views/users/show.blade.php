@extends('layouts.default')

@section('title, $title')

@section('content')
    <h1>{{ $title }}</h1>

    <div>
        @if($user->image !== null)
            <img src="{{ asset('storage/' . $user->image) }}">
        @else
            <img src="{{ asset('images/no_image.png') }}">
        @endif
        <br><a href="{{ route('users.edit_image', $user) }}">画像を編集</a>
    </div>

    <div>
        @if($user->profile !== null)
            <p>プロフィール文：{{ $user->profile }}</p>
        @else  
            <p>プロフィール文を入力してください。</p>
        @endif
    </div>

    <div>
        <p>{{ $user->name }}さん<a href="{{ route('users.edit', $user) }}">プロフィールを編集</a></p>
    </div>

    {{-- 出品数 --}}
    <p>出品数：{{ count($user->items) }}</p>

    <h1>購入履歴</h1>

    {{-- 購入履歴 --}}
    <div>
        @forelse($ordered_items as $ordered_item)
            <p>{{ $ordered_item->name }}：{{ $ordered_item->price }}円　出品者　{{ $ordered_item->user->name }}</p>
        @empty
            <p>過去に購入した商品がありません<p>
        @endforelse
    </div>
@endsection