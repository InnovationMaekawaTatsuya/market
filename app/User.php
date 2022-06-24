<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // itemsリレーション
    public function items(){
        return $this->hasMany('App\Item');
    }

    // likesリレーション
    public function likes(){
        return $this->hasMany('App\Likes');
    }

    // 自分がlikeした商品を取得するリレーション
    public function likedItem(){
        return $this->belongsToMany('App\Item', 'likes');
    }

    // ordersリレーション
    public function orders(){
        return $this->hasMany('Order');
    }

    // 商品の購入履歴を取得
    public function orderItems(){
        return $this->belongsToMany('App\Item', 'orders');
    }
}
