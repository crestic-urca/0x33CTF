<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SujetSubmitRequest;
use App\Sujet;
use App\Categorie;

use Auth;


class SujetController extends Controller
{

    public function __construct(){
        $this->middleware(['auth', 'verified', 'ctf_creator']);
    }

    /**
     * 
     */
    public function index()
    {
        $creator = Auth::user();
        $sujets = $creator->sujets; // We get every challenge from this user

        $categories = Categorie::all();

        return view('ctf_creator.index',compact('sujets','categories'));
    }

    public function create()
    {
        //recup les categories et les envoyer dans la view
        $categories = Categorie::pluck('nom_categorie', 'id');
        return view('ctf_creator.add',compact('categories'));
    }

    public function store(SujetSubmitRequest $request)
    {
        $fields = $request->validated();
        $fields['user_id'] = Auth::id();

        $file = $request->file_attachment;
        if ($file != NULL) {
            $filename = $file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $fields['file_name'] = $filename;
        }

        Sujet::create($fields);

        $inform = "The subject ". $request->titre . " has been created !";
        return redirect()->route('subjects.index')->with(compact('inform'));    
    }

    public function edit(Sujet $sujet)
    {
        if (Auth::user()->id != $sujet->user_id) {
            if (!Auth::user()->admin) {
                abort(401);
            }        
        }

        $categories = Categorie::pluck('nom_categorie', 'id');
        return view('ctf_creator.edit',compact('sujet','categories'));
    }

    public function update(SujetSubmitRequest $request, Sujet $sujet)
    {
        if (Auth::user()->id != $sujet->user_id) {
            if (!Auth::user()->admin) {
                abort(401);
            }
        }

        $fields = $request->validated();
        $fields['file_name'] = null;

        // TODO test with attachement unchanged
        if ($sujet->file_name != null) {
            unlink(storage_path('app/public/' . $sujet->file_name));
        }

        if ($request->file_attachment != NULL) {
            $request->file_attachment->storeAs('public', $request->file_attachment->getClientOriginalName());
            $fields['file_name'] = $request->file_attachment->getClientOriginalName();
        }

        $sujet->update($fields);

        $inform = "The subject ". $sujet->titre . " has been updated !";
        return redirect()->route('home')->with(compact('inform'));        
    }


    public function destroy(Sujet $sujet)
    {
        //If he is not the one who made the chall or he is not admin
        if (Auth::user()->id != $sujet->user_id ) {
            if (!Auth::user()->admin) {
                abort(401);
            }
        }
        // if there is a file, we can unlink it
        if ($sujet->file_name != NULL) {
            unlink(storage_path('app/public/' . $sujet->file_name));
        }

        $sujet->delete();

        $inform = "The subject ". $sujet->titre . " has been deleted !";
        return redirect()->route('home')->with(compact('inform'));        
    }



}
