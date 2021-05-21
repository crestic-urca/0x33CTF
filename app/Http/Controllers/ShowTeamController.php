<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\ValidatedChall;
use App\Categorie;
use App\CtfConfig;
use App\Sujet;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ShowTeamController extends Controller
{
    /**
     * GET URL : /teams    It is showing a paginate of every teams
     */
    public function index(Request $request)
    {
        if(!empty($request->input('name'))){
            $teams = Team::where('team_name', 'like', '%'.($request->name).'%')->paginate(10);
        }
        else{
            $teams = Team::paginate(10);
        }

        return view('showteam.index', ['teams' => $teams]);
    }

    /**
     * GET URL : /teams/{team}    It is showing a team statistics
     */
    public function showing_one_team(Team $team)
    {
        $validated_chall = ValidatedChall::where('team_id', $team->id);

        //Get categories name
        $tab_categories = Categorie::select('nom_categorie')->pluck('nom_categorie')->toArray();
        $tab_categories = array_values($tab_categories);

        //Get total time in hours of chall
        $timeStart = CtfConfig::first()->date_start;
        $timeEnd = CtfConfig::first()->date_end;

        $overalltime = strtotime($timeEnd) - strtotime($timeStart);

        $tab_label_line = [0];
        $tab_points_line = [0];

        $points = 0;
        $sujets_validated = ValidatedChall::where('state', 1)->where('team_id',$team->id)->orderBy('date_validated')->get()->toArray();

        foreach($sujets_validated as $sujet){
            array_push($tab_label_line, round( (( strtotime($sujet['date_validated']) - strtotime($timeStart)) / $overalltime ) * 100 , 3) );
            $points += Sujet::where('id', $sujet['sujet_id'])->first()->nb_points;
            array_push($tab_points_line, $points);
        }

        array_push($tab_label_line, 100);
        $tab_data = [];
        //Get percentage value
        foreach ($tab_categories as $tab) {
            $cat = Categorie::where('nom_categorie', $tab)->first();
            $nb_sujets = $cat->sujets->count();
            
            $nb_validate = 0;
            foreach ($cat->sujets as $sujet) {
                if (ValidatedChall::where('team_id',$team->id)->where('sujet_id',$sujet->id)->first()) {
                    $nb_validate++;
                }
            }

            array_push($tab_data, ($nb_validate == 0 || $nb_sujets == 0) ? 0 : ($nb_validate/$nb_sujets)*100);
        }
        
        return view('showteam.showing_one_team', ['team' => $team , 'validated_chall' => $validated_chall,'tab_categories' => $tab_categories,'tab_data' => $tab_data , 'tab_label_line' => $tab_label_line, 'tab_points_line' => $tab_points_line]);
    }

}
