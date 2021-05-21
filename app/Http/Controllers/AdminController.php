<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sujet;
use App\User;
use App\Categorie;
use App\CtfConfig;
use Auth;
use App\Http\Requests\ConfigRequest;
use DB;
use League\CommonMark\CommonMarkConverter;

class AdminController extends Controller
{
    //Only an admin can access those functions

    public function __construct()
    {
        $this->middleware(['auth', 'verified','admin']);
        $this->converter = new CommonMarkConverter();
    }

    /**
     * GET URL : /admin/users    Show every users, to upgrade them as creator or downgrade them
     */
    public function show_creator() {
        return view('admin.show_creator');
    }

    /**
     * GET URL : /admin/categories   Show every categories. From here you can delete or create new ones
     */
    public function show_categorie()
    {
        $categories = Categorie::all();

        return view('admin.show_categorie',compact('categories'));
    }

    /**
     * POST Used to upgrade a user that is a simple player
     */
    public function upgrade(User $user){
        $user->ctf_creator = true;
        $user->ctf_player = false;
        $user->save();

        $inform = "The user ". $user->name . " has been upgraded !";
        return redirect()->back()->with(compact('inform'));    
    }

    /**
     * POST Used to upgrade a user that is a simple player
     */
    public function downgrade(User $creator){
        $creator->ctf_creator = false;
        $creator->ctf_player = true;
        $creator->save();

        $inform = "The user ". $creator->name . " has been downgraded !";
        return redirect()->back()->with(compact('inform'));    
    }

    /**
     * POST Used to make public a subject
     */
    public function show(Sujet $sujet)
    {
        $sujet->hide = false;
        $sujet->save();

        $inform = "The challenge".$sujet->titre."is now public";
        return redirect()->back()->with(compact('inform'));    
    }

    /**
     * POST Used to hide a subject
     */
    public function hide(Sujet $sujet)
    {
        $sujet->hide = true;
        $sujet->save();

        $inform = "The challenge".$sujet->titre."is now private";
        return redirect()->back()->with(compact('inform'));    
    }


    /**
     * POST Used to get every players from a specific name
     */
    public function __ajax_player_list(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'user_name' => 'required',
            ]);
                        
            $users = User::where('name', 'like', '%'.$request->user_name.'%')
                ->where('id','!=', Auth::user()->id) /* Every player except him*/
                ->where('admin',0)
                ->orderBy('name')
                ->select("name", "id","email","ctf_creator")
                ->get()
                ->toArray();

            return response()->json($users);
        }
        
        abort(404);
    }

    /**
     * GET URL : /admin/config To show the form of a configuration
     */
    public function config(){
        if(CtfConfig::all()->count() == 1){
            //case where we update
            $config = CtfConfig::all()->first();
            $button = "update";
            return view('admin.config', compact('button','config'));
        }else{
            $button = "save";
            return view('admin.config', compact('button'));
        }
    
    }

    /**
     * POST URL Used make or update a configuration
     */
    public function configuration(ConfigRequest $request){

        //Test if date are OK

        $date_start = strtotime($request->date_start ." ". $request->date_start_time);
        $date_end = strtotime($request->date_end ." ".$request->date_end_time);
        
        if($date_end - $date_start <= 0){
            return back()->withErrors(['date_end'=>"Your end date can't be before your starting date "]);    
        }

        if(CtfConfig::all()->count() == 1){
            //case where we update
            $ctfconfig = CtfConfig::first();

            $ctfconfig->name = $request->name;
            $ctfconfig->email_verification =  $request->has('email_verification');

            if($request->has('use_limitation_players_per_team') == true){
                $ctfconfig->max_players_per_team = $request->max_players_per_team;
            }else{
                $ctfconfig->max_players_per_team = -1;
            }

            if($request->has('description') == true){
                $ctfconfig->description = $request->description;
            }

            $ctfconfig->date_start = date('Y-m-d H:i:s', $date_start);
            $ctfconfig->date_end = date('Y-m-d H:i:s', $date_end);


            $ctfconfig->save();
            $inform = "The configuration in updated !";
            return redirect()->back()->with(compact('inform'));       
        } else {
            //case where its first time
        
            //Si l'admin choisi de mettre la verif, alors on update les users qui ont crees leurs compte avant
            if($request->has('email_verification') == false){
                User::where('email_verified_at',null)
                        ->update(['email_verified_at' => now() ]);
            }
            
            $ctfconfig = new CtfConfig;
            $ctfconfig->name = $request->name;
            $ctfconfig->email_verification =  $request->has('email_verification');

            if($request->has('use_limitation_players_per_team') == true){
                $ctfconfig->max_players_per_team = $request->max_players_per_team;
            }else{
                $ctfconfig->max_players_per_team = -1;
            }

            if($request->has('description') == true){
                $ctfconfig->description = $request->description;
            }

            $ctfconfig->date_start = date('Y-m-d H:i:s',$date_start);
            $ctfconfig->date_end = date('Y-m-d H:i:s',$date_end);

            $ctfconfig->save(); 

            $inform = "The configuration in finished !";
            return redirect()->back()->with(compact('inform'));          
        }

    }

    /**
     * POST Used to show a subject or multiple ones 
     */
    public function show_multiple(Request $request)
    {
        $table = json_decode($request->getContent(), true);

        foreach ($table as $tab) {
            Sujet::where('id',$tab)->update(['hide' => false]);
        }

        return back();
    }

    /**
     * POST Used to hide a subject or multiple ones 
     */
    public function hide_multiple(Request $request)
    {
        $table = json_decode($request->getContent(), true);

        foreach ($table as $tab) {
            Sujet::where('id',$tab)->update(['hide' => true]);
        }

        return back();
    }

    /**
     * POST Used to hide a subject
    */
    public function delete_multiple(Request $request)
    {
        $table = json_decode($request->getContent(), true);
        foreach ($table as $tab) {
            Sujet::where('id',$tab)->delete();
        }

        return back();
    }

    public function showing_one_subject(Sujet $sujet)
    {
        $sujet->enonce = $this->converter->convertToHtml($sujet->enonce);
        return view('admin.showing_one_sujet', ['sujet' => $sujet]);
    }

}
