<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // itemリレーション
    public function item(){
        return $this->belongsTo('App\Item');
    }
}
