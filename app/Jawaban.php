<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    //
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function pertanyaan(){
        return $this->belongsTo('App\Pertanyaan');
    }
    public function komentar(){
        return $this->belongsToMany('App\Komentar');
    }
}
