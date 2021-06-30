<?php

namespace App\Http\Controllers;

use App\User;
use App\Team;
use App\Sujet;
use App\Categorie;
use Auth;
use App\ValidatedChall;
use App\CtfConfig;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $nb_player = User::where('ctf_player', 1)
                        ->count();
        
        $nb_creator = User::where('ctf_creator', 1)
                        ->where('admin', 0)
                        ->count();
                
        $nb_admin = User::where('admin', 1)
                        ->count();

        $nb_subject = Sujet::all()
                        ->count();
        
        $nb_categories = Categorie::all()
                        ->count();
        
        $nb_resolve_chall = ValidatedChall::where('state', 1)
                        ->count();
        
        $nb_teams = Team::all()
                        ->count();

        $config = CtfConfig::first();

        //verification de la création de la config
        if($config != NULL){}
        else{
            return redirect('admin/config');
        }

        return view('home',compact('nb_player','nb_creator','nb_admin','nb_subject','nb_categories','nb_resolve_chall','nb_teams','config'));
    }
}
