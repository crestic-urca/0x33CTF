<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JoinDemand extends Model
{
    public $timestamps = false;
    protected $table = 'join_demand';
    protected $fillable = ['user_id','team_id','state','date_join_demand'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function team() {
        return $this->belongsTo('App\Team');
    }
}
