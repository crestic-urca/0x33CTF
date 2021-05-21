<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CtfConfig;
use League\CommonMark\CommonMarkConverter;

class RootController extends Controller
{
    public function __construct()
    {
        $this->converter = new CommonMarkConverter();
    }

    /**
     * GET : /      Main page of our website
     */
    public function index(){
        $config = CtfConfig::first();

        if ($config) {
            $config->description = $this->converter->convertToHtml($config->description);
        }
        
        return view('root', compact('config'));
    }

}
