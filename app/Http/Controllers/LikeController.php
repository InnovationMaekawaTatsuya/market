<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index($user){
        $likeItems = \Auth::user()->likedItem()
                                   ->latest()
                                   ->get();
        return view('likes.index', compact('likeItems'));
    }
}
