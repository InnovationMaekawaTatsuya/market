@extends('layouts.default')

@section('content')
    <h1>商品情報編集</h1>

    <div>
        <form method="post" action="{{ route('items.update', $item) }}" >
            @csrf
            @method('patch')
            <div>
                <label>商品名：<input type="text" name="name" value="{{ $item->name }}"></label>
            </div>
            <div>
                <label>商品説明：<textarea name="description" cols="30" rows="10">{{ $item->description }}</textarea></label>
            </div>
            <div>
                <label>商品価格：<input type="integer" name="price" value="{{ $item->price }}"></label>
            </div>
            <div>
                {{-- カテゴリ --}}
            </div>
            <div>
                <input type="submit" value="商品情報を更新">
            </div>
        </form>
    </div>
@endsection