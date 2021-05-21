<?php

namespace App\Repositories;

use App\Categorie;

class CategorieRepository
{

    protected $categorie;

    public function __construct(Categorie $categorie)
	{
		$this->categorie = $categorie;
	}

	public function getPaginate($n)
	{
		return $this->categorie->with('user')
		->orderBy('categories.created_at', 'desc')
		->paginate($n);
	}

	public function store($inputs)
	{
		return $this->categorie->create($inputs);
	}

	public function destroy($id)
	{
        $this->categorie->findOrFail($id)->delete();
    }

    public function destroy_categorie($id)
	{
        $this->categorie->findOrFail($id)->delete();
    }

    public function getById($id)
	{
		return $this->categorie->findOrFail($id);
	}

  public function update($id, Array $inputs)
  {
    $this->save($this->getById($id), $inputs);
  }

  private function save(Categorie $categorie, Array $inputs)
  {
    $categorie->nom_categorie = $inputs['nom_categorie'];
    $categorie->save();
  }


}
