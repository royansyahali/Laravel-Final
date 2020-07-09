<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $guarded = [];
    public function jawaban(){
        return $this->belongsToMany('App\Jawaban');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function pertanyaan(){
        return $this->belongsToMany('App\Pertanyaan','pertanyaan_komentar','komentar_id','pertanyaan_id');
    }
}
