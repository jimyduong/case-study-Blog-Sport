<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function blog(){
        return $this->belongsTo(Blog::class);
    }
}
