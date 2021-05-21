<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CtfConfig extends Model
{
    public $timestamps = false;
    protected $table = 'ctf_config';
    protected $fillable = ['name', 'email_verification','date_start','date_end','max_players_per_team'];
}
