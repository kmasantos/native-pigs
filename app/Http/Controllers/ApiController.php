<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Farm;
use App\Models\Animal;
use App\Models\Property;
use App\Models\AnimalType;
use App\Models\AnimalProperty;
use App\Models\Breed;
use App\Models\Grouping;
use App\Models\GroupingMember;
use App\Models\GroupingProperty;
use App\Mortality;
use App\Sale;
use App\RemovedAnimal;
use App\Uploads;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\Http\Controllers\HelperController;
use Input;
use PDF;


class ApiController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function($request, $next){
                $this->user = Auth::user();
                return $next($request);
        });
    }

    public function getAllFarms(){
        return Farm::get();  
    }

    public function fetchNewPigRecord(Request $request){ // function to add new pig
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $pigs = Animal::where("animaltype_id", 3)
                    ->where("breed_id", $breed->id)
                    ->pluck('registryid')
                    ->toArray();    

        $temp_earnotch = $request->earnotch;
        $registrationid = "";
        if(strlen($temp_earnotch) > 6){
            $message = "Earnotch is up to 6 characters only!";
            return view('pigs.addpig')->withError($message);
        }
        else{
            if(strlen($temp_earnotch) == 6){
                $earnotch = $temp_earnotch;
            }
            else{
                $earnotch = str_pad($temp_earnotch, 6, "0", STR_PAD_LEFT);
            }
        }
        $sex = $request->sex;

        if(is_null($request->date_farrowed)){
            $registrationid = $farm->code.$breed->breed."-".$sex.$earnotch;
        }
        else{
            $birthdayValue = new Carbon($request->date_farrowed);
            $registrationid = $farm->code.$breed->breed."-".$birthdayValue->year.$sex.$earnotch;
        }


        $conflict = [];
        foreach ($pigs as $pig) {
            if($pig == $registrationid){
                array_push($conflict, "1");
            }
            else{
                array_push($conflict, "0");
            }
        }

        // dd($conflict, in_array("1", $conflict, false));

        if(!in_array("1", $conflict, false)){
            $newpig = new Animal;
            $newpig->animaltype_id = 3;
            $newpig->registryid = $registrationid;
            $newpig->farm_id = $farm->id;
            $newpig->breed_id = $breed->id;
            $newpig->status = $request->status;
            $newpig->save();

            $earnotchproperty = new AnimalProperty;
            $earnotchproperty->animal_id = $newpig->id;
            $earnotchproperty->property_id = 1;
            $earnotchproperty->value = $earnotch;
            $earnotchproperty->save();

            $sex = new AnimalProperty;
            $sex->animal_id = $newpig->id;
            $sex->property_id = 2;
            $sex->value = $request->sex;
            $sex->save();

            if(is_null($request->date_farrowed)){
                $bdayValue = "Not specified";
            }
            else{
                $bdayValue = $request->date_farrowed;
            }

            $birthdayproperty = new AnimalProperty;
            $birthdayproperty->animal_id = $newpig->id;
            $birthdayproperty->property_id = 3;
            $birthdayproperty->value = $bdayValue;
            $birthdayproperty->save();

            $registrationidproperty = new AnimalProperty;
            $registrationidproperty->animal_id = $newpig->id;
            $registrationidproperty->property_id = 4;
            $registrationidproperty->value = $registrationid;
            $registrationidproperty->save();


            if(is_null($request->birth_weight)){
                $birthWeightValue = "";
            }
            else{
                $birthWeightValue = $request->birth_weight;
            }

            $birthweight = new AnimalProperty;
            $birthweight->animal_id = $newpig->id;
            $birthweight->property_id = 5;
            $birthweight->value = $birthWeightValue;
            $birthweight->save();

            if(is_null($request->date_weaned)){
                $dateWeanedValue = "Not specified";
            }
            else{
                $dateWeanedValue = $request->date_weaned;
            }

            $date_weaned = new AnimalProperty;
            $date_weaned->animal_id = $newpig->id;
            $date_weaned->property_id = 6;
            $date_weaned->value = $dateWeanedValue;
            $date_weaned->save();

            if(is_null($request->weaning_weight)){
                $weaningWeightValue = "";
            }
            else{
                $weaningWeightValue = $request->weaning_weight;
            }

            $weaningweight = new AnimalProperty;
            $weaningweight->animal_id = $newpig->id;
            $weaningweight->property_id = 7;
            $weaningweight->value = $weaningWeightValue;
            $weaningweight->save();

            $pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
            $founddam = 0;
            $foundsire = 0;

            if(!is_null($request->dam) && !is_null($request->sire)){
                $grouping = new Grouping;
                $temp_earnotch_dam = $request->dam;
                if(strlen($temp_earnotch_dam) == 6){
                    $earnotch_dam = $temp_earnotch_dam;
                }
                else{
                    $earnotch_dam = str_pad($temp_earnotch_dam, 6, "0", STR_PAD_LEFT);
                }
                $temp_earnotch_sire = $request->sire;
                if(strlen($temp_earnotch_sire) == 6){
                    $earnotch_sire = $temp_earnotch_sire;
                }
                else{
                    $earnotch_sire = str_pad($temp_earnotch_sire, 6, "0", STR_PAD_LEFT);
                }

                foreach ($pigs as $pig) { // searches database for pig with same earnotch
                    if(substr($pig->registryid, -6, 6) == $earnotch_dam){
                        $grouping->registryid = $pig->registryid;
                        $grouping->mother_id = $pig->id;
                        $founddam = 1;
                    }
                    if(substr($pig->registryid, -6, 6) == $earnotch_sire){
                        $grouping->father_id = $pig->id;
                        $foundsire = 1;
                    }
                }

                // if dam and/or father are not in the database, it will just be the new pig's property
                if($founddam != 1){
                    $dam = new AnimalProperty;
                    $dam->animal_id = $newpig->id;
                    $dam->property_id = 8;
                    $dam->value = $farm->code.$breed->breed."-"."F".$earnotch_dam;
                    $dam->save();
                }
                if($foundsire != 1){
                    $sire = new AnimalProperty;
                    $sire->animal_id = $newpig->id;
                    $sire->property_id = 9;
                    $sire->value = $farm->code.$breed->breed."-"."M".$earnotch_sire;
                    $sire->save();
                }
                // if parents are found, this will create a new breeding record available for viewing in the Breeding Records page
                if($founddam == 1 || $foundsire == 1){
                    $grouping->breed_id = $breed->id;
                    $grouping->members = 1;
                    $grouping->save();

                    $groupingmember = new GroupingMember;
                    $groupingmember->grouping_id = $grouping->id;
                    $groupingmember->animal_id = $newpig->id;
                    $groupingmember->save();

                    if(!is_null($request->date_farrowed)){
                        $farrowed = new GroupingProperty;
                        $farrowed->grouping_id = $grouping->id;
                        $farrowed->property_id = 3;
                        $farrowed->value = $request->date_farrowed;
                        $farrowed->save();

                        $dateFarrowedValue = new Carbon($request->date_farrowed);

                        $date_bred = new GroupingProperty;
                        $date_bred->grouping_id = $grouping->id;
                        $date_bred->property_id = 42;
                        $date_bred->value = $dateFarrowedValue->subDays(114);
                        $date_bred->save();

                        $edf = new GroupingProperty;
                        $edf->grouping_id = $grouping->id;
                        $edf->property_id = 43;
                        $edf->value = $request->date_farrowed;
                        $edf->save();

                        $status = new GroupingProperty;
                        $status->grouping_id = $grouping->id;
                        $status->property_id = 60;
                        $status->value = "Farrowed";
                        $status->save();

                        if(is_null($request->date_weaned)){
                            $dateWeanedValue = "Not specified";
                        }
                        else{
                            $dateWeanedValue = $request->date_weaned;
                        }

                        $date_weaned = new GroupingProperty;
                        $date_weaned->grouping_id = $grouping->id;
                        $date_weaned->property_id = 6;
                        $date_weaned->value = $dateWeanedValue;
                        $date_weaned->save();

                    }
                }
            }
            echo "Successfully added new pig!";
        }
        else{
            echo "Registration ID already exists!";
        }
    }

    static function addPonderalIndices($farmable_id, $breedable_id){
        $farm = Farm::find($farmable_id);
        $breed = Breed::find($breedable_id);
        $pigs = Animal::where("animaltype_id", 3)
                    ->where("breed_id", $breed->id)
                    ->where("status", "breeder")
                    ->get();

        // computes ponderal index = weight at 180 days divided by body length converted to meters cube
        $ponderalIndexValue = 0;
        if(!is_null($pigs)){
            foreach ($pigs as $pig) {
                $properties = $pig->getAnimalProperties();
                foreach ($properties as $property) {
                    if($property->property_id == 25){
                        if(!is_null($property) && $property->value != ""){
                            $bodylength = $property->value;
                            $bodyweight180dprop = $pig->getAnimalProperties()->where("property_id", 36)->first();
                            if(!is_null($bodyweight180dprop) && $bodyweight180dprop->value != ""){
                                $ponderalIndexValue = $bodyweight180dprop->value/(($property->value/100)**3); 
                            }
                            else{
                                $ponderalIndexValue = "";
                            }
                        }
                        else{
                            $ponderalIndexValue = "";
                        }
                    }
                }
                $ponderalprop = $pig->getAnimalProperties()->where("property_id", 31)->first();
                if(is_null($ponderalprop)){
                    $ponderalindex = new AnimalProperty;
                    $ponderalindex->animal_id = $pig->id;
                    $ponderalindex->property_id = 31;
                    $ponderalindex->value = $ponderalIndexValue;
                    $ponderalindex->save();
                }
                else{
                    $ponderalprop->value = $ponderalIndexValue;
                    $ponderalprop->save();
                }
            }
        }
    }

    public function getAllSows(Request $request)
    {
        $pigs = Animal::where("animaltype_id", 3)
                    ->where("breed_id", $request->breedable_id)
                    ->where("status", "breeder")
                    ->get();
        $archived_pigs = Animal::where("animaltype_id", 3)
                    ->where("breed_id", $request->breedable_id)
                    ->where(function ($query){$query->where("status", "dead breeder")
                                                    ->orWhere("status", "sold breeder")
                                                    ->orWhere("status", "removed breeder");
                                                    })
                    ->get();
        $sows = [];
        foreach($pigs as $pig){
            if(substr($pig->registryid, -7, 1) == 'F') 
                array_push($sows, $pig);
        }

        $archived_sows = [];
        foreach ($archived_pigs as $archived_pig) {
            if(substr($archived_pig->registryid, -7, 1) == 'F')
                array_push($archived_sows, $archived_pig);
            
        }
        return json_encode($sows);

        // static::addPonderalIndices($farm->id, $breed->id);
    }

    public function getAllBoars(Request $request)
    {
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $pigs = Animal::where("animaltype_id", 3)
                    ->where("breed_id", $breed->id)
                    ->where("status", "breeder")
                    ->get();

        $archived_pigs = Animal::where("animaltype_id", 3)
                    ->where("breed_id", $breed->id)
                    ->where(function ($query){$query->where("status", "dead breeder")
                                                    ->orWhere("status", "sold breeder")
                                                    ->orWhere("status", "removed breeder");
                                                    })
                    ->get();
        $boars = [];
        foreach($pigs as $pig){
            if(substr($pig->registryid, -7, 1) == 'M')
                array_push($boars, $pig);  
        }

        $archived_boars = [];

        foreach ($archived_pigs as $archived_pig) {
            if(substr($archived_pig->registryid, -7, 1) == 'M')
                array_push($archived_boars, $archived_pig);
            
        }
        return json_encode($boars);
        //static::addPonderalIndices($farm->id, $breed->id);
    }

     public function getAllFemaleGrowers(Request $request)
    {
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        // $q = $request->q;
        $pigs = Animal::where("animaltype_id", 3)
                    ->where("breed_id", $breed->id)
                    ->where("status", "active")
                    ->get();

        $sows = [];
    
        foreach($pigs as $pig){
            if(substr($pig->registryid, -7, 1) == 'F')
                array_push($sows, $pig); 
        }

        // if($q != ' '){
        //     $growers = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "active")->where('registryid', 'LIKE', '%'.$q.'%')->get();
        //     // dd($growers);
        //     if(count($growers) > 0){
        //         return view('pigs.growerrecords', compact('pigs', 'sows', 'boars'))->withDetails($growers)->withQuery($q);
        //     }
        // }
        return json_encode($sows);
    }

    public function getAllMaleGrowers(Request $request)
    {
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        // $q = $request->q;
        $pigs = Animal::where("animaltype_id", 3)
                        ->where("breed_id", $breed->id)
                        ->where("status", "active")
                        ->get();
        $boars = [];

        foreach($pigs as $pig){
            if(substr($pig->registryid, -7, 1) == 'M')
                array_push($boars, $pig);
        }
        // if($q != ' '){
        //     $growers = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "active")->where('registryid', 'LIKE', '%'.$q.'%')->get();
        //     // dd($growers);
        //     if(count($growers) > 0){
        //         return view('pigs.growerrecords', compact('pigs', 'sows', 'boars'))->withDetails($growers)->withQuery($q);
        //     }
        // }
        return json_encode($boars);
    }

    public function getAnimalProperties(Request $request){ // function to display Add Gross Morphology page
        $animal = Animal::where("registryid", $request->registry_id)->first();
        $properties = $animal->getAnimalProperties();

        return json_encode(compact('animal', 'properties'));
    }

    public function getViewSowPage(Request $request){ // function to display View Sow page
        $sow = Animal::where("registryid", $request->registry_id)->first();
        $properties = $sow->getAnimalProperties();
        // $properties = AnimalProperty::where('animal_id', $sow->id)->get();


        // $photo = Uploads::where("animal_id", $id)->first();

        // computes current age
        $now = Carbon::now();
        if(!is_null($properties->where("property_id", 3)->first())){
            if($properties->where("property_id", 3)->first()->value == "Not specified"){
                $age = "";
            }
            else{
                $end_date = Carbon::parse($properties->where("property_id", 3)->first()->value);
                $age = $now->diffInMonths($end_date);
            }
        }
        else{
            $age = "";
        }

        // computes age at weaning
        if(!is_null($properties->where("property_id", 3)->first()) && !is_null($properties->where("property_id", 6)->first())){
            if($properties->where("property_id", 3)->first()->value == "Not specified" || $properties->where("property_id", 6)->first()->value == "Not specified"){
                $ageAtWeaning = "";
            }
            else{
                $start_weaned = Carbon::parse($properties->where("property_id", 3)->first()->value);
                $end_weaned = Carbon::parse($properties->where("property_id", 6)->first()->value);
                $ageAtWeaning = $end_weaned->diffInMonths($start_weaned);
            }
        }
        else{
            $ageAtWeaning = "";
        }

        // computes age at first mating (only those with data of 1st parity)
        $frequency = $sow->getAnimalProperties()->where("property_id", 61)->first();
        $dates_bred = [];
        if(!is_null($frequency)){
            if($frequency->value > 1){
                $groups = Grouping::where("mother_id", $sow->id)->get();
                foreach ($groups as $group) {
                    $groupingproperties = $group->getGroupingProperties();
                    foreach ($groupingproperties as $groupingproperty) {
                        if($groupingproperty->property_id == 48){ //parity
                            if($groupingproperty->value == 1){
                                $date_bred = $group->getGroupingProperties()->where("property_id", 42)->first();
                                if(!is_null($date_bred) && $date_bred->value != "Not specified"){
                                    if(!is_null($sow->getAnimalProperties()->where("property_id", 3)->first()) && $sow->getAnimalProperties()->where("property_id", 3)->first()->value != "Not specified"){
                                        $bday = $sow->getAnimalProperties()->where("property_id", 3)->first()->value;
                                        $ageAtFirstMating = Carbon::parse($date_bred->value)->diffInMonths(Carbon::parse($bday));
                                    }
                                    else{
                                        $ageAtFirstMating = "";
                                    }
                                }
                                else{
                                    $ageAtFirstMating = "";
                                }
                            }
                            else{
                                $ageAtFirstMating = "";
                            }
                        }
                    }
                }
            }
            else{
                $ageAtFirstMating = "";
            }
        }
        else{
            $ageAtFirstMating = "";
        }

        // gets the sex ratio
        $family = $sow->getGrouping();
        if(!is_null($family)){
            $familymembers = $family->getGroupingMembers();
            $males = [];
            $females = [];
            foreach ($familymembers as $familymember) {
                $familymemberproperties = $familymember->getAnimalProperties();
                foreach ($familymemberproperties as $familymemberproperty) {
                    if($familymemberproperty->property_id == 2){
                        if($familymemberproperty->value == 'M'){
                            array_push($males, $familymember->getChild());
                        }
                        elseif($familymemberproperty->value == 'F'){
                            array_push($females, $familymember->getChild());
                        }
                    }
                }
            }
            $paritybornprop = $family->getGroupingProperties()->where("property_id", 48)->first();
            if(is_null($paritybornprop)){
                $parity_born = "";
            }
            else{
                $parity_born = $paritybornprop->value;
            }
        }
        else{
            $parity_born = "";
        }

        $grossmorphotakenprop = $properties->where("property_id", 10)->first();
        $morphocharstakenprop = $properties->where("property_id", 21)->first();
        $bday = $properties->where("property_id", 3)->first();
        if(!is_null($bday) && $bday->value != "Not specified"){
            $bdayValue = Carbon::parse($bday->value);
            if(!is_null($grossmorphotakenprop)){
                $grossmorphotaken = Carbon::parse($grossmorphotakenprop->value);
                $age_grossmorpho = $grossmorphotaken->diffInDays($bdayValue);
            }
            else{
                $age_grossmorpho = "";
            }
            if(!is_null($morphocharstakenprop)){
                $morphocharstaken = Carbon::parse($morphocharstakenprop->value);
                $age_morphochars = $morphocharstaken->diffInDays($bdayValue);
            }
            else{
                $age_morphochars = "";
            }
        }
        else{
            $age_grossmorpho = "";
            $age_morphochars = "";
        }

        return json_encode(compact('boar', 'properties', 'age', 'ageAtWeaning', 'ageAtFirstMating', 'males', 'females', 'parity_born', 'age_grossmorpho', 'age_morphochars', 'photo'));   
    }

    public function fetchGrossMorphology(Request $request){ // function to add gross morphology data
        $animal = Animal::where("registryid", $request->registry_id)->first();
        $animalid = $animal->id;

        // $animal = Animal::where("registryid", $request->registry_id)->first();
        // $properties = $animal->getAnimalProperties();

        // creates new properties
        $dcgross = $animal->getAnimalProperties()->where("property_id", 10)->first();
        $hairtype = $animal->getAnimalProperties()->where("property_id", 11)->first();
        $hairlength = $animal->getAnimalProperties()->where("property_id", 12)->first();
        $coatcolor = $animal->getAnimalProperties()->where("property_id", 13)->first();
        $colorpattern = $animal->getAnimalProperties()->where("property_id", 14)->first();
        $headshape = $animal->getAnimalProperties()->where("property_id", 15)->first();
        $skintype = $animal->getAnimalProperties()->where("property_id", 16)->first();
        $eartype = $animal->getAnimalProperties()->where("property_id", 17)->first();
        $backline = $animal->getAnimalProperties()->where("property_id", 18)->first();
        $tailtype = $animal->getAnimalProperties()->where("property_id", 19)->first();
        $othermarks = $animal->getAnimalProperties()->where("property_id", 20)->first();

        if($dcgross==null) $dcgross = new AnimalProperty;
        if($hairtype==null) $hairtype = new AnimalProperty;
        if($hairlength==null) $hairlength = new AnimalProperty;
        if($coatcolor==null) $coatcolor = new AnimalProperty;
        if($colorpattern==null) $colorpattern = new AnimalProperty;
        if($headshape==null) $headshape = new AnimalProperty;
        if($skintype==null) $skintype = new AnimalProperty;
        if($eartype==null) $eartype = new AnimalProperty;
        if($backline==null) $backline = new AnimalProperty;
        if($tailtype==null) $tailtype = new AnimalProperty;
        if($othermarks==null) $othermarks = new AnimalProperty;

        if(is_null($request->date_collected_gross)){
            $dateCollectedGrossValue = new Carbon();
            $dateCollectedGrossValue = $dateCollectedGrossValue->format('Y-m-d');
        }
        else{
            $dateCollectedGrossValue = $request->date_collected_gross;
        }

        $dcgross->animal_id = $animalid;
        $dcgross->property_id = 10;
        $dcgross->value = $dateCollectedGrossValue;

        if(is_null($request->hair_type)){
            $hairTypeValue = "Not specified";
        }
        else{
            $hairTypeValue = $request->hair_type;
        }

        $hairtype->animal_id = $animalid;
        $hairtype->property_id = 11;
        $hairtype->value = $hairTypeValue;

        if(is_null($request->hair_length)){
            $hairLengthValue = "Not specified";
        }
        else{
            $hairLengthValue = $request->hair_length;
        }

        $hairlength->animal_id = $animalid;
        $hairlength->property_id = 12;
        $hairlength->value = $hairLengthValue;

        if(is_null($request->coat_color)){
            $coatColorValue = "Not specified";
        }
        else{
            $coatColorValue = $request->coat_color;
        }

        $coatcolor->animal_id = $animalid;
        $coatcolor->property_id = 13;
        $coatcolor->value = $coatColorValue;

        if(is_null($request->color_pattern)){
            $colorPatternValue = "Not specified";
        }
        else{
            $colorPatternValue = $request->color_pattern;
        }

        $colorpattern->animal_id = $animalid;
        $colorpattern->property_id = 14;
        $colorpattern->value = $colorPatternValue;

        if(is_null($request->head_shape)){
            $headShapeValue = "Not specified";
        }
        else{
            $headShapeValue = $request->head_shape;
        }

        $headshape->animal_id = $animalid;
        $headshape->property_id = 15;
        $headshape->value = $headShapeValue;

        if(is_null($request->skin_type)){
            $skinTypeValue = "Not specified";
        }
        else{
            $skinTypeValue = $request->skin_type;
        }

        $skintype->animal_id = $animalid;
        $skintype->property_id = 16;
        $skintype->value = $skinTypeValue;

        if(is_null($request->ear_type)){
            $earTypeValue = "Not specified";
        }
        else{
            $earTypeValue = $request->ear_type;
        }

        $eartype->animal_id = $animalid;
        $eartype->property_id = 17;
        $eartype->value = $earTypeValue;

        if(is_null($request->tail_type)){
            $tailTypeValue = "Not specified";
        }
        else{
            $tailTypeValue = $request->tail_type;
        }

        $tailtype->animal_id = $animalid;
        $tailtype->property_id = 18;
        $tailtype->value = $tailTypeValue;

        if(is_null($request->backline)){
            $backlineValue = "Not specified";
        }
        else{
            $backlineValue = $request->backline;
        }

        $backline->animal_id = $animalid;
        $backline->property_id = 19;
        $backline->value = $backlineValue;

        if(is_null($request->other_marks)){
            $otherMarksValue = "None";
        }
        else{
            $otherMarksValue = $request->other_marks;
        }

        $othermarks->animal_id = $animalid;
        $othermarks->property_id = 20;
        $othermarks->value = $otherMarksValue;

        $dcgross->save();
        $hairtype->save();
        $hairlength->save();
        $coatcolor->save();
        $colorpattern->save();
        $headshape->save();
        $skintype->save();
        $eartype->save();
        $tailtype->save();
        $backline->save();
        $othermarks->save();

        $animal = Animal::find($animalid);
        $animal->grossmorpho = 1;
        $animal->save();

        // if(!is_null($request->display_photo)){
        //     $image = $request->file('display_photo');
        //     $input['image_name'] = $animal->id.'-'.$animal->registryid.'-display-photo'.'.'.$image->getClientOriginalExtension();
        //     $destination = public_path('/images');
        //     $image->move($destination, $input['image_name']);

        //     DB::table('uploads')->insert(['animal_id' => $animal->id, 'animaltype_id' => 3, 'breed_id' => $animal->breed_id, 'filename' => $input['image_name']]);
        // }

        //return Redirect::back()->with('message','Animal record successfully saved');
    }

    public function fetchMorphometricCharacteristics(Request $request){ // function to add morphometric characteristics
        $animal = Animal::where("registryid", $request->registry_id)->first();
        $animalid = $animal->id;

        // creates new properties
        $dcmorpho = $animal->getAnimalProperties()->where("property_id", 21)->first();
        $earlength = $animal->getAnimalProperties()->where("property_id", 22)->first();
        $headlength = $animal->getAnimalProperties()->where("property_id", 23)->first();
        $snoutlength = $animal->getAnimalProperties()->where("property_id", 24)->first();
        $bodylength = $animal->getAnimalProperties()->where("property_id", 25)->first();
        $heartgirth = $animal->getAnimalProperties()->where("property_id", 26)->first();
        $pelvicwidth = $animal->getAnimalProperties()->where("property_id", 27)->first();
        $taillength = $animal->getAnimalProperties()->where("property_id", 28)->first();
        $heightatwithers = $animal->getAnimalProperties()->where("property_id", 29)->first();
        $normalteats = $animal->getAnimalProperties()->where("property_id", 30)->first();
        //$othermarks = $animal->getAnimalProperties()->where("property_id", 20)->first();

        if($dcmorpho==null) $dcmorpho = new AnimalProperty;
        if($earlength==null) $earlength = new AnimalProperty;
        if($headlength==null) $headlength = new AnimalProperty;
        if($bodylength==null) $bodylength = new AnimalProperty;
        if($snoutlength==null) $snoutlength = new AnimalProperty;
        if($heartgirth==null) $heartgirth = new AnimalProperty;
        if($pelvicwidth==null) $pelvicwidth = new AnimalProperty;
        if($taillength==null) $taillength = new AnimalProperty;
        if($heightatwithers==null) $heightatwithers = new AnimalProperty;
        if($normalteats==null) $normalteats = new AnimalProperty;
        //if($othermarks==null) $othermarks = new AnimalProperty;

        if(is_null($request->date_collected_morpho)){
            $dateCollectedMorphoValue = "";
        }
        else{
            $dateCollectedMorphoValue = $request->date_collected_morpho;
        }

        $dcmorpho->animal_id = $animalid;
        $dcmorpho->property_id = 21;
        $dcmorpho->value = $dateCollectedMorphoValue;

        if(is_null($request->ear_length)){
            $earLengthValue = "";
        }
        else{
            $earLengthValue = $request->ear_length;
        }

        $earlength->animal_id = $animalid;
        $earlength->property_id = 22;
        $earlength->value = $earLengthValue;

        if(is_null($request->head_length)){
            $headLengthValue = "";
        }
        else{
            $headLengthValue = $request->head_length;
        }

        $headlength->animal_id = $animalid;
        $headlength->property_id = 23;
        $headlength->value = $headLengthValue;

        if(is_null($request->snout_length)){
            $snoutLengthValue = "";
        }
        else{
            $snoutLengthValue = $request->snout_length;
        }

        $snoutlength->animal_id = $animalid;
        $snoutlength->property_id = 24;
        $snoutlength->value = $snoutLengthValue;

        if(is_null($request->body_length)){
            $bodyLengthValue = "";
        }
        else{
            $bodyLengthValue = $request->body_length;
        }

        $bodylength->animal_id = $animalid;
        $bodylength->property_id = 25;
        $bodylength->value = $bodyLengthValue;

        if(is_null($request->heart_girth)){
            $heartGirthValue = "";
        }
        else{
            $heartGirthValue = $request->heart_girth;
        }

        $heartgirth->animal_id = $animalid;
        $heartgirth->property_id = 26;
        $heartgirth->value = $heartGirthValue;

        if(is_null($request->pelvic_width)){
            $pelvicWidthValue = "";
        }
        else{
            $pelvicWidthValue = $request->pelvic_width;
        }

        $pelvicwidth->animal_id = $animalid;
        $pelvicwidth->property_id = 27;
        $pelvicwidth->value = $pelvicWidthValue;

        if(is_null($request->tail_length)){
            $tailLengthValue = "";
        }
        else{
            $tailLengthValue = $request->tail_length;
        }

        $taillength->animal_id = $animalid;
        $taillength->property_id = 28;
        $taillength->value = $tailLengthValue;

        if(is_null($request->height_at_withers)){
            $heightAtWithersValue = "";
        }
        else{
            $heightAtWithersValue = $request->height_at_withers;
        }

        $heightatwithers->animal_id = $animalid;
        $heightatwithers->property_id = 29;
        $heightatwithers->value = $heightAtWithersValue;


        $animal = Animal::find($animalid);

        if(is_null($request->number_normal_teats)){
            $normalTeatsValue = "";
        }
        else{
            $normalTeatsValue = $request->number_normal_teats;
        }

        $normalteats->animal_id = $animalid;
        $normalteats->property_id = 30;
        $normalteats->value = $normalTeatsValue;
        $normalteats->save();
     
        $dcmorpho->save();
        $earlength->save();
        $headlength->save();
        $snoutlength->save();
        $bodylength->save();
        $pelvicwidth->save();
        $heartgirth->save();
        $taillength->save();
        $heightatwithers->save();
        
        $animal->morphochars = 1;
        $animal->save();

        //return Redirect::back()->with('message','Animal record successfully saved');
    }

    public function fetchWeightRecords(Request $request){ // function to add weight records
            $animal = Animal::where("registryid", $request->registry_id)->first();
            $animalid = $animal->id;
            $animal = Animal::find($animalid);
            $properties = $animal->getAnimalProperties();

            // used when date collected was not provided
            $bday = $properties->where("property_id", 3)->first();

            $bw45d = $animal->getAnimalProperties()->where("property_id", 32)->first();
            $dc45d = $animal->getAnimalProperties()->where("property_id", 37)->first();
            $bw60d = $animal->getAnimalProperties()->where("property_id", 33)->first();
            $dc60d = $animal->getAnimalProperties()->where("property_id", 38)->first();
            $bw90d = $animal->getAnimalProperties()->where("property_id", 34)->first();
            $dc90d = $animal->getAnimalProperties()->where("property_id", 39)->first();
            $bw150d = $animal->getAnimalProperties()->where("property_id", 35)->first();
            $dc150d = $animal->getAnimalProperties()->where("property_id", 40)->first();
            $bw180d = $animal->getAnimalProperties()->where("property_id", 36)->first();
            $dc180d = $animal->getAnimalProperties()->where("property_id", 41)->first();
            //$othermarks = $animal->getAnimalProperties()->where("property_id", 20)->first();

            if($bw45d==null) $bw45d = new AnimalProperty;
            if($dc45d==null) $dc45d = new AnimalProperty;
            if($bw60d==null) $bw60d = new AnimalProperty;
            if($dc60d==null) $dc60d = new AnimalProperty;
            if($bw90d==null) $bw90d = new AnimalProperty;
            if($dc90d==null) $dc90d = new AnimalProperty;
            if($bw150d==null) $bw150d = new AnimalProperty;
            if($dc150d==null) $dc150d = new AnimalProperty;
            if($bw180d==null) $bw180d = new AnimalProperty;
            if($dc180d==null) $dc180d = new AnimalProperty;

            $datefarrowedprop = $properties->where("property_id", 3)->first();
            $dateweanedprop = $properties->where("property_id", 6)->first();

            if(!is_null($datefarrowedprop) && !is_null($dateweanedprop)){
                if($datefarrowedprop->value != "Not specified" && $dateweanedprop->value != "Not specified"){
                    $datefarrowed = Carbon::parse($datefarrowedprop->value);
                    $dateweaned = Carbon::parse($dateweanedprop->value);
                    $age_weaned = $dateweaned->diffInDays($datefarrowed);
                }
                else{
                    $age_weaned = "";
                }
            }
            else{
                $age_weaned = "";
            }

            if(is_null($request->body_weight_at_45_days)){
                if($age_weaned == 45){
                    $bw45dValue = $request->body_weight_at_45_days;
                }
                else{
                    $bw45dValue = "";
                }
            }
            else{
                $bw45dValue = $request->body_weight_at_45_days;
            }

            $bw45d->animal_id = $animalid;
            $bw45d->property_id = 32;
            $bw45d->value = $bw45dValue;

            if(is_null($request->date_collected_45_days)){
                if(!is_null($bday) && $bday->value != "Not specified"){
                    $dc45dValue = Carbon::parse($bday->value)->addDays(45)->toDateString();
                }
                else{
                    $dc45dValue = "";
                }
            }
            else{
                $dc45dValue = $request->date_collected_45_days;
            }

            $dc45d->animal_id = $animalid;
            $dc45d->property_id = 37;
            $dc45d->value = $dc45dValue;

            if(is_null($request->body_weight_at_60_days)){
                if($age_weaned == 60){
                    $bw60dValue = $request->body_weight_at_60_days;
                }
                else{
                    $bw60dValue = "";
                }
            }
            else{
                $bw60dValue = $request->body_weight_at_60_days;
            }

            $bw60d->animal_id = $animalid;
            $bw60d->property_id = 33;
            $bw60d->value = $bw60dValue;

            if(is_null($request->date_collected_60_days)){
                if(!is_null($bday) && $bday->value != "Not specified"){
                    $dc60dValue = Carbon::parse($bday->value)->addDays(60)->toDateString();
                }
                else{
                    $dc60dValue = "";
                }
            }
            else{
                $dc60dValue = $request->date_collected_60_days;
            }

            $dc60d->animal_id = $animalid;
            $dc60d->property_id = 38;
            $dc60d->value = $dc60dValue;

            if(is_null($request->body_weight_at_90_days)){
                $bw90dValue = "";
            }
            else{
                $bw90dValue = $request->body_weight_at_90_days;
            }

            $bw90d->animal_id = $animalid;
            $bw90d->property_id = 34;
            $bw90d->value = $bw90dValue;

            if(is_null($request->date_collected_90_days)){
                if(!is_null($bday) && $bday->value != "Not specified"){
                    $dc90dValue = Carbon::parse($bday->value)->addDays(90)->toDateString();
                }
                else{
                    $dc90dValue = "";
                }
            }
            else{
                $dc90dValue = $request->date_collected_90_days;
            }

            $dc90d->animal_id = $animalid;
            $dc90d->property_id = 39;
            $dc90d->value = $dc90dValue;

            if(is_null($request->body_weight_at_150_days)){
                $bw150dValue = "";
            }
            else{
                $bw150dValue = $request->body_weight_at_150_days;
            }

            $bw150d->animal_id = $animalid;
            $bw150d->property_id = 35;
            $bw150d->value = $bw150dValue;

            if(is_null($request->date_collected_150_days)){
                if(!is_null($bday) && $bday->value != "Not specified"){
                    $dc150dValue = Carbon::parse($bday->value)->addDays(150)->toDateString();
                }
                else{
                    $dc150dValue = "";
                }
            }
            else{
                $dc150dValue = $request->date_collected_150_days;
            }

            $dc150d->animal_id = $animalid;
            $dc150d->property_id = 40;
            $dc150d->value = $dc150dValue;

            if(is_null($request->body_weight_at_180_days)){
                $bw180dValue = "";
            }
            else{
                $bw180dValue = $request->body_weight_at_180_days;
            }

            $bw180d->animal_id = $animalid;
            $bw180d->property_id = 36;
            $bw180d->value = $bw180dValue;

            if(is_null($request->date_collected_180_days)){
                if(!is_null($bday) && $bday->value != "Not specified"){
                    $dc180dValue = Carbon::parse($bday->value)->addDays(180)->toDateString();
                }
                else{
                    $dc180dValue = "";
                }
            }
            else{
                $dc180dValue = $request->date_collected_180_days;
            }

            $dc180d->animal_id = $animalid;
            $dc180d->property_id = 41;
            $dc180d->value = $dc180dValue;

            $weaningWeightValue = $request->weaning_weight;

            $weaningweight->animal_id = $animalid;
            $weaningweight->property_id = 7;
            $weaningweight->value = $weaningWeightValue;

            $weaningWeightValue->save();
            $bw45d->save();
            $dc45d->save();
            $bw60d->save();
            $dc60d->save();
            $bw90d->save();
            $dc90d->save();
            $bw150d->save();
            $dc150d->save();
            $bw180d->save();
            $dc180d->save();

            $animal = Animal::find($animalid);
            $animal->weightrecord = 1;
            $animal->save();
        }

    public static function whereInMultiple(array $columns, $values)
    {
        $values = array_map(function (array $value) {
            return "('".implode($value, "', '")."')"; 
        }, $values);

        return static::query()->whereRaw(
            '('.implode($columns, ', ').') in ('.implode($values, ', ').')'
        );
    }

    public function getAllCount(Request $request)
    {
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $sow = 0;
        $gilt = 0;
        $boar = 0;
        $maleGrower = 0;
        $femaleGrower = 0;
        $breederInventory = 0;
        $growerInventory = 0;
        $mortalityInventory = 0;

        $breeders = Animal::where('status', "breeder")
            ->where('farm_id', $farm->id)
            ->get();
        $growers = Animal::where('status', "active")
            ->where('farm_id', $farm->id)
            ->get();  
        $mortality = Animal::where('status', "dead breeder")
                ->orWhere('status', "dead grower")
                ->orWhere('status', "sold breeder")
                ->orWhere('status', "sold grower")
                ->orWhere('status', "removed breeder")
                ->orWhere('status', "removed grower")
                ->get();

        $mortality = $mortality->where('farm_id', $farm->id);

        $breederInventory = $breeders->count();
        $growerInventory = $growers->count();
        $mortalityInventory = $mortality->count();

        foreach ($breeders as $breeder) {
            if(substr($breeder->registryid, -7, 1) == 'F'){
               $checkIfExistingInGrouping = Grouping::where('registryid', $breeder->registryid)
                    ->where('breed_id', $breed->id)
                    ->first();
               if($checkIfExistingInGrouping == null){
                    $gilt++;
                }else {
                    $sow++;
                }
            }else{
                $boar++;
            }
        }

        foreach ($growers as $grower) {
            if(substr($grower->registryid, -7, 1) == 'F'){
               $femaleGrower++; 
            }else{
                $maleGrower++;
            }
        }

        $countArray = array('sowCount' => $sow,
                    'giltCount' => $gilt,
                    'boarCount' => $boar,
                    'femaleGrowerCount' => $femaleGrower,
                    'maleGrowerCount' => $maleGrower,
                    'breederInventory' => $breederInventory,
                    'growerInventory' => $growerInventory,
                    'mortalityInventory' => $mortalityInventory
        );

        return json_encode($countArray);    
    }

    public function addAsBreeder(Request $request)
    {
        $searchPig = Animal::where('registryid', $request->registry_id)->first();
        $pig = Animal::find($searchPig->id);
        $pig->status = 'breeder';
        $pig->save();
    }

    public function getMortalityPage(Request $request){ // function to display Mortality and Sales page
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $deadpigs = Mortality::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
        $growers = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "active")->get();
        $breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();

        // TO FOLLOW: this will be used for filtering results
        $now = Carbon::now();
        $current_year = $now->year;
        $range = range($current_year-10, $current_year+10);
        $years = array_combine($range, $range);

        $returnArray = [];
        foreach ($deadpigs as $deadpig) {
            $registry_id = Animal::where("id", $deadpig->animal_id)->first()->registryid;
            $array = array('registry_id' => $registry_id,
                    'datedied' => $deadpig->datedied, 
                    'cause' => $deadpig->cause,
                    'age' => $deadpig->age);
            array_push($returnArray, $array);
        }

        return json_encode($returnArray); 
    }

    public function getSalesPage(Request $request){ // function to display Mortality and Sales page
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $soldpigs = Sale::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
        $growers = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "active")->get();
        $breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();

        // TO FOLLOW: this will be used for filtering results
        $now = Carbon::now();
        $current_year = $now->year;
        $range = range($current_year-10, $current_year+10);
        $years = array_combine($range, $range);

        $returnArray = [];
        foreach ($soldpigs as $soldpig) {
            $registry_id = Animal::where("id", $soldpig->animal_id)->first()->registryid;
            $array = array('registry_id' => $registry_id,
                    'datesold' => $soldpig->datesold, 
                    'weight' => $soldpig->weight,
                    'price' => $soldpig->price,
                    'age' => $soldpig->age);
            array_push($returnArray, $array);
        }

        return json_encode($returnArray); 
    }

    public function getOthersPage(Request $request){ // function to display Mortality and Sales page
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $removedpigs = RemovedAnimal::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
        $growers = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "active")->get();
        $breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();

        // TO FOLLOW: this will be used for filtering results
        $now = Carbon::now();
        $current_year = $now->year;
        $range = range($current_year-10, $current_year+10);
        $years = array_combine($range, $range);

        $returnArray = [];
        foreach ($removedpigs as $removedpig) {
            $registry_id = Animal::where("id", $removedpig->animal_id)->first()->registryid;
            $array = array('registry_id' => $registry_id,
                    'dateremoved' => $removedpig->dateremoved, 
                    'reason' => $removedpig->reason,
                    'age' => $removedpig->age);
            array_push($returnArray, $array);
        }

        return json_encode($returnArray); 
    }

    public function addMortalityRecord(Request $request){ // function to add mortality record
            $farm = Farm::find($request->farmable_id);
            $breed = Breed::find($request->breedable_id);
            $dead = Animal::where("registryid", $request->registry_id)->first();

            $mortality = new Mortality();

            // pig which died was a grower
            if($dead->status == "active"){
                $dead->status = "dead grower";
                $dead->save();
            }
            // pig which died was a breeder
            elseif($dead->status == "breeder"){
                $dead->status = "dead breeder";
                $dead->save();
            }

            if(is_null($request->date_died)){
                $dateDiedValue = new Carbon();
            }
            else{
                $dateDiedValue = $request->date_died;
            }

            if(is_null($request->cause_death)){
                $causeDeathValue = "Not specified";
            }
            else{
                $causeDeathValue = $request->cause_death;
            }

            $bday = $dead->getAnimalProperties()->where("property_id", 3)->first();
            if(!is_null($bday)){
                if($bday->value != "Not specified"){
                    $age = Carbon::parse($dateDiedValue)->diffInDays(Carbon::parse($bday->value));
                }
                else{
                    $age = "Age unavailable";
                }
            }
            else{
                $age = "Age unavailable";
            }
            // DB::table('mortalities')->insert(['animal_id' => $dead->id, 'animaltype_id' => 3, 'breed_id' => $breed->id, 'datedied' => $dateDiedValue, 'cause' => $causeDeathValue, 'age' => $age]);
            $mortality->animal_id = $dead->id;
            $mortality->animaltype_id = 3;
            $mortality->breed_id = $breed->id;
            $mortality->datedied = $dateDiedValue;
            $mortality->cause = $causeDeathValue;
            $mortality->age = $age;
            $mortality->save();


           // return Redirect::back()->with('message', 'Operation Successful!');
        }

    public function addSalesRecord(Request $request){ // function to add sales record
            $farm = Farm::find($request->farmable_id);
            $breed = Breed::find($request->breedable_id);
            $sold = Animal::where("registryid", $request->registry_id)->first();

            $sale = new Sale();

            // pig sold was a grower
            if($sold->status == "active"){
                $sold->status = "sold grower";
                $sold->save();
            }
            // pig sold was a breeder
            elseif($sold->status == "breeder"){
                $sold->status = "sold breeder";
                $sold->save();
            }
                
            if(is_null($request->date_sold)){
                $dateSoldValue = new Carbon();
            }
            else{
                $dateSoldValue = $request->date_sold;
            }

            if(is_null($request->weight_sold)){
                $weightSoldValue = "Weight unavailable";
            }
            else{
                $weightSoldValue = $request->weight_sold;
            }

            if(is_null($request->price)){
                $priceValue = "Not specified";
            }
            else{
                $priceValue = $request->price;
            }

            $bday = $sold->getAnimalProperties()->where("property_id", 3)->first();
            if(!is_null($bday)){
                if($bday->value != "Not specified"){
                    $age = Carbon::parse($dateSoldValue)->diffInDays(Carbon::parse($bday->value));
                }
                else{
                    $age = "Age unavailable";
                }
            }
            else{
                $age = "Age unavailable";
            }

            $sale->animal_id = $sold->id;
            $sale->animaltype_id = 3;
            $sale->breed_id = $breed->id;
            $sale->datesold = $dateSoldValue;
            $sale->weight = $weightSoldValue;
            $sale->price = $priceValue;
            $sale->age = $age;
            $sale->save();

            // DB::table('sales')->insert(['animal_id' => $sold->id, 'animaltype_id' => 3, 'breed_id' => $breed->id, 'datesold' => $dateSoldValue, 'weight' => $weightSoldValue, 'price' => $priceValue, 'age' => $age]);

            // return Redirect::back()->with('message','Operation Successful!');
        }

        public function addRemovedAnimalRecord(Request $request){ // function to add removed (culled/donated) animal records
            $farm = Farm::find($request->farmable_id);
            $breed = Breed::find($request->breedable_id);
            $removed = Animal::where("registryid", $request->registry_id)->first();

            $removedAnimal = new RemovedAnimal();

            // pig removed was a grower
            if($removed->status == "active"){
                $removed->status = "removed grower";
                $removed->save();
            }
            elseif($removed->status == "breeder"){ // pig removed was a breeder
                $removed->status = "removed breeder";
                $removed->save();
            }

            if(is_null($request->date_removed)){
                $dateRemovedValue = new Carbon();
            }
            else{
                $dateRemovedValue = $request->date_removed;
            }

            if(is_null($request->reason_removed)){
                $reasonRemovedValue = "Donated";
            }
            else{
                $reasonRemovedValue = $request->reason_removed;
            }

            $bday = $removed->getAnimalProperties()->where("property_id", 3)->first();
            if(!is_null($bday)){
                if($bday->value != "Not specified"){
                    $age = Carbon::parse($dateRemovedValue)->diffInDays(Carbon::parse($bday->value));
                }
                else{
                    $age = "Age unavailable";
                }
            }
            else{
                $age = "Age unavailable";
            }

            // DB::table('removed_animals')->insert(['animal_id' => $removed->id, 'animaltype_id' => 3, 'breed_id' => $breed->id, 'dateremoved' => $dateRemovedValue, 'reason' => $reasonRemovedValue, 'age' => $age]);


            // return Redirect::back()->with('message','Operation Successful!');

            $removedAnimal->animal_id = $removed->id;
            $removedAnimal->animaltype_id = 3;
            $removedAnimal->breed_id = $breed->id;
            $removedAnimal->dateremoved = $dateRemovedValue;
            $removedAnimal->reason = $reasonRemovedValue;
            $removedAnimal->age = $age;
            $removedAnimal->save();
        }

    public function searchPig(Request $request)
    {
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $searchPigs = Animal::where('registryid', 'like', '%'.$request->registry_id.'%')
                    ->where('status',"breeder")
                    ->orWhere('status',"active")
                    ->where("breed_id", $breed->id)
                    ->get();
    
        // $returnArray = [];
        // foreach ($searchPigs as $search) {
        //     array_push($returnArray, $search->registryid);
        // }

        return $searchPigs;
    }


    public function searchSows(Request $request)
    {
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $searchSows = Animal::where('registryid', 'like', '%'.$request->registry_id.'%')
                    ->where('status',"breeder")
                    ->where("breed_id", $breed->id)
                    ->get();

        $sow = [];
        foreach ($searchSows as $searchSow) {
            if(substr($searchSow->registryid, -7, 1) == 'F')
                array_push($sow, $searchSow);
        }

        return json_encode($sow);
    }

    public function searchBoars(Request $request)
    {
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $searchBoars = Animal::where('registryid', 'like', '%'.$request->registry_id.'%')
                    ->where('status',"breeder")
                    ->where("breed_id", $breed->id)
                    ->get();  

        $boar = [];
        foreach ($searchBoars as $searchBoar) {
            if(substr($searchBoar->registryid, -7, 1) == 'M')
                array_push($boar, $searchBoar);
        }

        return json_encode($boar);
    }

    public function getBreedingRecord(Request $request)
    {
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $groups = Grouping::where("breed_id", $breed->id)->get();

        $returnArray = [];
        foreach($groups as $group){
            $dateBredValue = "";
            $edfValue = "";
            $statusValue = "";

            $array = [];
            $sow = Animal::where("id", $group->mother_id)
                ->where("breed_id", $breed->id)
                ->first();
            $boar = Animal::where("id", $group->father_id)
                ->where("breed_id", $breed->id)
                ->first();
            $dateBred = GroupingProperty::where("grouping_id", $group->id)
                    ->where("property_id", 42)
                    ->first();
            if($dateBred!=null){
                $dateBredValue = $dateBred->value;
            }

            $edf = GroupingProperty::where("grouping_id", $group->id)
                    ->where("property_id", 43)
                    ->first();
            if($edf!=null){
                $edfValue = $edf->value;
            }

            $status = GroupingProperty::where("grouping_id", $group->id)
                    ->where("property_id", 60)
                    ->first();
            if($status!=null){
                $statusValue = $status->value;
            }

            $array = array('sow_registryid' => $sow->registryid,
                    'boar_registryid' => $boar->registryid, 
                    'dateBred' => $dateBredValue,
                    'edf' => $edfValue,
                    'status' => $statusValue);
            array_push($returnArray, $array);
        }

        return $returnArray;
    }

    public function addBreedingRecord(Request $request){ // function to add new breeding record
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $sowRegId = Animal::where("registryid", $request->sow_id)->where("breed_id", $breed->id)->first();
        $boarRegId = Animal::where("registryid", $request->boar_id)->where("breed_id", $breed->id)->first();

        $pair = new Grouping;
        $pair->registryid = $sowRegId->registryid;
        $pair->father_id = $boarRegId->id;
        $pair->mother_id = $sowRegId->id;
        $pair->breed_id = $request->breedable_id;
        $pair->save();

        if(is_null($request->date_bred)){
            $dateBredValue = new Carbon();
        }
        else{
            $dateBredValue = $request->date_bred;
        }

        $date_bred = new GroupingProperty;
        $date_bred->grouping_id = $pair->id;
        $date_bred->property_id = 42;
        $date_bred->value = $dateBredValue;
        $date_bred->save();

        $edfValue = Carbon::parse($dateBredValue)->addDays(114);
        $edfValue = $edfValue->format('Y-m-d');

        $edf = new GroupingProperty;
        $edf->grouping_id = $pair->id;
        $edf->property_id = 43;
        $edf->value = $edfValue;
        $edf->save();

        $status = new GroupingProperty;
        $status->grouping_id = $pair->id;
        $status->property_id = 60;
        $status->value = "Bred";
        $status->save();
    }

    //  public function getGroupingProperties(Request $request){ // function to display Add Gross Morphology page
    //     $animalSow = Animal::where("registryid", $request->sow_id)->first();
    //     $sowId = $animalSow->id;
    //     $animalBoar = Animal::where("registryid", $request->boar_id)->first();
    //     $boarId = $animalBoar->id;

    //     $properties = $animal->getAnimalProperties();

    //     return json_encode(compact('animal', 'properties'));

    //     $animal = Animal::where("registryid", $request->registry_id)->first();
    //     $animalid = $animal->id;
    // }



    static function addParityMother($id){
        $grouping = Grouping::find($id);
        $mother = $grouping->getMother();

        $parityprop = $mother->getAnimalProperties()->where("property_id", 48)->first();
        $paritypropgroup = $grouping->getGroupingProperties()->where("property_id", 48)->first();
        $status = $grouping->getGroupingProperties()->where("property_id", 60)->first();
        $families = Grouping::where("mother_id", $mother->id)->get();

        //mother's parity property value == latest parity
        $parities = [];
        foreach ($families as $family) {
            $familyproperties = $family->getGroupingProperties();
            foreach ($familyproperties as $familyproperty) {
                if($familyproperty->property_id == 60){
                    if($familyproperty->value == "Farrowed"){ // parities are added only when sow already farrowed
                        $farrowedproperties = $family->getGroupingProperties();
                        foreach ($farrowedproperties as $farrowedproperty) {
                            if($farrowedproperty->property_id == 48){ //parity
                                if(!is_null($farrowedproperty->value)){
                                    array_push($parities, $farrowedproperty->value);
                                }
                            }
                        }
                    }
                    if($familyproperty->value == "Pregnant" || $familyproperty->value == "Recycled" || $familyproperty->value == "Bred" || $familyproperty->value == "Aborted"){
                        array_push($parities, 0); // thus, "parities" for pregnant and recycled sows are 0
                    }
                }
            }
        }
        $sorted_parities = array_sort($parities); // to know latest parity

        if(is_null($parityprop)){ // mother has no record for parity
            if($sorted_parities != []){
                $parity = new AnimalProperty;
                $parity->animal_id = $mother->id;
                $parity->property_id = 48;
                $parity->value = array_last($sorted_parities); // gets the last element of the array
                $parity->save();
            }
            else{
                $parity = new AnimalProperty;
                $parity->animal_id = $mother->id;
                $parity->property_id = 48;
                $parity->value = 1;
                $parity->save();
            }
        }
        else{ // mother has parity record
            if($sorted_parities != []){
                $parityprop->value = array_last($sorted_parities);
            }
            else{
                $parityprop->value = 1;
            }
            $parityprop->save();
        }

    }

    // public function findGroupingId(Request $request){
    //     $farm = Farm::find($request->farmable_id);
    //     $breed = Breed::find($request->breedable_id);
    //     $animalSow = Animal::where("registryid", $request->sow_id)->first();
    //     $animalBoar = Animal::where("registryid", $request->boar_id)->first();
        
    //     $group = Grouping::where("mother_id", $animalSow->id)
    //                         ->where("father_id", $animalBoar->id)
    //                         ->first();
    //     $groupingId = $group->id;
    //     return $groupingId;
    // }


    // public function getAnimalProperties(Request $request){ // function to display Add Gross Morphology page
    //     $animal = Animal::where("registryid", $request->registry_id)->first();
    //     $properties = $animal->getAnimalProperties();

    //     return json_encode(compact('animal', 'properties'));
    // }

    public function viewOffsprings(Request $request){
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $animalSow = Animal::where("registryid", $request->sow_id)->first();
        $animalBoar = Animal::where("registryid", $request->boar_id)->first();
        
        $group = Grouping::where("mother_id", $animalSow->id)
                            ->where("father_id", $animalBoar->id)
                            ->first();

        $family = Grouping::find($group->id);

        $properties = $family->getGroupingProperties();
        $offsprings = $family->getGroupingMembers();

        // return $offsprings;

        $offspringProperties = [];
        $animal = [];
        $properties = [];
        foreach ($offsprings as $offspring){
            $animal = Animal::where("id", $offspring->animal_id)->first();
            // return $animal;
            $properties = $animal->getAnimalProperties();
            // return $properties; 
            array_push($offspringProperties, $properties);
        }

        return $offspringProperties;
    }

    // public function getBreedingRecord(Request $request)
    // {
    //     $farm = Farm::find($request->farmable_id);
    //     $breed = Breed::find($request->breedable_id);
    //     $groups = Grouping::get();

    //     $returnArray = [];
    //     foreach($groups as $group){
    //         $array = [];
    //         $sow = Animal::find($group->mother_id);
    //         $boar = Animal::find($group->father_id);
    //         $dateBred = GroupingProperty::where("grouping_id", $group->id)
    //                 ->where("property_id", 42)
    //                 ->first();
    //         $dateBredValue = $dateBred->value;
    //         $array = array('sow_registryid' => $sow->registryid,
    //                 'boar_registryid' => $boar->registryid, 
    //                 'dateBred' => $dateBredValue);
    //         array_push($returnArray, $array);
    //     }

    //     return $returnArray;
    // INAAA
    // }

    public function getAddSowLitterRecordPage(Request $request){ // function to display Sow-Litter Record page
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $animalSow = Animal::where("registryid", $request->sow_id)->first();
        $animalBoar = Animal::where("registryid", $request->boar_id)->first();
        
        $group = Grouping::where("mother_id", $animalSow->id)
                            ->where("father_id", $animalBoar->id)
                            ->first();
        // $groupingId = $group->id;
        $family = Grouping::find($group->id);

        // return $family;

        // return $family;
        // $family = $groupingId;
        // return $family;
        $properties = $family->getGroupingProperties();
        $offsprings = $family->getGroupingMembers();

        // return $offsprings;

        // counts offsprings per sex !---- ERROR HERE 
        $countMales = 0;
        $countFemales = 0;
        foreach ($offsprings as $offspring) {
            $propscount = $offspring->getAnimalProperties();
            foreach ($propscount as $propcount) {
                if($propcount->property_id == 2){ //sex
                    if($propcount->value == 'M'){
                        $countMales = $countMales + 1;
                        // return $countMales;
                    }
                    if($propcount->value == 'F'){
                        $countFemales = $countFemales + 1;
                    }
                }
            }
        }

        // return $countFemales;

        $numbermalesprop = $properties->where("property_id", 51)->first();
        if(is_null($numbermalesprop)){
            $number_males = new GroupingProperty;
            $number_males->grouping_id = $family->id;
            $number_males->property_id = 51;
            $number_males->value = $countMales;
            $number_males->save();
        }
        else{
            $numbermalesprop->value = $countMales;
            $numbermalesprop->save();
        }     

        $numberfemalesprop = $properties->where("property_id", 52)->first();
        if(is_null($numberfemalesprop)){
            $number_females = new GroupingProperty;
            $number_females->grouping_id = $family->id;
            $number_females->property_id = 52;
            $number_females->value = $countFemales;
            $number_females->save();
        }
        else{
            $numberfemalesprop->value = $countFemales;
            $numberfemalesprop->save();
        }

        $sexratioprop = $properties->where("property_id", 53)->first();
        if(is_null($sexratioprop)){
            $sex_ratio = new GroupingProperty;
            $sex_ratio->grouping_id = $family->id;
            $sex_ratio->property_id = 53;
            $sex_ratio->value = $countMales.":".$countFemales;
            $sex_ratio->save();
        }
        else{
            $sexratioprop->value = $countMales.":".$countFemales;
            $sexratioprop->save();
        }

        if($family->members == 1){
            $stillborn = $properties->where("property_id", 45)->first()->value;
            $mummified = $properties->where("property_id", 46)->first()->value;

            $tlsbprop = $properties->where("property_id", 49)->first();
            $lsbaprop = $properties->where("property_id", 50)->first();

            if(is_null($tlsbprop)){
                $tlsb = new GroupingProperty;
                $tlsb->grouping_id = $family->id;
                $tlsb->property_id = 49;
                $tlsb->value = $stillborn+$mummified+count($offsprings);
                $tlsb->save();
            }
            else{
                $tlsbprop->value = $stillborn+$mummified+count($offsprings);
                $tlsbprop->save();
            }

            if(is_null($lsbaprop)){
                $lsba = new GroupingProperty;
                $lsba->grouping_id = $family->id;
                $lsba->property_id = 50;
                $lsba->value = count($offsprings);
                $lsba->save();
            }
            else{
                $lsbaprop->value = count($offsprings);
                $lsbaprop->save();
            }
        }

        // computes for average birth weight
        $sum = 0;
        $aveBirthWeight = 0;
        $bweights = [];
        if(count($offsprings) != 0){
            foreach ($offsprings as $offspring) {
                $propsbweight = $offspring->getAnimalProperties();
                foreach ($propsbweight as $propbweight) {
                    if($propbweight->property_id == 5){
                        $bweight = $propbweight->value;
                        array_push($bweights, $bweight);
                    }
                }
            }
            $sum = array_sum($bweights);
            $aveBirthWeight = $sum/count($offsprings);
        }

        $litterbwprop = $properties->where("property_id", 55)->first();
        if(is_null($litterbwprop)){
            $litterbw = new GroupingProperty;
            $litterbw->grouping_id = $family->id;
            $litterbw->property_id = 55;
            $litterbw->value = $sum;
            $litterbw->save();
        }
        else{
            $litterbwprop->value = $sum;
            $litterbwprop->save();
        }


        $avebwprop = $properties->where("property_id", 56)->first();
        if(is_null($avebwprop)){
            $avebw = new GroupingProperty;
            $avebw->grouping_id = $family->id;
            $avebw->property_id = 56;
            $avebw->value = $aveBirthWeight;
            $avebw->save();
        }
        else{
            $avebwprop->value = $aveBirthWeight;
            $avebwprop->save();
        }

        // counts number of pigs weaned
        $weaned = 0;
        foreach ($offsprings as $offspring) {
            if(!is_null($offspring->getAnimalProperties()->where("property_id", 7)->first())){
                $weaned = $weaned + 1;
            }
        }

        $numberweanedprop = $properties->where("property_id", 57)->first();
        if(is_null($numberweanedprop)){
            $number_weaned = new GroupingProperty;
            $number_weaned->grouping_id = $family->id;
            $number_weaned->property_id = 57;
            $number_weaned->value = $weaned;
            $number_weaned->save();
        }
        else{
            $numberweanedprop->value = $weaned;
            $numberweanedprop->save();
        }

        // computes for average weaning weight
        $sumww = 0;
        $aveWeaningWeight = 0;
        $weights = [];
        if(count($offsprings) != 0 && $weaned != 0){
            foreach ($offsprings as $offspring) {
                $propswweight = $offspring->getAnimalProperties();
                foreach ($propswweight as $propwweight) {
                    if($propwweight->property_id == 7){ //weaning weight
                        $weight = $propwweight->value;
                        array_push($weights, $weight);
                    }
                }
            }
            $sumww = array_sum($weights);
            $aveWeaningWeight = $sumww/$weaned;
        }

        $litterwwprop = $properties->where("property_id", 62)->first();
        if(is_null($litterwwprop)){
            $litterww = new GroupingProperty;
            $litterww->grouping_id = $family->id;
            $litterww->property_id = 62;
            $litterww->value = $sumww;
            $litterww->save();
        }
        else{
            $litterwwprop->value = $sumww;
            $litterwwprop->save();
        }

        $avewwprop = $properties->where("property_id", 58)->first();
        if(is_null($avewwprop)){
            $aveww = new GroupingProperty;
            $aveww->grouping_id = $family->id;
            $aveww->property_id = 58;
            $aveww->value = $aveWeaningWeight;
            $aveww->save();
        }
        else{
            $avewwprop->value = $aveWeaningWeight;
            $avewwprop->save();
        }

        $dateweanedprop = $properties->where("property_id", 6)->first();
        $preweaningmortprop = $properties->where("property_id", 59)->first();
        if(!is_null($dateweanedprop)){
            if(is_null($preweaningmortprop)){
                $preweaningmortality = new GroupingProperty;
                $preweaningmortality->grouping_id = $family->id;
                $preweaningmortality->property_id = 59;
                $preweaningmortality->value = round(((count($offsprings)-$weaned)/count($offsprings))*100, 4);
                $preweaningmortality->save();
            }
            else{
                if(count($offsprings) != 0){
          $preweaningmortprop->value = round(((count($offsprings)-$weaned)/count($offsprings))*100, 4);
        }
        else{
          $preweaningmortprop->value = 100;
        }
                $preweaningmortprop->save();
            }
        }

        static::addParityMother($family->id);

        //gestation and lactation period
        $datebredprop = $properties->where("property_id", 42)->first();
        $datefarrowedprop = $properties->where("property_id", 3)->first();
        $dateweanedprop = $properties->where("property_id", 6)->first();
        if(!is_null($datebredprop) && !is_null($datefarrowedprop)){
            $datebred = Carbon::parse($datebredprop->value);
            $datefarrowed = Carbon::parse($datefarrowedprop->value);
            $gestationperiod = $datefarrowed->diffInDays($datebred);
        }
        else{
            $gestationperiod = "";
        }

        if(!is_null($datefarrowedprop) && !is_null($dateweanedprop)){
            $datefarrowed = Carbon::parse($datefarrowedprop->value);
            $dateweaned = Carbon::parse($dateweanedprop->value);
            $lactationperiod = $dateweaned->diffInDays($datefarrowed);
        }
        else{
            $lactationperiod = "";
        }

        $now = Carbon::now();

        // return $properties;

        return json_encode(compact('family', 'offsprings', 'properties', 'countMales', 'countFemales', 'aveBirthWeight', 'weaned', 'aveWeaningWeight', 'gestationperiod', 'lactationperiod', 'now'));

        // return view('pigs.sowlitterrecord', compact('family', 'offsprings', 'properties', 'countMales', 'countFemales', 'aveBirthWeight', 'weaned', 'aveWeaningWeight', 'gestationperiod', 'lactationperiod', 'now'));
    }

    public function addIndividualSowLitterRecord(Request $request){ // function to add sow litter record and offsprings
        $animalSow = Animal::where("registryid", $request->sow_id)->first();
        $animalBoar = Animal::where("registryid", $request->boar_id)->first();
        
        $group = Grouping::where("mother_id", $animalSow->id)
                            ->where("father_id", $animalBoar->id)
                            ->first();
        $grouping = Grouping::find($group->id);
        $members = $grouping->getGroupingMembers();

        $temp_earnotch = $request->offspring_earnotch;
        if(strlen($temp_earnotch) == 6){
            $earnotch = $temp_earnotch;
        }
        else{
            $earnotch = str_pad($temp_earnotch, 6, "0", STR_PAD_LEFT);
        }
        // adds new offspring
        // $birthdayValue = new Carbon($request->date_farrowed);
        $birthdayValue = Carbon::now();
        if(!is_null($request->offspring_earnotch) && !is_null($request->sex) && !is_null($request->birth_weight)){
            $offspring = new Animal;
            $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
            $offspring->animaltype_id = 3;
            $offspring->farm_id = $farm->id;
            $offspring->breed_id = $breed->id;
            $offspring->status = "active";
            $registryid = $farm->code.$breed->breed."-".$birthdayValue->year.$request->sex.$earnotch;
            $offspring->registryid = $registryid;
            $offspring->save();

            $earnotchproperty = new AnimalProperty;
            $earnotchproperty->animal_id = $offspring->id;
            $earnotchproperty->property_id = 1;
            $earnotchproperty->value = $earnotch;
            $earnotchproperty->save();

            $sex = new AnimalProperty;
            $sex->animal_id = $offspring->id;
            $sex->property_id = 2;
            $sex->value = $request->sex;
            $sex->save();

            $birthday = new AnimalProperty;
            $birthday->animal_id = $offspring->id;
            $birthday->property_id = 3;
            // $birthday->value = $request->date_farrowed;
            $birthday->value = $birthdayValue;
            $birthday->save();

            $registrationidproperty = new AnimalProperty;
            $registrationidproperty->animal_id = $offspring->id;
            $registrationidproperty->property_id = 4;
            $registrationidproperty->value = $registryid;
            $registrationidproperty->save();

            $birthweight = new AnimalProperty;
            $birthweight->animal_id = $offspring->id;
            $birthweight->property_id = 5;
            $birthweight->value = $request->birth_weight;
            $birthweight->save();

            $groupingmember = new GroupingMember;
            $groupingmember->grouping_id = $grouping->id;
            $groupingmember->animal_id = $offspring->id;
            $groupingmember->save();
        }

            // adds date farrowed as a group property
        $datefarrowedgroupprop = $grouping->getGroupingProperties()->where("property_id", 3)->first();
        if(is_null($datefarrowedgroupprop)){
            $date_farrowed = new GroupingProperty;
            $date_farrowed->grouping_id = $grouping->id;
            $date_farrowed->property_id = 3;
            // $date_farrowed->value = $request->date_farrowed;
            $date_farrowed->value = $birthdayValue;
            $date_farrowed->save();
        }
        else{
            // $datefarrowedgroupprop->value = $request->date_farrowed;
            $datefarrowedgroupprop->value = $birthdayValue;
            $datefarrowedgroupprop->save();
        }

        // changes status from Pregnant to Farrowed
        $status = GroupingProperty::where("property_id", 60)->where("grouping_id", $grouping->id)->first();
        $status->value = "Farrowed";
        $status->save();
    }

    public function addGroupSowLitterRecord(Request $request){
        $animalSow = Animal::where("registryid", $request->sow_id)->first();
        $animalBoar = Animal::where("registryid", $request->boar_id)->first();
        
        $group = Grouping::where("mother_id", $animalSow->id)
                            ->where("father_id", $animalBoar->id)
                            ->first();
        $grouping = Grouping::find($group->id);
        $members = $grouping->getGroupingMembers();

        // adds new offspring
        // $birthdayValue = new Carbon($request->date_farrowed);
        $birthdayValue = Carbon::now();
        $litterbirthweightprop = $grouping->getGroupingProperties()->where("property_id", 55)->first();
        if(is_null($litterbirthweightprop)){
            $litter_birth_weight = new GroupingProperty;
            $litter_birth_weight->grouping_id = $grouping->id;
            $litter_birth_weight->property_id = 55;
            $litter_birth_weight->value = $request->litter_birth_weight;
            $litter_birth_weight->save();
        }
        else{
            $litterbirthweightprop->value = $request->litter_birth_weight;
            $litterbirthweightprop->save();
        }

        $lsbaprop = $grouping->getGroupingProperties()->where("property_id", 50)->first();
        if(is_null($lsbaprop)){
            $lsba = new GroupingProperty;
            $lsba->grouping_id = $grouping->id;
            $lsba->property_id = 50;
            $lsba->value = $request->lsba;
            $lsba->save();
        }
        else{
            $lsbaprop->value = $request->lsba;
            $lsbaprop->save();
        }


        if(!is_null($request->offspring_earnotch) && !is_null($request->sex)){
            $offspring = new Animal;
            $farm = Farm::find($request->farmable_id);
            $breed = Breed::find($request->breedable_id);
            $offspring->animaltype_id = 3;
            $offspring->farm_id = $farm->id;
            $offspring->breed_id = $breed->id;
            $offspring->status = "temporary";
            $offspring->registryid = $farm->code.$breed->breed."-".$birthdayValue->year.$request->offspring_earnotch;
            $offspring->save();

            $birthday = new AnimalProperty;
            $birthday->animal_id = $offspring->id;
            $birthday->property_id = 3;
            // $birthday->value = $request->date_farrowed;
            $birthday->value = $birthdayValue;
            $birthday->save();

            $earnotch = new AnimalProperty;
            $earnotch->animal_id = $offspring->id;
            $earnotch->property_id = 1;
            $earnotch->value = $request->offspring_earnotch;
            $earnotch->save();

            $registryId = new AnimalProperty;
            $registryId->animal_id = $offspring->id;
            $registryId->property_id = 4;
            $registryId->value = $farm->code.$breed->breed."-".$birthdayValue->year.$request->offspring_earnotch;
            $registryId->save();

            $sex = new AnimalProperty;
            $sex->animal_id = $offspring->id;
            $sex->property_id = 2;
            $sex->value = $request->sex;
            $sex->save();

            $litterbirthweightValue = $request->litter_birth_weight;
            $lsbaValue = $request->lsba;

            $birthweight = new AnimalProperty;
            $birthweight->animal_id = $offspring->id;
            $birthweight->property_id = 5;
            $birthweight->value = round($litterbirthweightValue/$lsbaValue, 3);
            $birthweight->save();

            $groupingmember = new GroupingMember;
            $groupingmember->grouping_id = $grouping->id;
            $groupingmember->animal_id = $offspring->id;
            $groupingmember->save();
        }

        // adds date farrowed as a group property
        $datefarrowedgroupprop = $grouping->getGroupingProperties()->where("property_id", 3)->first();
        if(is_null($datefarrowedgroupprop)){
            $date_farrowed = new GroupingProperty;
            $date_farrowed->grouping_id = $grouping->id;
            $date_farrowed->property_id = 3;
            $date_farrowed->value = $birthdayValue;
            // $date_farrowed->value = $request->date_farrowed;
            $date_farrowed->save();
        }
        else{
            $datefarrowedgroupprop->value = $birthdayValue;
            // $datefarrowedgroupprop->value = $request->date_farrowed;
            $datefarrowedgroupprop->save();
        }

        // changes status from Pregnant to Farrowed
        $status = GroupingProperty::where("property_id", 60)->where("grouping_id", $grouping->id)->first();
        $status->value = "Farrowed";
        $status->save();
    }


    public function editSowLitterRecord(Request $request){
        $farm = Farm::find($request->farmable_id);
        $breed = Breed::find($request->breedable_id);
        $animalSow = Animal::where("registryid", $request->sow_id)->first();
        $animalBoar = Animal::where("registryid", $request->boar_id)->first();
        
        $group = Grouping::where("mother_id", $animalSow->id)
                            ->where("father_id", $animalBoar->id)
                            ->first();
        // $groupingId = $group->id;
        // $family = Grouping::find($group->id);
        $grouping = Grouping::find($group->id);
        $members = $grouping->getGroupingMembers();
        if(is_null($request->number_stillborn)){
            $noStillbornValue = 0;
        }
        else{
            $noStillbornValue = $request->number_stillborn;
        }

        $stillbornprop = $grouping->getGroupingProperties()->where("property_id", 45)->first();
        if(is_null($stillbornprop)){
            $no_stillborn = new GroupingProperty;
            $no_stillborn->grouping_id = $grouping->id;
            $no_stillborn->property_id = 45;
            $no_stillborn->value = $noStillbornValue;
            $no_stillborn->save();
        }
        else{
            $stillbornprop->value = $noStillbornValue;
            $stillbornprop->save();
        }

        if(is_null($request->number_mummified)){
            $noMummifiedValue = 0;
        }
        else{
            $noMummifiedValue = $request->number_mummified;
        }

        $mummifiedprop = $grouping->getGroupingProperties()->where("property_id", 46)->first();
        if(is_null($mummifiedprop)){
            $no_mummified = new GroupingProperty;
            $no_mummified->grouping_id = $grouping->id;
            $no_mummified->property_id = 46;
            $no_mummified->value = $noMummifiedValue;
            $no_mummified->save();
        }
        else{
            $mummifiedprop->value = $noMummifiedValue;
            $mummifiedprop->save();
        }

        if(is_null($request->abnormalities)){
            $abnormalityValue = "None";
        }
        else{
            $abnormalityValue = $request->abnormalities;
        }

        $abnormalityprop = $grouping->getGroupingProperties()->where("property_id", 47)->first();
        if(is_null($abnormalityprop)){
            $abnormality = new GroupingProperty;
            $abnormality->grouping_id = $grouping->id;
            $abnormality->property_id = 47;
            $abnormality->value = $abnormalityValue;
            $abnormality->save();
        }
        else{
            $abnormalityprop->value = $abnormalityValue;
            $abnormalityprop->save();
        }

        // adding parity
        $datefarrowedprop = $grouping->getGroupingProperties()->where("property_id", 3)->first();
        $parityprop = $grouping->getGroupingProperties()->where("property_id", 48)->first();
        if(is_null($datefarrowedprop)){ // NEW RECORD
            if(is_null($parityprop)){
                $paritymotherprop = $grouping->getMother()->getAnimalProperties()->where("property_id", 48)->first();
                if(is_null($paritymotherprop)){ // FIRST PARITY
                    if(is_null($request->parity)){
                        $parityValue = 1;
                    }
                    else{
                        $parityValue = $request->parity;
                    }
                    $parity = new GroupingProperty;
                    $parity->grouping_id = $grouping->id;
                    $parity->property_id = 76;
                    $parity->value = $parityValue;
                    $parity->save();
                }
                else{ // LATEST PARITY
                    if(is_null($request->parity)){
                        $parityValue = $paritymotherprop->value + 1;
                    }
                    else{
                        $parityValue = $request->parity;
                    }

                    $parity = new GroupingProperty;
                    $parity->grouping_id = $grouping->id;
                    $parity->property_id = 48;
                    $parity->value = $parityValue;
                    $parity->save();
                }
            }
        }
        else{ // EXISTING RECORD
            if(is_null($parityprop)){
                $paritymotherprop = $grouping->getMother()->getAnimalProperties()->where("property_id", 48)->first();
                if(is_null($paritymotherprop)){ // FIRST PARITY
                    if(is_null($request->parity)){
                        $parityValue = 1;
                    }
                    else{
                        $parityValue = $request->parity;
                    }

                    $parity = new GroupingProperty;
                    $parity->grouping_id = $grouping->id;
                    $parity->property_id = 48;
                    $parity->value = $parityValue;
                    $parity->save();
                }
                else{ // LATEST PARITY
                    if(is_null($request->parity)){
                        $parityValue = $paritymotherprop->value + 1;
                    }
                    else{
                        $parityValue = $request->parity;
                    }
                    $parity = new GroupingProperty;
                    $parity->grouping_id = $grouping->id;
                    $parity->property_id = 48;
                    $parity->value = $parityValue;
                    $parity->save();
                }
            }
            else{
                $parityprop->value = $request->parity;
                $parityprop->save();
            }
        }

        // function call to update parity of mother
        static::addParityMother($grouping->id);

        $grouping->members = 1;
        $grouping->save();
    }


    public function editRegistryId(Request $request){
        // $animalBoar = Animal::where("registryid", $request->boar_id)->first();
            $animal = AnimalProperty::where("property_id", 1)
                                        ->where("value", $request->old_earnotch)
                                        ->first();      
            $offspring = Animal::find($animal->animal_id);

            $family = $offspring->getGrouping();
            $members = $family->getGroupingMembers();

            $offspringproperties = $offspring->getAnimalProperties();
            $farm = Farm::find($request->farmable_id);
            $breed = Breed::find($request->breedable_id);
            $birthdate = Carbon::parse($offspringproperties->where("property_id", 3)->first()->value);
            $sex = $offspringproperties->where("property_id", 2)->first()->value;

            $temp_earnotch = $request->new_earnotch;
            if(strlen($temp_earnotch) == 6){
                $earnotch = $temp_earnotch;
            }
            else{
                $earnotch = str_pad($temp_earnotch, 6, "0", STR_PAD_LEFT);
            }

            //checks if earnotch is unique
            $conflict = [];
            foreach ($members as $member) {
                $offspring = $member->getChild();
                if(substr($offspring->registryid, -6, 6) == $earnotch){
                    array_push($conflict, "1");
                }
                else{
                    array_push($conflict, "0");
                }
            }

            if(!in_array("1", $conflict, false)){
                // return $farm;
                $registryid = $farm->code.$breed->breed."-".$birthdate->year.$sex.$earnotch;
                $offspring->registryid = $registryid;
                $offspring->save();

                $earnotchprop = $offspringproperties->where("property_id", 1)->first();
                $earnotchprop->value = $earnotch;
                $earnotchprop->save();

                $registryidprop = $offspringproperties->where("property_id", 4)->first();
                $registryidprop->value = $registryid;
                $registryidprop->save();
            }

            // return Redirect::back()->with('message', 'Operation Successful!');
        }

        public function editSex(Request $request){
            $animal = AnimalProperty::where("property_id", 1)
                                ->where("value", $request->earnotch)
                                ->first();

            $offspring = Animal::find($animal->animal_id);
            $offspringproperties = $offspring->getAnimalProperties();

            $farm = Farm::find($request->farmable_id);
            $breed = Breed::find($request->breedable_id);
            $birthdate = Carbon::parse($offspringproperties->where("property_id", 3)->first()->value);
            $sexValue = $request->new_sex;
            $earnotch = $offspringproperties->where("property_id", 1)->first()->value;

            $sexprop = $offspringproperties->where("property_id", 2)->first();
            $sexprop->value = $sexValue;
            $sexprop->save();

            $registryid = $farm->code.$breed->breed."-".$birthdate->year.$sexValue.$earnotch;
            $registryidprop = $offspringproperties->where("property_id", 4)->first();
            $registryidprop->value = $registryid;
            $registryidprop->save();

            $offspring->registryid = $registryid;
            $offspring->save();

            // return Redirect::back()->with('message', 'Operation Successful!');
        }

        public function editBirthWeight(Request $request){
            $animal = AnimalProperty::where("property_id", 1)
                                ->where("value", $request->earnotch)
                                ->first();

            $offspring = Animal::find($animal->animal_id);

            $bweight = $offspring->getAnimalProperties()->where("property_id", 5)->first();
            $bweightValue = $request->new_birth_weight;

            $bweight->value = $bweightValue;
            $bweight->save();
            // return Redirect::back()->with('message', 'Operation Successful!');
        }

        // public function editTemporaryRegistryId(Request $request){
        //     $offspring = Animal::find($request->old_earnotch);
        //     $family = $offspring->getGrouping();
        //     $members = $family->getGroupingMembers();

        //     $offspringproperties = $offspring->getAnimalProperties();
        //     $farm = $this->user->getFarm();
        //     $breed = $farm->getBreed();
        //     $birthdate = Carbon::parse($offspringproperties->where("property_id", 3)->first()->value);
        //     $sex = $offspringproperties->where("property_id", 2)->first()->value;

        //     $temp_earnotch = $request->new_earnotch;
        //     if(strlen($temp_earnotch) == 6){
        //         $earnotch = $temp_earnotch;
        //     }
        //     else{
        //         $earnotch = str_pad($temp_earnotch, 6, "0", STR_PAD_LEFT);
        //     }

        //     //checks if earnotch is unique
        //     $conflict = [];
        //     foreach ($members as $member) {
        //         $offspring = $member->getChild();
        //         if(substr($offspring->registryid, -6, 6) == $earnotch){
        //             array_push($conflict, "1");
        //         }
        //         else{
        //             array_push($conflict, "0");
        //         }
        //     }

        //     if(!in_array("1", $conflict, false)){
        //         $registryid = $farm->code.$breed->breed."-".$birthdate->year.$sex.$earnotch;
        //         $offspring->registryid = $registryid;
        //         $offspring->status = "active";
        //         $offspring->save();

        //         $earnotchproperty = new AnimalProperty;
        //         $earnotchproperty->animal_id = $offspring->id;
        //         $earnotchproperty->property_id = 1;
        //         $earnotchproperty->value = $earnotch;
        //         $earnotchproperty->save();

        //         $registrationidproperty = new AnimalProperty;
        //         $registrationidproperty->animal_id = $offspring->id;
        //         $registrationidproperty->property_id = 4;
        //         $registrationidproperty->value = $registryid;
        //         $registrationidproperty->save();
        //     }

        //     return Redirect::back()->with('message', 'Operation Successful!');
        // }

        public function updateOffspringRecord(Request $request){ // function to add weaning weights per offspring
            $animal = AnimalProperty::where("property_id", 1)
                                ->where("value", $request->earnotch)
                                ->first();
            // return $animal;
            $groupingMember = GroupingMember::where("animal_id", $animal->animal_id)->first();
            // return $groupingMember;
            $grouping = Grouping::find($groupingMember->grouping_id);
            $offspring = Animal::find($groupingMember->animal_id);
            $offspringproperties = $offspring->getAnimalProperties();

            $dateweanedprop = $grouping->getGroupingProperties()->where("property_id", 6)->first();
            if(is_null($dateweanedprop)){
                $date_weaned_group = new GroupingProperty;
                $date_weaned_group->grouping_id = $grouping->id;
                $date_weaned_group->property_id = 6;
                $date_weaned_group->value = $request->date_weaned;
                $date_weaned_group->save();

                $date_weaned_individual = new AnimalProperty;
                $date_weaned_individual->animal_id = $offspring->id;
                $date_weaned_individual->property_id = 6;
                $date_weaned_individual->value = $request->date_weaned;
                $date_weaned_individual->save();

                $weaningweight = new AnimalProperty;
                $weaningweight->animal_id = $offspring->id;
                $weaningweight->property_id = 7;
                $weaningweight->value = $request->weaning_weight;
                $weaningweight->save();
            }
            else{
                $dateweanedprop->value = $request->date_weaned;
                $dateweanedprop->save();

                $date_weaned_individual = $offspring->getAnimalProperties()->where("property_id", 6)->first();
                if($date_weaned_individual==null){
                    $date_weaned_individual = new AnimalProperty;
                    $date_weaned_individual->animal_id = $offspring->id;
                    $date_weaned_individual->property_id = 6;
                }
                $date_weaned_individual->value = $dateweanedprop->value;
                $date_weaned_individual->save();

                $weaningweight = $offspring->getAnimalProperties()->where("property_id", 7)->first();
                if($weaningweight==null){
                    $weaningweight = new AnimalProperty;
                    $weaningweight->animal_id = $offspring->id;
                    $weaningweight->property_id = 7;
                }
                $weaningweight->value = $request->weaning_weight;
                $weaningweight->save();
            }

            $bweight = $offspring->getAnimalProperties()->where("property_id", 5)->first();
            $bweightValue = $request->new_birth_weight;
            $bweight->value = $bweightValue;
            $bweight->save();
            

            $farm = Farm::find($request->farmable_id);
            $breed = Breed::find($request->breedable_id);
            $birthdate = Carbon::parse($offspringproperties->where("property_id", 3)->first()->value);
            $sexValue = $request->new_sex;
            $earnotch = $offspringproperties->where("property_id", 1)->first()->value;

            $sexprop = $offspringproperties->where("property_id", 2)->first();
            $sexprop->value = $sexValue;
            $sexprop->save();

            $registryid = $farm->code.$breed->breed."-".$birthdate->year.$sexValue.$earnotch;
            $registryidprop = $offspringproperties->where("property_id", 4)->first();
            $registryidprop->value = $registryid;
            $registryidprop->save();

            $offspring->registryid = $registryid;
            $offspring->save();

        }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*
     * functions used for adding from local to server
     * adding is done per table
     */
    public function addToAnimalDb(Request $request){
        $animal = Animal::where("registryid", $request->registryid)
            ->where("farm_id", $request->farm_id)  
            ->first();

        //if registryid already exists in animal db, return
        if($animal != null)
            return "registryid already exists in animal db";

        $newpig = new Animal;
        $newpig->animaltype_id = $request->animaltype_id;
        $newpig->registryid = $request->registryid;
        $newpig->farm_id = $request->farm_id;
        $newpig->breed_id = $request->breed_id;
        $newpig->grossmorpho = $request->grossmorpho;
        $newpig->morphochars = $request->morphochars;
        $newpig->weightrecord = $request->weightrecord;
        $newpig->status = $request->status;
        $newpig->save();
    }

    public function addToAnimalPropertiesDb(Request $request){
        $animal = Animal::where("registryid", $request->registryid)
            ->first();

        //if registryid is not existing in animal db, return
        if($animal == null)
            return "registryid is not existing in animal db";

        $newprop = new AnimalProperty;
        $newprop->animal_id = $animal->id;
        $newprop->property_id = $request->property_id;
        $newprop->value = $request->value;
        $newprop->save();
    }

    public function addToGroupingDb(Request $request){
        $animal_mother = Animal::where("registryid", $request->mother_registryid)
            ->where("breed_id", $request->breed_id)
            ->first();

        $animal_father = Animal::where("registryid", $request->father_registryid)
            ->where("breed_id", $request->breed_id)
            ->first();

        //if either mother or father is not existing in animal db, return
        if($animal_mother==null || $animal_father==null)
            return "Either mother or father not existing in animal db";

        $newgrouping = new Grouping;
        $newgrouping->registryid = $animal_mother->registryid;
        $newgrouping->mother_id = $animal_mother->id;
        $newgrouping->father_id = $animal_father->id;
        $newgrouping->breed_id = $request->breed_id;
        $newgrouping->members = $request->members;
        $newgrouping->save();
    }

    public function addToGroupingMembersDb(Request $request){
        $animal_mother = Animal::where("registryid", $request->mother_registryid)
            ->where("breed_id", $request->breed_id)
            ->first();
        $animal_father = Animal::where("registryid", $request->father_registryid)
            ->where("breed_id", $request->breed_id)
            ->first();

        $grouping = Grouping::where("mother_id", $animal_mother->id)
            ->where("father_id", $animal_father->id)
            ->first();
        $animal = Animal::where("registryid", $request->registryid)
            ->first();

        //if grouping or animal is not existing in db, return
        if($grouping == null)
            return "grouping not existing in grouping db";
        if($animal == null)
            return "animal not existing in animal db";

        $newmember = new GroupingMember;
        $newmember->grouping_id = $grouping->id;
        $newmember->animal_id = $animal->id;
        $newmember->save();
    }

    public function addToGroupingPropertiesDb(Request $request){
        $animal_mother = Animal::where("registryid", $request->mother_registryid)
            ->where("breed_id", $request->breed_id)
            ->first();
        $animal_father = Animal::where("registryid", $request->father_registryid)
            ->where("breed_id", $request->breed_id)
            ->first();

        $grouping = Grouping::where("mother_id", $animal_mother->id)
            ->where("father_id", $animal_father->id)
            ->first();

        //if grouping is not existing in db, return
        if($grouping == null)
            return "grouping not existing in grouping db";

        $newprop = new GroupingProperty;
        $newprop->grouping_id = $grouping->id;
        $newprop->property_id = $request->property_id;
        $newprop->value = $request->value;
        $newprop->save();
    }

    public function addToMortalitiesDb(Request $request){
        $animal = Animal::where("registryid", $request->registryid)
            ->first();

        //if animal is not existing, return
        if($animal == null)
            return "animal is not existing in animal db";

        $mortality = new Mortality;
        $mortality->animal_id = $animal->id;
        $mortality->animaltype_id = $request->animaltype_id;
        $mortality->breed_id = $request->breed_id;
        $mortality->datedied = $request->datedied;
        $mortality->cause = $request->cause;
        $mortality->age = $request->age;
        $mortality->save();
    }

    public function addToRemovedAnimalsDb(Request $request){
        $animal = Animal::where("registryid", $request->registryid)
            ->first();

        //if animal is not existing, return
        if($animal == null)
            return "animal is not existing in animal db";

        $removed = new RemovedAnimal;
        $removed->animal_id = $animal->id;
        $removed->animaltype_id = $request->animaltype_id;
        $removed->breed_id = $request->breed_id;
        $removed->dateremoved = $request->dateremoved;
        $removed->reason = $request->reason;
        $removed->age = $request->age;
        $removed->save();
    }

    public function addToSalesDb(Request $request){
        $animal = Animal::where("registryid", $request->registryid)
            ->where("breed_id", $request->breed_id)
            ->first();

        //if animal is not existing, return
        if($animal == null)
            return "animal is not existing in animal db";

        $sales = new Sale;
        $sales->animal_id = $animal->id;
        $sales->animaltype_id = $request->animaltype_id;
        $sales->breed_id = $request->breed_id;
        $sales->datesold = $request->datesold;
        $sales->weight = $request->weight;
        $sales->price = $request->price;
        $sales->age = $request->age;
        $sales->save();
    }

    public function editFarmProfile(Request $request){ // function to add farm profile
        // $user = Auth::User();
        $farm = User::find($request->farmable_id);
        $breed = Farm::find($request->breedable_id);

        // $photo = Uploads::whereNull("animal_id")->whereNull("animaltype_id")->where("breed_id", $breed->id)->first();

        $breed->region = $request->region;
        $breed->town = $request->town;
        $breed->barangay = $request->barangay;
        $farm->phone = $request->phone_number;
        $farm->save();
        $breed->save();
    }

    public function getFarmProfilePage(Request $request){ // function to display Farm Profile page
        $farm = User::find($request->farmable_id);
        $breed = Farm::find($request->breedable_id);
        $user = Breed::where('id', $request->breedable_id)->first();

        return json_encode(compact('farm', 'breed', 'user'));
    }

    public function getEmail(Request $request){
        $user = User::where('email', $request->email)->first();

         return json_encode(compact('user'));
    }

    // public function getBreed(){

    // }

    //  $animal = Animal::where("registryid", $request->registry_id)->first();
    //     $properties = $animal->getAnimalProperties();

    //     return json_encode(compact('animal', 'properties'));



    /*
     * functions used for getting from server to local
     */
    public function getAnimalDb(Request $request){
        return Animal::where("breed_id", $request->breedable_id)->get();
    }

    public function getAnimalPropertiesDb(Request $request){
        $animals = Animal::select("id")
            ->distinct()
            ->where("breed_id", $request->breedable_id)
            ->get()
            ->toArray();

        return AnimalProperty::whereIn("animal_id", $animals)->get();
    }

    public function getGroupingsDb(Request $request){
        return Grouping::where("breed_id", $request->breedable_id)->get();
    }

    public function getGroupingMembersDb(Request $request){
        $groupings = Grouping::select("id")
            ->distinct()
            ->where("breed_id", $request->breedable_id)
            ->get()
            ->toArray();

        return GroupingMember::whereIn("grouping_id", $groupings)->get();
    }

    public function getGroupingPropertiesDb(Request $request){
        $groupings = Grouping::select("id")
            ->distinct()
            ->where("breed_id", $request->breedable_id)
            ->get()
            ->toArray();

        return GroupingProperty::whereIn("grouping_id", $groupings)->get();
    }

    public function getMortalitiesDb(Request $request){
        return Mortality::where("breed_id", $request->breedable_id)->get();
    }

    public function getRemovedAnimalsDb(Request $request){
        return RemovedAnimal::where("breed_id", $request->breedable_id)->get();
    }

    public function getSalesDb(Request $request){
        return Sale::where("breed_id", $request->breedable_id)->get();
    }
}
