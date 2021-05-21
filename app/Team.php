<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\CtfConfig;
use App\ValidatedChall;
use DB;

class Team extends Model
{
    public $timestamps = false;
    protected $table = 'team';
    protected $fillable = ['team_name', 'join_demand', 'user_id' ,'created_at'];

    public function leader() {
        return $this->hasOne('App\User', 'id','user_id');
    }

    public function members() {

        $ids1 = DB::table('join_demand')->where('team_id', $this->id)->where('state', 1)->whereNotNull('user_id')->pluck('user_id');
        $ids2 = DB::table('invitation_player')->where('team_id', $this->id)->where('state', 1)->whereNotNull('user_id')->pluck('user_id');

        return User::whereIn('id', $ids2)->orWhereIn('id', $ids1);
    }

    public function isFull(){
		if(CtfConfig::first()->max_players_per_team == -1){
			return false;
		}
		else{
			return $this->number_members() >= CtfConfig::first()->max_players_per_team;
		}
    }

    public function challs(){
        return $this->hasMany(ValidatedChall::class, 'team_id');
    }

    public function challs_validated(){
        return $this->challs()->where('state', 1);
    }
    
    public function points(){
        $points = 0;
        $challs = $this->challs()->where('state', 1)->get();
       
        foreach ($challs as $chall ) {
            $points += Sujet::where('id',$chall->sujet_id)->first()->nb_points;
        }
        return $points;
    }

    public function rank(){
        $challs = $this->challs()->where('state', 1)->get();

        if ($challs->isEmpty()) { return -1; }

        $team_that_validated_chall = ValidatedChall::select('team_id')->where('state', 1)->groupBy('team_id');
        
        $teams = Team::join('validated_chall', 'team.id', '=', 'validated_chall.team_id')
                    ->get()
                    ->groupBy('id');

        $array = [];
        foreach ($teams as $team) {
            $array[$team->first()->id] = $team->first()->points();
        }

        arsort($array);/* reverse sort by point */

        return ( array_search($this->id, array_keys($array) ) + 1) ;
    }

    public function validated(int $id){
        $retour = ValidatedChall::where('team_id',$this->id)->where('sujet_id', $id)->where('state',1)->first();

        if($retour){
            return true;
        } else {
            return false;
        }
    }

    public function max(int $id){
        $sujet = Sujet::where('id',$id)->first();
        $count = ValidatedChall::where('team_id',$this->id)->where('sujet_id', $id)->where('state',0)->count();

        if($count >= $sujet->nb_try){
            return true;
        } else {
            return false;
        }
    }

    public function try(int $id){
        $count = ValidatedChall::where('team_id',$this->id)->where('sujet_id', $id)->where('state',0)->count();

        if ($count == null) {
            $count = 0;
        }
        return $count;
    }

    public function number_members(){
        return $this->members()->count() + 1;
    }

}
