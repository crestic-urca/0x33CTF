<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    public function sujets(){
        return $this->hasMany('App\Sujet');
    }

    public $timestamps = false;
    protected $table = 'categorie';
    protected $fillable = ['nom_categorie'];
}
