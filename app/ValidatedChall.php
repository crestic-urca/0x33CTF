<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Team;
use App\Sujet;

class ValidatedChall extends Model
{
    public $timestamps = false;
    protected $table = 'validated_chall';
    protected $fillable = ['sujet_id','team_id','date_validated'];

    public function sujet() {
        return $this->belongsTo('App\Sujet');
    }

    public function team() {
        return $this->belongsTo('App\Team');
    }


}
