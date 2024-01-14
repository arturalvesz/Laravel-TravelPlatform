<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Photo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;


class GoogleController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->stateless()->user();

            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){
                Auth::login($finduser);
                return redirect('/');

            }else{
                $password=Hash::make(Str::random(5));
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'usertype' => 'traveler',
                    'password' => $password,
                ]);

                $photoUrl = $user->getAvatar();
                $photoContents = file_get_contents($photoUrl);
                $photoPath = '/public/images/' . $user->email . '.jpg';
                Storage::put($photoPath, $photoContents);
                $photo = new Photo;
                $photo->name= Hash::make(Str::random(5));
                $photo->user_id = $newUser->getKey();
                $photo->path = $user->email . '.jpg';
                $newUser->photo()->save($photo);
                $photo->save();
                Auth::login($newUser);
                return redirect('/');
            }
        } catch (Exception $e) {
            dd($e);
        }
    }
}