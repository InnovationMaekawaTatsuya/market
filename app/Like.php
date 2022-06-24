<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id', 'item_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function item(){
        return $this->belongsTo('App\Item');
    }

    // いいねが既にされているかの確認
    public function like_exist($id, $item_id){
        // Likesテーブルの中に、user_id,item_idが一致するものがあれば取得

        $exist = Like::where('user_id', '=', $id)->where('item_id', '=', $item_id)->exists();
        // もし、すでにLikeされていたら、
        if ($exist) {
            return true;
        }else{
            // Likeされていなかったら、
            return false;
        }
    }
}
