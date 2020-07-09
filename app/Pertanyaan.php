<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    //
    protected $guarded = [];

    public function tag(){
        return $this->belongsToMany('App\Tag');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
