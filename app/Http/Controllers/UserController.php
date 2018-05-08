<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Create new UserController instance
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Redirect user to a specified controller according to role
     *
     * @return  Redirect/View
     */
    public function index(Request $request)
    {
        $user = $request->user();
        // if($user->hasRole('breeder')) return redirect()->action('BreederController@index');
        // else if($user->hasRole('admin')) return redirect()->action('AdminController@index');
        // else if($user->hasRole('spectator')) return redirect()->action('SpectatorController@index');
        // else if($user->hasRole('customer')) {
        //     if(!$user->email_verified){
        //         $data = [
        //             'email' => $user->email,
        //             'verCode' => $user->verCode,
        //             'type' => 'verify'
        //         ];
        //         return view('emails.message', $data);
        //     }
        //     return redirect()->action('CustomerController@index');
        // }
        // else redirect()->route('logout');
    }
}
