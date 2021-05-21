<?php

namespace App\Repositories;

use App\Sujet;

class SujetRepository
{

    protected $sujet;

    public function __construct(Sujet $sujet)
	{
        $this->sujet = $sujet;
	}

	public function getPaginate($n)
	{
		return $this->sujet->with('user')
		->orderBy('sujets.created_at', 'desc')
		->paginate($n);
    }

    function mynl2br($text) {
        return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />'));
    }

	public function store($inputs)
	{
        //To keep the \n that are put in the textarea, we have to replace them by <br>, so we use nl2br from php
        // foreach ($inputs as $key => $value) {
        //     if ($key == "enonce"){
        //         $temp = nl2br($value);
        //         $value = $temp;
        //     }
        // }
		return $this->sujet->create($inputs);
	}

	public function destroy($id)
	{
        $this->sujet->findOrFail($id)->delete();
	}

  public function getById($id)
	{
		return $this->sujet->findOrFail($id);
	}

  public function update($id, Array $inputs)
  {
    $this->save($this->getById($id), $inputs);
  }

  private function save(Sujet $sujet, Array $inputs)
  {
    $sujet->enonce = $inputs['enonce'];
    $sujet->titre = $inputs['titre'];
    $sujet->flag = $inputs['flag'];
    $sujet->categorie_id = $inputs['categorie_id'];
    $sujet->nb_points = $inputs['nb_points'];
    $sujet->file_name = $inputs['file_name'];
    $sujet->nb_try = $inputs['nb_try'];

    $sujet->save();
  }


}
