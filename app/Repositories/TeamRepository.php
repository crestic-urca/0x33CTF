<?php

namespace App\Repositories;

use App\Team;
use App\CtfConfig;

class TeamRepository
{

    protected $team;

    public function __construct(Team $team)
	{
		$this->team = $team;
	}

	public function getPaginate($n)
	{
		return $this->team->with('user')
		->orderBy('teams.created_at', 'desc')
		->paginate($n);
	}

	public function store($inputs)
	{
		return $this->team->create($inputs);
	}

	public function destroy($id)
	{
        $this->team->findOrFail($id)->delete();
    }

    public function destroy_team($id)
	{
        $this->team->findOrFail($id)->delete();
    }

    public function getById($id)
	{
		return $this->team->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
	$this->save($this->getById($id), $inputs);
	}

	private function save(Team $team, Array $inputs)
	{
		$team->team_name = $inputs['team_name'];
		$team->save();
	}


}
