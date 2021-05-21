<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvitePlayer extends Model
{
    public $timestamps = false;
    protected $table = 'invitation_player';
    protected $fillable = ['user_id','team_id','state','date_invitation'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function team() {
        return $this->belongsTo('App\Team');
    }
}
