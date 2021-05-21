<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sujet extends Model
{
    public function categorie() {
        return $this->belongsTo('App\Categorie');
    }

    public function author() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public $timestamps = false;
    protected $table = 'sujet';
    protected $fillable = ['titre', 'enonce', 'flag','categorie_id','user_id','hide','nb_points','file_name','nb_try'];
    protected $casts = [
        'hide' => 'boolean',
    ];
}
