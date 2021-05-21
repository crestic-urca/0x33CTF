<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use App\CtfConfig;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo()
    {
        if (auth()->user()->admin == 1) {
            return route("admin.config");
        }
        return '/home';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:5', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users','blacklist'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //Check si user ou pas, si pas d'utilisateur on met le premier admin et valider son mail directe
        
        if(User::all()->count() == 0){
            //Met admin
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'admin' => 1,
                'ctf_creator' => 1,
                'ctf_player' => 0,
                'email_verified_at' => now()
            ]);
        } else {

            if(CtfConfig::all()->count() == 1){
                $conf = CtfConfig::first();

                if($conf->email_verification == 0){
                    return User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'password' => Hash::make($data['password']),
                        'admin' => 0,
                        'ctf_creator' => 0, 
                        'ctf_player' => 1,
                        'email_verified_at' => now()
                    ]);
                }
            }

            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'admin' => 0,
                'ctf_creator' => 0, 
                'ctf_player' => 1
            ]);
        }


    }
}
