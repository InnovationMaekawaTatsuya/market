<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'category_id', 'image', 'user_id',
    ];

    // userリレーション
    public function user(){
        return $this->belongsTo('App\User');
    }

    // categoryリレーション
    public function category(){
        return $this->belongsTo('App\Category');
    }

    // likesリレーション
    public function likes(){
        return $this->hasMany('App\Like');
    }

    // likeしたユーザーを取得するリレーション
    public function likedUsers(){
        return $this->belongsToMany('App\User', 'likes');
    }

    // 特定のユーザーにお気に入りされているか確認
    public function isLikedBy($user){
        $liked_users_ids = $this->likedUsers()->pluck('user_id');
        $result = $liked_users_ids->contains($user->id);
        return $result;
    }

    // orderリレーション
    public function order(){
        return $this->belongsTo('App\Order');
    }

    // 商品の購入者を取得
    public function orderUser(){
        return $this->belongsToMany('App\User', 'orders');
    }

    // 商品が購入されているか確認
    public function isOrderedBy($items){
        $ordered_items_ids = Order::all()->pluck('item_id');
        $result = $ordered_items_ids->contains($items->id);
        return $result;
    }
}
