<?php

namespace App\Http\Controllers;

use App\User;
use App\Team;
use App\ValidatedChall;
use App\Sujet;
use Illuminate\Http\Request;

class ScoreBoardController extends Controller
{

    /**
     * GET URL : /scoreboard   Showing the scoreboard of the challenge
     */
    public function index()
    {  
        $teams = [];
        $every_teams = Team::all();

        foreach($every_teams as $team){
            $sujets_validated = ValidatedChall::where('state', 1)->where('team_id',$team->id)->orderBy('date_validated')->get()->toArray();
            $p = 0;
            $temp_tab = [];
            $points = [];
            $dates = [];
            foreach($sujets_validated as $sujet){
                array_push($dates, $sujet['date_validated'] );
                $p += Sujet::where('id', $sujet['sujet_id'])->first()->nb_points;
                array_push($points, $p);
            }

            array_push($teams, array('name' => $team->team_name, 'points' => $points, 'date' => $dates)) ;
        }
        return view('scoreboard.index', ['teams' => array('teams' => $teams)] );
    }

}
