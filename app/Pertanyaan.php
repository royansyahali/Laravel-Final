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
    public function jawaban(){
        return $this->hasMany('App\Jawaban');
    }
    public function komentar(){
        return $this->belongsToMany('App\Komentar','pertanyaan_komentar');
    }
    public function votepertanyaan(){
        return $this->hasMany('App\Votepertanyaan');
    }
    public function votepertanyaanup(){
        return $this->hasMany('App\Votepertanyaanup');
    }

}
