<?php

namespace App\Http\Controllers;

use App\User;
use App\Team;
use App\ValidatedChall;
use App\Sujet;
use Illuminate\Http\Request;
use App\CtfConfig;
use League\CommonMark\CommonMarkConverter;

class HelpController extends Controller
{
    public function __construct()
    {
        $this->converter = new CommonMarkConverter();
    }

    /**
     * GET URL : /help   Showing the help page for the ctf maker
     */
    public function index()
    {          
        $config = CtfConfig::first();

        if ($config) {
            $config->description = $this->converter->convertToHtml($config->description);
        }
        return view('help.index',compact('config'));
    }

}