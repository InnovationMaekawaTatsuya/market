@extends('layouts.default')

@section('title, $title')

@section('content')
    <h1>新規出品</h1>


    <form method="post" action="{{ route('items.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label>商品名：<input type="text" name="name"></label>
        </div>
        <div>
            <label>商品説明：<textarea name="description" cols="30" rows="10"></textarea></label>
        </div>
        <div>
            <label>商品価格：<input type="integer" name="price"></label>
        </div>
        <div>
            <label>カテゴリー：
                <select name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </label>
        </div>
        <div>
            <input type="file" name="image">
        </div>
        <div>
            <input type="submit" value="出品">
        </div>
    </form>
@endsection