<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Socialite;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function loginLink($token, Request $request)
    {
        $user = User::where('login_token', $token)->firstOrFail();
        $expiration = explode('-', $token);
        $expiration = array_pop($expiration);
        if ($expiration > time()) {
            Auth::login($user);
            $user->login_token = null;
            $user->save();
            return redirect()->action('FarmController@index');
        } else {
            abort(404);
        }
    }

    /**
     * Obtain the user information from Google.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $findUser = User::where('email', $user->email)->first();
        // Auth::login($findUser, false);
        if (!is_null($findUser)) {
            if ($findUser->isadmin) {
                Auth::login($findUser, true);
                return redirect()->action('AdminController@index');
            } else {
                Auth::login($findUser, true);
                return redirect()->action('FarmController@index');
            }
        } else {
            return redirect('/');
        }
        // if(!is_null($findUser)){
        //   if($findUser->isadmin){
        //     dd("Admin Page Redirect");
        //   }else{
        //     if($findUser->farmprofile){
        //       return view('home', compact('findUser'));
        //     }else{
        //       return("Update Profile Redirect Page");
        //     }
        //
        //   }
        // }else{
        //    return view('loginredirect');
        // }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
