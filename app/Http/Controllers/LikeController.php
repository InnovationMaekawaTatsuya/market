<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index($user){
        $like_items = \Auth::user()->likedItem()->latest()->get();
        return view('likes.index', [
            'title' => 'お気に入り商品一覧',
            'like_items' => $like_items,
        ]);
    }
}
