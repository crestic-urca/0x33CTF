<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests\TeamSubmitRequest;
use App\Repositories\TeamRepository;
use App\User;
use App\Team;
use App\JoinDemand;
use App\InvitePlayer;
use App\CtfConfig;

//Etat : 0 => Attente    1=> Accepté     2=>Refusé       3=>Suspendu        4=>Il a quitté l'equipe        5=>Deux invitions, une des deux a ete acceptés
class TeamController extends Controller
{
    protected $teamRepository;

    public function __construct(TeamRepository $teamRepository){
        $this->teamRepository = $teamRepository;
        $this->middleware(['auth', 'verified','ctf_player']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*If he have a team, we check how many invitation he have*/
        $nb_demand = 0;
        if(Auth::user()->isLeader()){
            $nb_demand = JoinDemand::where('team_id', Auth::user()->team()->id)
                ->where("state", 0)
                ->count();
        }

        /*Number of invitation he receive*/
        $nb_invitation = 0;
        if(Auth::user()->team() == NULL){
            $nb_invitation = InvitePlayer::where('user_id',Auth::user()->id)
                ->where("state", 0)
                ->count();
        }

        $nb_max_player = CtfConfig::first()->max_players_per_team;

        return view('ctf_player.show_team', compact('nb_demand','nb_invitation','nb_max_player'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ctf_player.add_team');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamSubmitRequest $request)
    {
        $request->validated();

        $user = Auth::user();
        $team = new Team;
        $team->user_id = Auth::user()->id;
        $team->team_name = $request->team_name;
        $team->save();
        
        //Les demande d'ahdesion que ce joueur a fait sont suspendus
        JoinDemand::where('user_id', $user->id)
                    ->where('state', 0)
                    ->update(array("state" => 3));

        //Les demandes pour rejoindre une équipe sont suspendus
        InvitePlayer::where('user_id', $user->id)
                    ->where('state', 0)
                    ->update(array("state" => 3));

        $inform = "Your team has been created, you can manage it here";
        return redirect()->route('team.index')->with( ['inform' => $inform]);
    }

    //Get route, display the page of editing
    public function edit(Team $team)
    {
        if(!Auth::user()->isLeaderOf($team)){
            abort(401);
        }

        return view('ctf_player.edit_team',compact('team'));
    }

    //Post route, edit the team
    public function update(TeamSubmitRequest $request, Team $team)
    {
        if(!Auth::user()->isLeaderOf($team)){
            abort(401);
        }

        $team->update($request->validated());

        $inform = "Your team name has been updated";
        return redirect()->route('team.index')->with( ['inform' => $inform]);
    }

    //Post, supprime l'équipe
    public function destroy(Team $team)
    {
        $user = Auth::user();

        if ($user->isLeaderOf($team)) {
            
            $members = $team->members();

            foreach ($members->get() as $member ) {
                InvitePlayer::where('user_id', $member->id)->where('state', 3)->update(array("state" => 0));
                JoinDemand::where('user_id', $member->id)->where('state', 3)->update(array("state" => 0));
            }

            $team->delete();

            $inform = "Your team has been deleted !";
            return redirect()->route('home')->with( ['inform' => $inform, "success" => true]);
        } else {
            abort(401);
        }
    }

    //Post, il quitte son équipe
    public function leave()
    {
        $user = Auth::user();
        $team_id = $user->team()->id;
        
        $bool = $user->team()->isFull();
        
        if ($user->hasTeam() && ( $user->isLeader() === false)) {
            /*Met sa requete accepte a l'etat 4 => il a quitté l'équipe*/
            JoinDemand::where('user_id', $user->id)
                        ->where('team_id', $team_id)
                        ->update(array("state" => 4)); //4 il a quitté l'équipe

            /*Met sa requete accepte a l'etat 4 => il a quitté l'équipe*/
            InvitePlayer::where('user_id', $user->id)
                        ->where('team_id',$team_id)
                        ->update(array("state" => 4)); //4 il a quitté l'équipe

            /*Mets toutes ses autres requetes non accepte en attente*/
            JoinDemand::where('user_id', $user->id)
                        ->where('state', 3)
                        ->update(array("state" => 0));

            /*Mets toutes ses autres requetes non accepte en attente*/
            InvitePlayer::where('user_id', $user->id)
                        ->where('state', 3)
                        ->update(array("state" => 0));

            //If the team was full, then people can now join the team
            if($bool){
                /* les demandes faite par des joueurs pour rejoindre cette team en suspension redeviennent libre*/
                JoinDemand::where('team_id', $team_id)
                ->where('state', 3)
                ->update(array("state" => 0));

                /* les invitations que cette team a fait a d'autre joueur redeviennent libre*/
                InvitePlayer::where('team_id', $team_id)
                    ->where('state', 3)
                    ->update(array("state" => 0));
            }

            return redirect('team'); /* to compute the nb invitation and demand */
        } else {
            abort(404);
        }

    }

    public function choose_team()
    {
        return view('ctf_player.choose_team');
    }

    /**
     * When a player ask to join a team
     */
    public function team_demand(Team $team){
    
        $user = Auth::user();
        $query = JoinDemand::where('user_id',$user->id)
                            ->where('team_id',$team->id)
                            ->where('state', 0)->get();

        if (!$query->first()) {
            // Ajoute une entrée dans la table join demand, avec l'id de l'utilisateur et de la team.
            $joindemand = new JoinDemand;
            $joindemand->user_id = $user->id;
            $joindemand->team_id = $team->id;
            
            if($team->isFull()){
                $joindemand->state = 3; /* la team est pleine => la demande est suspendu */
            }

            $joindemand->save();            
        }
    
        return redirect()->route('team.choose_team')->with( ['team' => $team]);
    }

    /**
     * For the team, to check who ask to join his team.
     */
    public function request_list() {

        //verifier team et leader
        $user = Auth::user();

        if( $user->hasTeam() && $user->isLeaderOf($user->team()) ){
            $team = $user->team(); /*It is the team of the current user*/

            //Get every demands where the id is the same than the id of the team the user create
            $joindemand = JoinDemand::where('team_id', $team->id)->get()->toArray();
    
            //Get every user id
            foreach ($joindemand as $requete => $value ) {
                $joindemand[$requete]["user"] = User::find($value['user_id'])->toArray();
            }
        } else {
            abort(404);
        }

        return view('ctf_player.request_list', compact('joindemand'));
    }

    public function see_user_invite_list() {
        return view('ctf_player.see_user_invite_list');
    }

    /**
     * When a team ask a player to join his team
     */
    public function team_send(User $user) {
        
        $user_current = Auth::user();

        if( !($user_current->hasTeam() && $user_current->isLeaderOf($user_current->team())) ){
            abort(401);
        }

        // Si on trouve : 0 => Attente 1=> Accepté 3=>Suspendu 5=>Deux invitations, une des deux a ete acceptés  C'est qu'on peut pas l'inviter !
        $canIInvitHim = InvitePlayer::where('state', '!=', 2)->where('state', '!=' , 4)
                        ->where('team_id',$user_current->team()->id)
                        ->where('user_id',$user->id)->first();

        if($canIInvitHim){
            abort(401);
        }


        if($user->hasTeam() === false){
            $invitePlayer = new InvitePlayer;
            $invitePlayer->user_id = $user->id;
            $invitePlayer->team_id = $user_current->team()->id;

            if($user_current->team()->isFull()){
                $invitePlayer->state = 3; /* la team est pleine => l'invitation est suspendu */
            }
            
            $invitePlayer->save();
        } else {
            //le joueur a deja une equipe
            $invitePlayer = new InvitePlayer;
            $invitePlayer->user_id = $user->id;
            $invitePlayer->team_id = $user_current->team()->id;

            $invitePlayer->state = 3; /* l'utilisateur est deja dans une team => l'invitation est suspendu */
            
            $invitePlayer->save();
        }

        return redirect()->route('team.see_user_invite_list')->with( ['user_invited' => $user->name]);
    }

    /**
     * Cas ou le joueur a demandé à rejoindre l'équipe et a été accepté
     */
    public function team_accept(User $user){
        //S'il est pas leader de l'equipe on fait rien
        if( !(Auth::user()->hasTeam() && Auth::user()->isLeaderOf(Auth::user()->team())) ){
            abort(401);
        }

        $team = Auth::user()->team(); //Get the id of the team that the user has created
        $id_player_joining = $user->id; //Get the id of the player coming in the team

        if($team->isFull()){
            abort(401);
        }

        //Updating the uplet from the table JoinDemand
        $joindemand = JoinDemand::where('user_id', $id_player_joining)
            ->where('team_id',$team->id)
            ->where('state', 0)
            ->update(array("state" => 1));

        //If POST REQUEST FROM SOMEWHERE ELSE, we check if the request join demand really exist
        if($joindemand == 1){
            //If the player really ask to join the team

            /*Mets toutes ses autres requetes non accepté en suspend*/
            JoinDemand::where('user_id', $id_player_joining)
                        ->where('state', 0)
                        ->update(array("state" => 3));

            //Updating the uplet from the table invitePlayer, case where he has been invited by the team leader
            InvitePlayer::where('user_id',$id_player_joining)
                            ->where('team_id',$team->id)
                            ->where('state', 0)
                            ->update(array("state" => 5)); //state refused too

            /*Mets toutes ses demandes pour rejoindre une equipe en suspend*/
            InvitePlayer::where('user_id', $id_player_joining)
                        ->where('state', 0)
                        ->update(array("state" => 3));

            //Si apres avoir rejoins, l'equipe est pleine, alors les demandes en attente sont passés en suspendu
            if( CtfConfig::first()->max_players_per_team != -1){
                if( $team->isFull() ){
                    JoinDemand::where('team_id', $team->id)->where('state', 0)->update(array("state" => 3));
                    InvitePlayer::where('team_id', $team->id)->where('state', 0)->update(array("state" => 3));
                }
            }
        }

        //Same thing than in team demand, just for display

            //Get every demands where the id is the same than the id of the team the user create
            $joindemand = JoinDemand::where('team_id', $team->id)->get()->toArray();

            //Get every user id
            foreach ($joindemand as $requete => $value ) {
                $joindemand[$requete]["user"] = User::find($value['user_id'])->toArray();
            }

        return view('ctf_player.request_list',compact('joindemand','team'));

    }

    public function team_refuse(User $user){
        //S'il est pas leader de l'equipe on fait rien
        if( !(Auth::user()->hasTeam() && Auth::user()->isLeaderOf(Auth::user()->team())) ){
            abort(401);
        }

        $team = Auth::user()->team(); //Get the team that the user has created
        $id_player_joining = $user->id; //Get the id of the player coming in the team

        //Updating the uplet from the table JoinDemand
        JoinDemand::where('user_id', $id_player_joining)
                    ->where('team_id',$team->id)
                    ->where("state",0)
                    ->update(array("state" => 2));

        //Same thing than in team demand

            //Get every demands where the id is the same than the id of the team the user create
            $joindemand = JoinDemand::where('team_id', $team->id)
                                    ->get()
                                    ->toArray();

            //Get every user id
            foreach ($joindemand as $requete => $value ) {
                $joindemand[$requete]["user"] = User::find($value['user_id'])->toArray();
            }

        return redirect()->route('team.request_list')->with( ['joindemand' => $joindemand]);
    }

    public function see_invitation_list(){
        $user = Auth::user();

        $invitePlayer = InvitePlayer::where("user_id", $user->id )->get()->toArray();

        //Get every team id
        foreach ($invitePlayer as $requete => $value ) {
            $invitePlayer[$requete]["team"] = Team::find($value['team_id'])->toArray();
        }

        return view('ctf_player.see_invitation_list', compact('invitePlayer'));
    }

    public function invite_refuse(Team $team){
        $user = Auth::user();

        //Met l'état en tant que refusé pour toutes les demandes faites
        InvitePlayer::where("user_id", $user->id)
                    ->where("team_id",$team->id)
                    ->where("state",0)
                    ->update(array("state" => 2));

        //Same than in see_invitation_list for display
            $invitePlayer = InvitePlayer::where("user_id", $user->id )->get()->toArray();

            //Get every team id
            foreach ($invitePlayer as $requete => $value ) {
                $invitePlayer[$requete]["team"] = Team::find($value['team_id'])->toArray();
            }

        return redirect()->route('team.see_invitation_list')->with( ['invitePlayer' => $invitePlayer]);
    }

    /**
     * Case where the user accept an invitation from a team
     */
    public function invite_accept(Team $team){
        $user = Auth::user();

        if($team->isFull()){
            abort(401);
        }

        $invitePlayer = InvitePlayer::where('user_id', $user->id)
                                    ->where('team_id',$team->id)
                                    ->where('state', 0)
                                    ->update(array("state" => 1));

        //If POST REQUEST FROM SOMEWHERE ELSE, we check if the request invite player really exist
        if($invitePlayer == 1){

            /*Mets toutes ses autres requetes non accepté en suspend*/
            InvitePlayer::where('user_id', $user->id)
                            ->where('state', 0)
                            ->update(array("state" => 3));

                            
            //Updating the uplet from the table JoinDemand, s'il avait envoyé une demande, elle est accepté automatiquement
            JoinDemand::where('user_id', $user->id)
                        ->where('team_id',$team->id)
                        ->where('state', 0)
                        ->update(array("state" => 5));

            /*Mets toutes ses demandes pour rejoindre une equipe en suspend*/
            JoinDemand::where('user_id', $user->id)
                        ->where('state', 0)
                        ->update(array("state" => 3));

            //Si apres avoir rejoins, l'equipe est pleine, alors les demandes en attente sont passés en suspendu
            if( CtfConfig::first()->max_players_per_team != -1){
                if( $team->isFull() ){
                    JoinDemand::where('team_id', $team->id)
                                ->where('state', 0)
                                ->update(array("state" => 3));
                                
                    InvitePlayer::where('team_id', $team->id)
                                ->where('state', 0)
                                ->update(array("state" => 3));
                }
            }
            
        }
    
        //Same than in see_invitation_list
            $invitePlayer = InvitePlayer::where("user_id", $user->id )->get()->toArray();

            //Get every team id
            foreach ($invitePlayer as $requete => $value ) {
                $invitePlayer[$requete]["team"] = Team::find($value['team_id'])->toArray();
            }

        return redirect()->route('team.see_invitation_list')->with( ['invitePlayer' => $invitePlayer]);
    }
    
    public function __ajax_team(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'team_name' => 'required',
            ]);
            
            $id = Auth::user()->id;
            $teams = Team::where('team_name', 'like', '%'.$request->team_name.'%')
                ->whereNotExists(function($query) use ($id) {
                    $query->select('user_id')
                        ->from('join_demand')
                        ->where('join_demand.user_id', $id)
                        ->where('state', '==' , 0)
                        ->where('state', '==' , 1)
                        ->where('state', '==' , 3)
                        ->whereRaw('join_demand.team_id = team.id');
                })
                ->select("id", "team_name")
                ->get();

            return response()->json($teams);
        }
        
        abort(404);
    }

    public function __ajax_invite_player(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'user_name' => 'required',
            ]);
            
            $id_team = Auth::user()->team()->id;
            
            $users = User::where('name', 'like', '%'.$request->user_name.'%')
                ->where('id','!=', Auth::user()->id) /* Every player except him*/
                ->orderBy('name')
                ->select("name", "id")
                ->get()
                ->toArray();

            foreach($users as $user => $valuser){
                $has_invit_team = FALSE;  

                $lastInvite = InvitePlayer::orderBy('date_invitation')
                    ->where("user_id", $valuser["id"] )
                    ->where("team_id", $id_team)
                    ->first();
                
                if($lastInvite){
                    $users[$user]["state"] = $lastInvite->state;
                }else{
                    $users[$user]["state"] = -1;
                }  
            }


            return response()->json($users);
        }
        
        abort(404);
    }
}
