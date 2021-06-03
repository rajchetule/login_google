<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Exception;
use App\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

     public function handleGoogleCallback()
    {


        $user = Socialite::driver('google')->stateless()->user();

        $finduser = User::where('google_id', $user->id)->first();

        if($finduser){

            Auth::login($finduser);

            return redirect('/home');

        }else{

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456789'),
                ]);

                Auth::login($newUser);

                return redirect('/home');
            }


    }
}
