<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sujet;
use App\User;
use App\Categorie;
use App\Team;
use Auth;
use App\ValidatedChall;
use League\CommonMark\CommonMarkConverter;


class UserController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'verified','ctf_player']);
        $this->converter = new CommonMarkConverter();
    }

    public function validate_ctf(Request $request, Sujet $sujet){
        $player = Auth::user();
        
        if ($player->hasTeam()) {
            $team = $player->team();

            //verifier que le chall a pas deja ete valide
            $valid = ValidatedChall::where('team_id',$team->id)
                ->where('sujet_id',$sujet->id)
                ->where('state',1)
                ->get();

            //verifie qu'ils n'ont pas dépassé le nb max d'essaie autorisé
            $nb_try = ValidatedChall::where('team_id',$team->id)
            ->where('sujet_id',$sujet->id)
            ->where('state',0)
            ->count();
            
            //Si l'on trouve rien, ok il peut valider
            if (!$valid->first() && $nb_try < $sujet->nb_try) {
                $flag = $request->input('flag'); //Get the flag the user entered 

                //The test
                if ( strcmp($sujet->flag, $flag) === 0) {
    
                    //Ajouter dans la nouvelle table
                    $valChall = new ValidatedChall;
                    $valChall->team_id = $team->id;
                    $valChall->sujet_id = $sujet->id;
                    $valChall->state = 1;
                    $valChall->save();
    
                    $inform = "Congratulation ! You got the right flag for " . $sujet->titre . " !";
                    return redirect()->back()->with( ['inform' => $inform, "success" => true]);

                } else {
                    $valChall = new ValidatedChall;
                    $valChall->team_id = $team->id;
                    $valChall->sujet_id = $sujet->id;
                    $valChall->state = 0;
                    $valChall->save();

                    $inform = "Sorry ! It was the wrong flag for " . $sujet->titre . " !";
                    return redirect()->back()->with( ['inform' => $inform, "success" => false]);
                }            
            }

            abort(404);

        } else {
            abort(401);
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sujets = Sujet::all();
        $categories = Categorie::pluck('nom_categorie', 'id');

        return view('ctf_player.index',compact('sujets','categories'));
    }

    public function __ajax_sujets(Request $request){

        if ($request->ajax()) {
            $this->validate($request, [
                'categorie_id' => 'required',
            ]);

            $team = Auth::user()->team();
            
            $sujets = Sujet::where('categorie_id',$request->categorie_id)
                ->select('id','hide','nb_points', 'enonce', 'titre', 'file_name', 'hide', 'nb_try')
                ->orderBy('nb_points', 'desc')
                ->get();
                
            foreach ($sujets as $key => $sujet) {
                $sujets[$key]["hide"] = $sujet->hide;
                if($sujet->hide){
                    $sujets[$key]["enonce"] = "";
                    $sujets[$key]["nb_points"] = "";
                    $sujets[$key]["file_name"] = "";
                }else{
                    $sujets[$key]["enonce"] = $this->converter->convertToHtml($sujet->enonce);
                }

                if (!Auth::user()->hasTeam()) {
                    $sujets[$key]["display_form"] = false;
                } else {
                  /* test if the team has validate this subject */
                    //Regarde si la team a valide le chall

                    $temp = ValidatedChall::where('team_id', $team->id)
                                ->where("sujet_id", $sujet->id)
                                ->where('state',1)
                                ->get();
                    
                    //verifie qu'ils n'ont pas dépassé le nb max d'essaie autorisé
                    $nb_try = ValidatedChall::where('team_id',$team->id)
                    ->where('sujet_id',$sujet->id)
                    ->where('state',0)
                    ->count();

                    $sujets[$key]["team_try"] = $nb_try;
                    
                    //Si la team a validé le sujet, on met l'affichage a faux
                    //Sinon, s'ils ont depasse le nb max d'essaie, on met l'affichage a faux et maxtry a vrai
                    if ($temp->first()) {
                        $sujets[$key]["display_form"] = false;
                        $sujets[$key]["max_try_reach"] = false;
                    } else {
                        if ($nb_try >= $sujet->nb_try) {
                            $sujets[$key]["max_try_reach"] = true;
                            $sujets[$key]["display_form"] = false;
                        }else{
                            $sujets[$key]["max_try_reach"] = false;
                            $sujets[$key]["display_form"] = true;
                        }
                    }

                }
            }
            return response()->json($sujets);
        }
        abort(404);
    }
    
    public function showing_one_subject(Sujet $sujet)
    {
        $sujet->enonce = $this->converter->convertToHtml($sujet->enonce);
        return view('sujet.showing_one_sujet', ['sujet' => $sujet]);
    }
}
