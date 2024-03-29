<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public function category(){
        return $this->belongsTo('App\Category');
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
}
