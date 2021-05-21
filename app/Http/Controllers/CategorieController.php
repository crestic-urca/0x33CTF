<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategorieSubmitRequest;
use App\Repositories\CategorieRepository;
use Illuminate\Http\Request;

use App\User;
use App\Sujet;
use App\Categorie;

class CategorieController extends Controller
{

    protected $categorieRepository;

    //Only an admin can access those functions
    public function __construct(CategorieRepository $categorieRepository ){
        $this->categorieRepository = $categorieRepository;
        $this->middleware(['auth', 'verified','admin']);
    }

    /**
     * POST Used to create a new category
     */
    public function store(CategorieSubmitRequest $request)
    {
        $inputs = array_merge($request->all());

        $this->categorieRepository->store($inputs);

        $inform = "The category has been created !";
        return redirect()->back()->with(compact('inform'));
    }

    /**
     * POST Used to delete a category
     */
    public function destroy($id)
    {
        $this->categorieRepository->destroy_categorie($id);

        $inform = "The category has been deleted !";
        return redirect()->back()->with(compact('inform'));    
    }

}
