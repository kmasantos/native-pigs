<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Farm;
use App\Models\Breed;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
      $this->user = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Auth::user();
        $farms = Farm::all();
        $breeds = Breed::all();
        $users = User::where("isadmin", 0)->get();
        $now = Carbon::now('Asia/Manila');

        $logins = [];
        foreach ($users as $user) {
            array_push($logins, $user->lastseen);
        }
        $latest_login = last(array_sort($logins));

        $latest_user = User::where("lastseen", $latest_login)->first();

        $admin->lastseen = $now;
        $admin->save();
        return view('user.admin.home', compact('admin', 'farms', 'breeds', 'users', 'now', 'latest_login', 'latest_user'));
    }

    public function getBreedMgtPage(){
        $now = Carbon::now('Asia/Manila');
        $breeds = Breed::all();

        return view('user.admin.breedmanagement', compact('now', 'breeds'));
    }

    public function fetchNewBreed(Request $request){
        $now = Carbon::now('Asia/Manila');
        $breeds = Breed::all();

        $name = $request->new_breed;

        $conflict = [];
        foreach ($breeds as $breed) {
            if($breed->breed == $name){
                array_push($conflict, "1");
            }
            else{
                array_push($conflict, "0");
            }
        }

        if(!in_array("1", $conflict, false)){
            $new_breed = new Breed;
            $new_breed->breed = $name;
            $new_breed->animaltype_id = 3;
            $new_breed->save();

            $message = "Successfully added new breed!";
            return view('user.admin.breedmanagement', compact('now', 'breeds'))->withMessage($message);
        }
        else{
            $message = "Breed name already exists!";
            return view('user.admin.breedmanagement', compact('now', 'breeds'))->withError($message);
        }

    }

    public function editBreed(Request $request){
        $now = Carbon::now('Asia/Manila');
        $breeds = Breed::all();
        $this_breed = Breed::find($request->breed_id);

        $name = $request->breed;

        $conflict = [];
        foreach ($breeds as $breed) {
            if($breed->breed == $name){
                array_push($conflict, "1");
            }
            else{
                array_push($conflict, "0");
            }
        }

        if(!in_array("1", $conflict, false)){
            $message = "Successfully edited breed ".$this_breed->breed."!";

            $this_breed->breed = $name;
            $this_breed->save();

            return view('user.admin.breedmanagement', compact('now', 'breeds'))->withMessage($message);
        }
        else{
            $message = "Breed name already exists!";
            return view('user.admin.breedmanagement', compact('now', 'breeds'))->withError($message);
        }
    }

    public function getFarmMgtPage(){
        $now = Carbon::now('Asia/Manila');
        $farms = Farm::all();
        $breeds = Breed::all();

        return view('user.admin.farmmanagement', compact('now', 'farms', 'breeds'));
    }

    public function fetchNewFarm(Request $request){
        $name = $request->new_name;

        $name_split = explode(" ", $name);
        $initials = "";

        foreach ($name_split as $n) {
          $initials .= $n[0];
        }

        $province = $request->new_province;
        $breed = Breed::find($request->new_breed);

        switch ($province) {
            case "Ilocos Norte":
                $farm_code = "ILN".$initials;
                break;
            case "Ilocos Sur":
                $farm_code = "ILS".$initials;
                break;
            case "La Union":
                $farm_code = "LUN".$initials;
                break;
            case "Pangasinan":
                $farm_code = "PAN".$initials;
                break;
            case "Batanes":
                $farm_code = "BTN".$initials;
                break;
            case "Cagayan":
                $farm_code = "CAG".$initials;
                break;
            case "Isabela":
                $farm_code = "ISA".$initials;
                break;
            case "Nueva Vizcaya":
                $farm_code = "NUV".$initials;
                break;
            case "Quirino":
                $farm_code = "QUI".$initials;
                break;
            case "Abra":
                $farm_code = "ABR".$initials;
                break;
            case "Apayao":
                $farm_code = "APA".$initials;
                break;
            case "Benguet":
                $farm_code = "BEN".$initials;
                break;
            case "Ifugao":
                $farm_code = "IFU".$initials;
                break;
            case "Kalinga":
                $farm_code = "KA".$initials;
                break;
            case "Mountain Province":
                $farm_code = "MOU".$initials;
                break;
            case "Aurora":
                $farm_code = "AUR".$initials;
                break;
            case "Bataan":
                $farm_code = "BAN".$initials;
                break;
            case "Bulacan":
                $farm_code = "BUL".$initials;
                break;
            case "Nueva Ecija":
                $farm_code = "NUE".$initials;
                break;
            case "Pampanga":
                $farm_code = "PAM".$initials;
                break;
            case "Tarlac":
                $farm_code = "TAR".$initials;
                break;
            case "Zambales":
                $farm_code = "ZAM".$initials;
                break;
            case "Metro Manila":
                $farm_code = "NCR".$initials;
                break;
            case "Batangas":
                $farm_code = "BTG".$initials;
                break;
            case "Cavite":
                $farm_code = "CAV".$initials;
                break;
            case "Laguna":
                $farm_code = "LAG".$initials;
                break;
            case "Quezon":
                $farm_code = "QUE".$initials;
                break;
            case "Rizal":
                $farm_code = "RIZ".$initials;
                break;
            case "Marinduque":
                $farm_code = "MAR".$initials;
                break;
            case "Occidental Mindoro":
                $farm_code = "MDC".$initials;
                break;
            case "Oriental Mindoro":
                $farm_code = "MDR".$initials;
                break;
            case "Palawan":
                $farm_code = "PLW".$initials;
                break;
            case "Romblon":
                $farm_code = "ROM".$initials;
                break;
            case "Albay":
                $farm_code = "ALB".$initials;
                break;
            case "Camarines Norte":
                $farm_code = "CAN".$initials;
                break;
            case "Camarines Sur":
                $farm_code = "CAS".$initials;
                break;
            case "Catanduanes":
                $farm_code = "CAT".$initials;
                break;
            case "Masbate":
                $farm_code = "MAS".$initials;
                break;
            case "Sorsogon":
                $farm_code = "SOR".$initials;
                break;
            case "Aklan":
                $farm_code = "AKL".$initials;
                break;
            case "Antique":
                $farm_code = "ANT".$initials;
                break;
            case "Capiz":
                $farm_code = "CAP".$initials;
                break;
            case "Guimaras":
                $farm_code = "GUI".$initials;
                break;
            case "Iloilo":
                $farm_code = "ILI".$initials;
                break;
            case "Negros Occidental":
                $farm_code = "NEC".$initials;
                break;
            case "Bohol":
                $farm_code = "BOH".$initials;
                break;
            case "Cebu":
                $farm_code = "CEB".$initials;
                break;
            case "Siquijor":
                $farm_code = "SIG".$initials;
                break;
            case "Negros Oriental":
                $farm_code = "NER".$initials;
                break;
            case "Eastern Samar":
                $farm_code = "EAS".$initials;
                break;
            case "Leyte":
                $farm_code = "LEY".$initials;
                break;
            case "Northern Samar":
                $farm_code = "NSA".$initials;
                break;
            case "Samar":
                $farm_code = "WSA".$initials;
                break;
            case "Southern Leyte":
                $farm_code = "SLE".$initials;
                break;
            case "Zamboanga del Norte":
                $farm_code = "ZAN".$initials;
                break;
            case "Zamboanga del Sur":
                $farm_code = "ZAS".$initials;
                break;
            case "Zamboanga Sibugay":
                $farm_code = "ZSI".$initials;
                break;
            case "Bukidnon":
                $farm_code = "BUK".$initials;
                break;
            case "Camiguin":
                $farm_code = "CAM".$initials;
                break;
            case "Lanao del Norte":
                $farm_code = "LAN".$initials;
                break;
            case "Misamis Occidental":
                $farm_code = "MSC".$initials;
                break;
            case "Misamis Oriental":
                $farm_code = "MSR".$initials;
                break;
            case "Compostela Valley":
                $farm_code = "COM".$initials;
                break;
            case "Davao del Norte":
                $farm_code = "DAV".$initials;
                break;
            case "Davao del Sur":
                $farm_code = "DAS".$initials;
                break;
            case "Davao Occidental":
                $farm_code = "DVO".$initials;
                break;
            case "Davao Oriental":
                $farm_code = "DAO".$initials;
                break;
            case "Cotabato":
                $farm_code = "NCO".$initials;
                break;
            case "Sarangani":
                $farm_code = "SAR".$initials;
                break;
            case "South Cotabato":
                $farm_code = "SCO".$initials;
                break;
            case "Sultan Kudarat":
                $farm_code = "SUK".$initials;
                break;
            case "Agusan del Norte":
                $farm_code = "AGN".$initials;
                break;
            case "Agusan del Sur":
                $farm_code = "AGS".$initials;
                break;
            case "Dinagat Islands":
                $farm_code = "DIN".$initials;
                break;
            case "Surigao del Norte":
                $farm_code = "SUN".$initials;
                break;
            case "Surigao del Sur":
                $farm_code = "SUR".$initials;
                break;
            case "Basilan":
                $farm_code = "BAS".$initials;
                break;
            case "Lanao del Sur":
                $farm_code = "LAS".$initials;
                break;
            case "Maguindanao":
                $farm_code = "MAG".$initials;
                break;
            case "Sulu":
                $farm_code = "SLU".$initials;
                break;
            case "Tawi-Tawi":
                $farm_code = "TAW".$initials;
                break;
        }

        $new_farm = new Farm;
        $new_farm->name = $name;
        $new_farm->code = $farm_code;
        $new_farm->province = $province;
        $new_farm->breedable_id = $breed->id;
        $new_farm->save();

        return Redirect::back()->with('message', 'Farm added successfully!');
    }

    public function editFarm(Request $request){
        $farm = Farm::find($request->farm_id);

        $name = $request->name;

        $name_split = explode(" ", $name);
        $initials = "";

        foreach ($name_split as $n) {
          $initials .= $n[0];
        }

        $province = $request->province;
        $breed = Breed::find($request->breed);

        switch ($province) {
            case "Ilocos Norte":
                $farm_code = "ILN".$initials;
                break;
            case "Ilocos Sur":
                $farm_code = "ILS".$initials;
                break;
            case "La Union":
                $farm_code = "LUN".$initials;
                break;
            case "Pangasinan":
                $farm_code = "PAN".$initials;
                break;
            case "Batanes":
                $farm_code = "BTN".$initials;
                break;
            case "Cagayan":
                $farm_code = "CAG".$initials;
                break;
            case "Isabela":
                $farm_code = "ISA".$initials;
                break;
            case "Nueva Vizcaya":
                $farm_code = "NUV".$initials;
                break;
            case "Quirino":
                $farm_code = "QUI".$initials;
                break;
            case "Abra":
                $farm_code = "ABR".$initials;
                break;
            case "Apayao":
                $farm_code = "APA".$initials;
                break;
            case "Benguet":
                $farm_code = "BEN".$initials;
                break;
            case "Ifugao":
                $farm_code = "IFU".$initials;
                break;
            case "Kalinga":
                $farm_code = "KA".$initials;
                break;
            case "Mountain Province":
                $farm_code = "MOU".$initials;
                break;
            case "Aurora":
                $farm_code = "AUR".$initials;
                break;
            case "Bataan":
                $farm_code = "BAN".$initials;
                break;
            case "Bulacan":
                $farm_code = "BUL".$initials;
                break;
            case "Nueva Ecija":
                $farm_code = "NUE".$initials;
                break;
            case "Pampanga":
                $farm_code = "PAM".$initials;
                break;
            case "Tarlac":
                $farm_code = "TAR".$initials;
                break;
            case "Zambales":
                $farm_code = "ZAM".$initials;
                break;
            case "Metro Manila":
                $farm_code = "NCR".$initials;
                break;
            case "Batangas":
                $farm_code = "BTG".$initials;
                break;
            case "Cavite":
                $farm_code = "CAV".$initials;
                break;
            case "Laguna":
                $farm_code = "LAG".$initials;
                break;
            case "Quezon":
                $farm_code = "QUE".$initials;
                break;
            case "Rizal":
                $farm_code = "RIZ".$initials;
                break;
            case "Marinduque":
                $farm_code = "MAR".$initials;
                break;
            case "Occidental Mindoro":
                $farm_code = "MDC".$initials;
                break;
            case "Oriental Mindoro":
                $farm_code = "MDR".$initials;
                break;
            case "Palawan":
                $farm_code = "PLW".$initials;
                break;
            case "Romblon":
                $farm_code = "ROM".$initials;
                break;
            case "Albay":
                $farm_code = "ALB".$initials;
                break;
            case "Camarines Norte":
                $farm_code = "CAN".$initials;
                break;
            case "Camarines Sur":
                $farm_code = "CAS".$initials;
                break;
            case "Catanduanes":
                $farm_code = "CAT".$initials;
                break;
            case "Masbate":
                $farm_code = "MAS".$initials;
                break;
            case "Sorsogon":
                $farm_code = "SOR".$initials;
                break;
            case "Aklan":
                $farm_code = "AKL".$initials;
                break;
            case "Antique":
                $farm_code = "ANT".$initials;
                break;
            case "Capiz":
                $farm_code = "CAP".$initials;
                break;
            case "Guimaras":
                $farm_code = "GUI".$initials;
                break;
            case "Iloilo":
                $farm_code = "ILI".$initials;
                break;
            case "Negros Occidental":
                $farm_code = "NEC".$initials;
                break;
            case "Bohol":
                $farm_code = "BOH".$initials;
                break;
            case "Cebu":
                $farm_code = "CEB".$initials;
                break;
            case "Siquijor":
                $farm_code = "SIG".$initials;
                break;
            case "Negros Oriental":
                $farm_code = "NER".$initials;
                break;
            case "Eastern Samar":
                $farm_code = "EAS".$initials;
                break;
            case "Leyte":
                $farm_code = "LEY".$initials;
                break;
            case "Northern Samar":
                $farm_code = "NSA".$initials;
                break;
            case "Samar":
                $farm_code = "WSA".$initials;
                break;
            case "Southern Leyte":
                $farm_code = "SLE".$initials;
                break;
            case "Zamboanga del Norte":
                $farm_code = "ZAN".$initials;
                break;
            case "Zamboanga del Sur":
                $farm_code = "ZAS".$initials;
                break;
            case "Zamboanga Sibugay":
                $farm_code = "ZSI".$initials;
                break;
            case "Bukidnon":
                $farm_code = "BUK".$initials;
                break;
            case "Camiguin":
                $farm_code = "CAM".$initials;
                break;
            case "Lanao del Norte":
                $farm_code = "LAN".$initials;
                break;
            case "Misamis Occidental":
                $farm_code = "MSC".$initials;
                break;
            case "Misamis Oriental":
                $farm_code = "MSR".$initials;
                break;
            case "Compostela Valley":
                $farm_code = "COM".$initials;
                break;
            case "Davao del Norte":
                $farm_code = "DAV".$initials;
                break;
            case "Davao del Sur":
                $farm_code = "DAS".$initials;
                break;
            case "Davao Occidental":
                $farm_code = "DVO".$initials;
                break;
            case "Davao Oriental":
                $farm_code = "DAO".$initials;
                break;
            case "Cotabato":
                $farm_code = "NCO".$initials;
                break;
            case "Sarangani":
                $farm_code = "SAR".$initials;
                break;
            case "South Cotabato":
                $farm_code = "SCO".$initials;
                break;
            case "Sultan Kudarat":
                $farm_code = "SUK".$initials;
                break;
            case "Agusan del Norte":
                $farm_code = "AGN".$initials;
                break;
            case "Agusan del Sur":
                $farm_code = "AGS".$initials;
                break;
            case "Dinagat Islands":
                $farm_code = "DIN".$initials;
                break;
            case "Surigao del Norte":
                $farm_code = "SUN".$initials;
                break;
            case "Surigao del Sur":
                $farm_code = "SUR".$initials;
                break;
            case "Basilan":
                $farm_code = "BAS".$initials;
                break;
            case "Lanao del Sur":
                $farm_code = "LAS".$initials;
                break;
            case "Maguindanao":
                $farm_code = "MAG".$initials;
                break;
            case "Sulu":
                $farm_code = "SLU".$initials;
                break;
            case "Tawi-Tawi":
                $farm_code = "TAW".$initials;
                break;
        }

        $farm->name = $name;
        $farm->code = $farm_code;
        $farm->province = $province;
        $farm->breedable_id = $breed->id;
        $farm->save();

        return Redirect::back()->with('message', 'Farm edited successfully!');
    }

    public function getUserMgtPage(){
        $now = Carbon::now('Asia/Manila');
        $users = User::where("isadmin", 0)->get();
        $farms = Farm::all();

        return view('user.admin.usermanagement', compact('now', 'users', 'farms'));
    }

    public function fetchNewUser(Request $request){
        $now = Carbon::now('Asia/Manila');
        $users = User::where("isadmin", 0)->get();
        $pool = User::all();
        $farms = Farm::all();

        $email = $request->new_user_email;
        $farm = Farm::find($request->new_farm);

        $conflict = [];
        foreach ($pool as $user) {
            if($user->email == $email){
                array_push($conflict, "1");
            }
            else{
                array_push($conflict, "0");
            }
        }

        if(!in_array("1", $conflict, false)){
            $new_user = new User;
            $new_user->name = $request->new_username;
            $new_user->email = $email;
            $new_user->isadmin = 0;
            $new_user->farmable_id = $farm->id;
            $farm->users()->save($new_user);
            $new_user->save();

            $message = "Successfully added new user!";
            return view('user.admin.usermanagement', compact('now', 'users', 'farms'))->withMessage($message);
        }
        else{
            $message = "Email already exists!";
            return view('user.admin.usermanagement', compact('now', 'users', 'farms'))->withError($message);
        }
        
    }

    public function editUser(Request $request){
        $now = Carbon::now('Asia/Manila');
        $users = User::all();
        $farms = Farm::all();

        $user = User::find($request->user_id);

        $email = $request->user_email;


        $user->name = $request->username;
        $user->email = $email;
        $user->save();

        return Redirect::back()->with('message', 'User edited successfully!');
    }

    public function deleteUser(Request $request){
        $now = Carbon::now('Asia/Manila');
        $users = User::all();
        $farms = Farm::all();

        $user = User::withTrashed()->find($request->user_id);

        $action = '';
        if (empty($user->deleted_at)) {
            $user->delete();
            $action = 'deleted';
        } else {
            $user->restore();
            $action = 'restored';
        }
 
        return Redirect::back()->with('message', 'User '.$action.' successfully!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
