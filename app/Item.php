<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'category_id', 'image', 'user_id',
    ];

    // userリレーション
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // categoryリレーション
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    // likesリレーション
    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    // likeしたユーザーを取得するリレーション
    public function likedUsers()
    {
        return $this->belongsToMany('App\User', 'likes');
    }

    // 特定のユーザーにお気に入りされているか確認
    public function isLikedBy($user)
    {
        $liked_users_ids = $this->likedUsers()->pluck('user_id');
        $result = $liked_users_ids->contains($user->id);
        return $result;
    }

    // orderリレーション
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    // 商品の購入者を取得
    public function orderUser()
    {
        return $this->belongsToMany('App\User', 'orders');
    }

    // 商品が購入されているか確認
    public function isOrderedBy($items)
    {
        $orderedItems_ids = Order::all()->pluck('item_id');
        $result = $orderedItems_ids->contains($items->id);
        return $result;
    }

    // 検索時scope
    // 全角スペースを半角に変換
    public function scopeFilterSpace($query, $search)
    {
        $filterSpace = mb_convert_kana($search, 's');
        return $filterSpace;

    }
    // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
    public function scopeFilterArray($query, $search, $spaceConversion){
        $filterArray = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
        return $filterArray;
    }
    // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
    public function scopeFilterRetention($query, $value){
        $filterRetention = $query->where('name', 'like', '%'.$value.'%');
        return $filterRetention;
    }
    // 上記で取得した$queryをページネートにし、変数$usersに代入
    public function scopeSubstitution($query, $search){
        $items = $search->paginate(10);
        return $items;
    }
}