<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Team;
use App\Sujet;
use App\JoinDemand;
use App\InvitePlayer;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    //// relationships ////

    public function sujets() {
        return $this->hasMany(Sujet::class); // A user has many subject
    }

    public function teamLeading() {
        return Team::where('user_id', $this->id)->first();
    }

    public function team() {
        //Parcourir les deux tables
        $joindemand = JoinDemand::where('user_id', $this->id)->where('state',1)->first();
        $inviteplayer = InvitePlayer::where('user_id', $this->id)->where('state',1)->first();

        if($this->hasTeam()){
            if($joindemand){
                return Team::where('id', $joindemand->team_id)->first();
            }elseif($inviteplayer){
                return Team::where('id', $inviteplayer->team_id)->first();
            } else{
                return $this->teamLeading();
            }
        }

        return false;
    }

    //// methods ////

    // team member

    public function hasTeam() {

        //Parcourir les deux tables
        $joindemand = JoinDemand::where('user_id', $this->id)->where('state',1)->first();
        $inviteplayer = InvitePlayer::where('user_id', $this->id)->where('state',1)->first();

        return $inviteplayer || $joindemand || $this->isLeader() ;
    }

    public function isMemberOf(Team $team) {
        return $this->hasTeam() && $this->team()->is($team);
    }

    // team leader

    public function isLeaderOf(Team $team) {
        return $team->user_id == $this->id;
    }

    public function isLeader() {
        return Team::where('user_id', $this->id)->first() != null;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'admin','ctf_player', 'ctf_creator','email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'admin' => 'boolean',
        'ctf_player' => 'boolean',
        'ctf_creator' => 'boolean'
    ];
}
