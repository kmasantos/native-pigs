<?php

namespace App\Http\Controllers;

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
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\Http\Controllers\HelperController;

class FarmController extends Controller
{
    protected $user;

    public function __construct()
    {
      $this->middleware(function($request, $next){
          $this->user = Auth::user();
          return $next($request);
      });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = $this->user;
      $farm = Farm::find($user->farmable_id);
      $breed = Breed::find($farm->breedable_id);
      $animaltype = AnimalType::find($breed->animaltype_id);
      if($animaltype->species == "pig"){
          $pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();
          $breeders = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

          // sorts growers per sex
          $femalegrowers = [];
          $malegrowers = [];
          foreach($pigs as $pig){
            if(substr($pig->registryid, -7, 1) == 'F'){
              array_push($femalegrowers, $pig);
            }
            if(substr($pig->registryid, -7, 1) == 'M'){
              array_push($malegrowers, $pig);
            }
          }

          // sorts breeders per sex
          $femalebreeders = [];
          $malebreeders = [];
          foreach($breeders as $breeder){
            if(substr($breeder->registryid, -7, 1) == 'F'){
              array_push($femalebreeders, $breeder);
            }
            if(substr($breeder->registryid, -7, 1) == 'M'){
              array_push($malebreeders, $breeder);
            }
          }
          
          return view('pigs.dashboard', compact('user', 'farm', 'pigs', 'breeders', 'femalegrowers', 'malegrowers', 'femalebreeders', 'malebreeders'));
      }else{
          return view('poultry.dashboard', compact('user', 'farm'));
      }

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
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function show(Farm $farm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function edit(Farm $farm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Farm $farm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Farm $farm)
    {
        //
    }

    /***** FUNCTIONS FOR PIG *****/

    public function getPedigreePage(){ // function to display View Pedigree page
      return view('pigs.pedigree');
    }

    public function fetchParityAjax($familyidvalue, $parityvalue){ // function to save parity onchange
      $grouping = Grouping::find($familyidvalue);
      $paritypropgroup = $grouping->getGroupingProperties()->where("property_id", 76)->first();

      $paritypropgroup->value = $parityvalue;
      $paritypropgroup->save();
    }

    static function addParityMother($id){
      $grouping = Grouping::find($id);
      $mother = $grouping->getMother();

      $parityprop = $mother->getAnimalProperties()->where("property_id", 76)->first();
      $paritypropgroup = $grouping->getGroupingProperties()->where("property_id", 76)->first();
      $status = $grouping->getGroupingProperties()->where("property_id", 50)->first();
      $families = Grouping::where("mother_id", $mother->id)->get();

      //mother's parity property value == latest parity
      $parities = [];
			foreach ($families as $family) {
        $familyproperties = $family->getGroupingProperties();
        foreach ($familyproperties as $familyproperty) {
          if($familyproperty->property_id == 50){
            if($familyproperty->value == "Farrowed"){ // parities are added only when sow already farrowed
              $farrowedproperties = $family->getGroupingProperties();
              foreach ($farrowedproperties as $farrowedproperty) {
                if($farrowedproperty->property_id == 76){
                  if(!is_null($farrowedproperty->value)){
                    array_push($parities, $farrowedproperty->value);
                  }
                }
              }
            }
            if($familyproperty->value == "Pregnant" || $familyproperty->value == "Recycled"){
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
	        $parity->property_id = 76;
	        $parity->value = array_last($sorted_parities); // gets the last element of the array
	        $parity->save();
      	}
      	else{
      		$parity = new AnimalProperty;
	        $parity->animal_id = $mother->id;
	        $parity->property_id = 76;
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

    public function getAddSowLitterRecordPage($id){ // function to display Sow-Litter Record page
      $family = Grouping::find($id);
      $properties = $family->getGroupingProperties();
      $offsprings = $family->getGroupingMembers();

      // counts offsprings per sex
      $countMales = 0;
      $countFemales = 0;
      foreach ($offsprings as $offspring) {
        $propscount = $offspring->getAnimalProperties();
        foreach ($propscount as $propcount) {
          if($propcount->property_id == 27){
            if($propcount->value == 'M'){
              $countMales = $countMales + 1;
            }
            if($propcount->value == 'F'){
              $countFemales = $countFemales + 1;
            }
          }
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
            if($propbweight->property_id == 53){
              $bweight = $propbweight->value;
              array_push($bweights, $bweight);
            }
          }
        }
        $sum = array_sum($bweights);
        $aveBirthWeight = $sum/count($offsprings);
      }

      // counts number of pigs weaned
      $weaned = 0;
      foreach ($offsprings as $offspring) {
        if(!is_null($offspring->getAnimalProperties()->where("property_id", 54)->first())){
          $weaned = $weaned + 1;
        }
      }

      // computes for average weaning weight
      $sumww = 0;
      $aveWeaningWeight = 0;
      $weights = [];
      if(count($offsprings) != 0 && $weaned != 0){
        foreach ($offsprings as $offspring) {
          $propswweight = $offspring->getAnimalProperties();
          foreach ($propswweight as $propwweight) {
            if($propwweight->property_id == 54){
              $weight = $propwweight->value;
              array_push($weights, $weight);
            }
          }
        }
        $sumww = array_sum($weights);
        $aveWeaningWeight = $sumww/$weaned;
      }

      // dd($offsprings);
      // static::addParityMother($id);

      return view('pigs.sowlitterrecord', compact('family', 'offsprings', 'properties', 'countMales', 'countFemales', 'aveBirthWeight', 'weaned', 'aveWeaningWeight'));
    }

    public function getBreedingRecordPage(){ // function to display Breeding Record page
      $growers = Animal::where("animaltype_id", 3)->where("status", "active")->get();
      $breeders = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();
      $family = Grouping::whereNotNull("mother_id")->get();

      // sorts growers per sex
      $femalegrowers = [];
      $malegrowers = [];
      foreach($growers as $grower){
        if(substr($grower->registryid, -7, 1) == 'F'){
          array_push($femalegrowers, $grower);
        }
        if(substr($grower->registryid, -7, 1) == 'M'){
          array_push($malegrowers, $grower);
        }
      }

      // sorts breeders per sex
      $sows = [];
      $boars = [];
      foreach($breeders as $breeder){
        if(substr($breeder->registryid, -7, 1) == 'F'){
          array_push($sows, $breeder);
        }
        if(substr($breeder->registryid, -7, 1) == 'M'){
          array_push($boars, $breeder);
        }
      }

      // automatically updates mother's parity
      foreach ($family as $group) {
      	static::addParityMother($group->id);
      }

      // TO FOLLOW: this will be used for filtering results
      $years = ["2010", "2011", "2012", "2013", "2014", "2015", "2016", "2017", "2018", "2019", "2020", "2021", "2022", "2023", "2024", "2025"];

      return view('pigs.breedingrecord', compact('pigs', 'sows', 'boars', 'femalegrowers', 'malegrowers', 'family', 'years'));
    }

    public function getMortalityAndSalesPage(){ // function to display Mortality and Sales page
      $pigs = Animal::where("animaltype_id", 3)->get();
      $growers = Animal::where("animaltype_id", 3)->where("status", "active")->get();
      $breeders = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

      // classifies animals per status
      $sold = [];
      $dead = [];
      $removed = [];
      foreach ($pigs as $pig){
        if($pig->status == "sold breeder" || $pig->status == "sold grower"){
          array_push($sold, $pig);
        }
        if($pig->status == "dead breeder" || $pig->status == "dead grower"){
          array_push($dead, $pig);
        }
        if($pig->status == "removed"){
          array_push($removed, $pig);
        }
      }

      // TO FOLLOW: this will be used for filtering results
      $years = ["2010", "2011", "2012", "2013", "2014", "2015", "2016", "2017", "2018", "2019", "2020", "2021", "2022", "2023", "2024", "2025"];

      return view('pigs.mortalityandsales', compact('pigs', 'growers', 'breeders', 'sold', 'dead', 'removed', 'years'));
    }

    public static function getNumPigsBornOnYear($year, $filter){ // function to get number of pigs born on specific year
    	$pigs = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

    	// gets pigs born on the specified year
    	$pigsbornonyear = [];
    	foreach ($pigs as $pig) {
    		if(substr($pig->registryid, -11, 4) == $year){
          array_push($pigsbornonyear, $pig);
        }
    	}

    	// sorts pigs by sex
    	$sows = [];
      $boars = [];
      foreach ($pigs as $pig) {
        if(substr($pig->registryid, -7, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -7, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      // gets pigs born on the specified year per sex
      $sowsbornonyear = [];
      $boarsbornonyear = [];
      foreach ($sows as $sow) {
      	if(substr($sow->registryid, -11, 4) == $year){
      		array_push($sowsbornonyear, $sow);
      	}
      }
      foreach ($boars as $boar) {
      	if(substr($boar->registryid, -11, 4) == $year){
      		array_push($boarsbornonyear, $boar);
      	}
      }

      // returns number of pigs born on specified year depending on the filter selected
      if($filter == "All"){
      	return $pigsbornonyear;
      }
      elseif($filter == "Sow"){
      	return $sowsbornonyear;
      }
      elseif($filter == "Boar"){
      	return $boarsbornonyear;
      }
    }

    public static function getGrossMorphologyPerYearOfBirth($year, $property_id, $filter, $value){ // function to get summarized gross morphology report per year of birth
    	$pigs = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

    	// gets pigs born on the specified year
    	$pigsbornonyear = [];
    	foreach ($pigs as $pig) {
    		if(substr($pig->registryid, -11, 4) == $year){
          array_push($pigsbornonyear, $pig);
        }
    	}

    	// sorts pigs by sex
    	$sows = [];
      $boars = [];
      foreach ($pigs as $pig) {
        if(substr($pig->registryid, -7, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -7, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      // gets pigs born on the specified year per sex
      $sowsbornonyear = [];
      $boarsbornonyear = [];
      foreach ($sows as $sow) {
      	if(substr($sow->registryid, -11, 4) == $year){
      		array_push($sowsbornonyear, $sow);
      	}
      }
      foreach ($boars as $boar) {
      	if(substr($boar->registryid, -11, 4) == $year){
      		array_push($boarsbornonyear, $boar);
      	}
      }

    	if($filter == "All"){ // data returned are for all pigs in the herd
    		$grossmorpho = [];
	    	foreach ($pigsbornonyear as $bornpig) { // traversing all pigs born on specified year
	    		$properties = $bornpig->getAnimalProperties();
	    		foreach ($properties as $property) {
	    			if($property->property_id == $property_id){
	    				if($property->value == $value){
	    					$gmorpho = $property->value;
	    					array_push($grossmorpho, $property);
	    				}
	    			}
	    		}
	    	}

    		return $grossmorpho;
    	}
    	elseif($filter == "Sow"){ // data returned are for all sows
    		$grossmorpho = [];
	    	foreach ($sowsbornonyear as $bornsow) {
	    		$properties = $bornsow->getAnimalProperties();
	    		foreach ($properties as $property) {
	    			if($property->property_id == $property_id){
	    				if($property->value == $value){
	    					array_push($grossmorpho, $property);
	    				}
	    			}
	    		}
	    	}

    		return $grossmorpho;
    	}
    	elseif($filter == "Boar"){ // data returned are for all boars
    		$grossmorpho = [];
	    	foreach ($boarsbornonyear as $bornboar) {
	    		$properties = $bornboar->getAnimalProperties();
	    		foreach ($properties as $property) {
	    			if($property->property_id == $property_id){
	    				if($property->value == $value){
	    					array_push($grossmorpho, $property);
	    				}
	    			}
	    		}
	    	}

    		return $grossmorpho;
    	}
    }

    public function getGrossMorphologyReportPage(){ // function to display Gross Morphology Report page
      $pigs = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

      // default filter
      $filter = "All";

      // sorts pigs per sex
      $sows = [];
      $boars = [];
      foreach ($pigs as $pig) {
        if(substr($pig->registryid, -7, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -7, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      // gets the unique years of birth
      $years = [];
      $tempyears = [];
      foreach ($pigs as $pig) {
      	$pigproperties = $pig->getAnimalProperties();
      	foreach ($pigproperties as $pigproperty) {
      		if($pigproperty->property_id == 25){
      			if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
      				$year = Carbon::parse($pigproperty->value)->year;
      				array_push($tempyears, $year);
      				$years = array_sort(array_unique($tempyears));
      			}
      		}
      	}
      }

      $curlyhairs = [];
      $straighthairs = [];
      $shorthairs = [];
      $longhairs = [];
      $blackcoats = [];
      $nonblackcoats = [];
      $plains = [];
      $socks = [];
      $concaves = [];
      $straightheads = [];
      $smooths = [];
      $wrinkleds = [];
      $droopingears = [];
      $semilops = [];
      $erectears = [];
      $curlytails = [];
      $straighttails = [];
      $swaybacks = [];
      $straightbacks = [];
      foreach ($pigs as $pig) {
        $properties = $pig->getAnimalProperties();
        foreach ($properties as $property) {
          if($property->property_id == 28){ //hairtype
            if($property->value == "Curly"){
              array_push($curlyhairs, $property);
            }
            elseif($property->value == "Straight"){
              array_push($straighthairs, $property);
            }
          }
          if($property->property_id == 29){ //hairlength
            if($property->value == "Short"){
              array_push($shorthairs, $property);
            }
            elseif($property->value == "Long"){
              array_push($longhairs, $property);
            }
          }
          if($property->property_id == 30){ //coatcolor
            if($property->value == "Black"){
              array_push($blackcoats, $property);
            }
            elseif($property->value == "Others"){
              array_push($nonblackcoats, $property);
            }
          }
          if($property->property_id == 31){ //colorpattern
            if($property->value == "Plain"){
              array_push($plains, $property);
            }
            elseif($property->value == "Socks"){
              array_push($socks, $property);
            }
          }
          if($property->property_id == 32){ //headshape
            if($property->value == "Concave"){
              array_push($concaves, $property);
            }
            elseif($property->value == "Straight"){
              array_push($straightheads, $property);
            }
          }
          if($property->property_id == 33){ //skintype
            if($property->value == "Smooth"){
              array_push($smooths, $property);
            }
            elseif($property->value == "Wrinkled"){
              array_push($wrinkleds, $property);
            }
          }
          if($property->property_id == 34){ //eartype
            if($property->value == "Drooping"){
              array_push($droopingears, $property);
            }
            elseif($property->value == "Semi-lop"){
              array_push($semilops, $property);
            }
            elseif($property->value == "Erect"){
              array_push($erectears, $property);
            }
          }
          if($property->property_id == 62){ //tailtype
            if($property->value == "Curly"){
              array_push($curlytails, $property);
            }
            elseif($property->value == "Straight"){
              array_push($straighttails, $property);
            }
          }
          if($property->property_id == 35){ //backline
            if($property->value == "Swayback"){
              array_push($swaybacks, $property);
            }
            elseif($property->value == "Straight"){
              array_push($straightbacks, $property);
            }
          }
        }
      }  

      // counts the pigs without records
      $nohairtypes = (count($pigs)-(count($curlyhairs)+count($straighthairs)));
      $nohairlengths = (count($pigs)-(count($shorthairs)+count($longhairs)));
      $nocoats = (count($pigs)-(count($blackcoats)+count($nonblackcoats)));
      $nopatterns = (count($pigs)-(count($plains)+count($socks)));
      $noheadshapes = (count($pigs)-(count($concaves)+count($straightheads)));
      $noskintypes = (count($pigs)-(count($smooths)+count($wrinkleds)));
      $noeartypes = (count($pigs)-(count($droopingears)+count($semilops)+count($erectears)));
      $notailtypes = (count($pigs)-(count($curlytails)+count($straighttails)));
      $nobacklines = (count($pigs)-(count($swaybacks)+count($straightbacks)));

      return view('pigs.grossmorphoreport', compact('pigs', 'filter', 'sows', 'boars', 'curlyhairs', 'straighthairs', 'shorthairs', 'longhairs', 'blackcoats', 'nonblackcoats', 'plains', 'socks', 'concaves', 'straightheads', 'smooths', 'wrinkleds', 'droopingears', 'semilops', 'erectears', 'curlytails', 'straighttails', 'swaybacks', 'straightbacks', 'nohairtypes', 'nohairlengths', 'nocoats', 'nopatterns', 'noheadshapes', 'noskintypes', 'noeartypes', 'notailtypes', 'nobacklines', 'years'));
    }

    public function filterGrossMorphologyReport(Request $request){ // function to filter Gross Morphology Report onclick
      $pigs = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

      $filter = $request->filter_keywords;

      $sowwithdata = 0;
      $boarwithdata = 0;

      // sorts pigs per sex
      $sows = [];
      $boars = [];
      foreach ($pigs as $pig) {
        if(substr($pig->registryid, -7, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -7, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      // gets the unique years of birth
      $years = [];
      $tempyears = [];
      foreach ($pigs as $pig) {
      	$pigproperties = $pig->getAnimalProperties();
      	foreach ($pigproperties as $pigproperty) {
      		if($pigproperty->property_id == 25){
      			if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
      				$year = Carbon::parse($pigproperty->value)->year;
      				array_push($tempyears, $year);
      				$years = array_sort(array_unique($tempyears));
      			}
      		}
      	}
      }

      if($filter == "Sow"){ // data displayed are for all sows
        $curlyhairs = [];
        $straighthairs = [];
        $shorthairs = [];
        $longhairs = [];
        $blackcoats = [];
        $nonblackcoats = [];
        $plains = [];
        $socks = [];
        $concaves = [];
        $straightheads = [];
        $smooths = [];
        $wrinkleds = [];
        $droopingears = [];
        $semilops = [];
        $erectears = [];
        $curlytails = [];
        $straighttails = [];
        $swaybacks = [];
        $straightbacks = [];
        foreach ($sows as $sow) {
          $properties = $sow->getAnimalProperties();
          foreach ($properties as $property) {
            if($property->property_id == 28){ //hairtype
              if($property->value == "Curly"){
                array_push($curlyhairs, $property);
              }
              elseif($property->value == "Straight"){
                array_push($straighthairs, $property);
              }
            }
            if($property->property_id == 29){ //hairlength
              if($property->value == "Short"){
                array_push($shorthairs, $property);
              }
              elseif($property->value == "Long"){
                array_push($longhairs, $property);
              }
            }
            if($property->property_id == 30){ //coatcolor
              if($property->value == "Black"){
                array_push($blackcoats, $property);
              }
              elseif($property->value == "Others"){
                array_push($nonblackcoats, $property);
              }
            }
            if($property->property_id == 31){ //colorpattern
              if($property->value == "Plain"){
                array_push($plains, $property);
              }
              elseif($property->value == "Socks"){
                array_push($socks, $property);
              }
            }
            if($property->property_id == 32){ //headshape
              if($property->value == "Concave"){
                array_push($concaves, $property);
              }
              elseif($property->value == "Straight"){
                array_push($straightheads, $property);
              }
            }
            if($property->property_id == 33){ //skintype
              if($property->value == "Smooth"){
                array_push($smooths, $property);
              }
              elseif($property->value == "Wrinkled"){
                array_push($wrinkleds, $property);
              }
            }
            if($property->property_id == 34){ //eartype
              if($property->value == "Drooping"){
                array_push($droopingears, $property);
              }
              elseif($property->value == "Semi-lop"){
                array_push($semilops, $property);
              }
              elseif($property->value == "Erect"){
                array_push($erectears, $property);
              }
            }
            if($property->property_id == 62){ //tailtype
              if($property->value == "Curly"){
                array_push($curlytails, $property);
              }
              elseif($property->value == "Straight"){
                array_push($straighttails, $property);
              }
            }
            if($property->property_id == 35){ //backline
              if($property->value == "Swayback"){
                array_push($swaybacks, $property);
              }
              elseif($property->value == "Straight"){
                array_push($straightbacks, $property);
              }
            }
          }
        }

        // count of sows without records
        $nohairtypes = (count($sows)-(count($curlyhairs)+count($straighthairs)));
        $nohairlengths = (count($sows)-(count($shorthairs)+count($longhairs)));
	      $nocoats = (count($sows)-(count($blackcoats)+count($nonblackcoats)));
	      $nopatterns = (count($sows)-(count($plains)+count($socks)));
	      $noheadshapes = (count($sows)-(count($concaves)+count($straightheads)));
	      $noskintypes = (count($sows)-(count($smooths)+count($wrinkleds)));
	      $noeartypes = (count($sows)-(count($droopingears)+count($semilops)+count($erectears)));
	      $notailtypes = (count($sows)-(count($curlytails)+count($straighttails)));
	      $nobacklines = (count($sows)-(count($swaybacks)+count($straightbacks)));
      }
      elseif($filter == "Boar"){ // data displayed are for all boars
        $curlyhairs = [];
        $straighthairs = [];
        $shorthairs = [];
        $longhairs = [];
        $blackcoats = [];
        $nonblackcoats = [];
        $plains = [];
        $socks = [];
        $concaves = [];
        $straightheads = [];
        $smooths = [];
        $wrinkleds = [];
        $droopingears = [];
        $semilops = [];
        $erectears = [];
        $curlytails = [];
        $straighttails = [];
        $swaybacks = [];
        $straightbacks = [];
        foreach ($boars as $boar) {
          $properties = $boar->getAnimalProperties();
          foreach ($properties as $property) {
            if($property->property_id == 28){ //hairtype
              if($property->value == "Curly"){
                array_push($curlyhairs, $property);
              }
              elseif($property->value == "Straight"){
                array_push($straighthairs, $property);
              }
            }
            if($property->property_id == 29){ //hairlength
              if($property->value == "Short"){
                array_push($shorthairs, $property);
              }
              elseif($property->value == "Long"){
                array_push($longhairs, $property);
              }
            }
            if($property->property_id == 30){ //coatcolor
              if($property->value == "Black"){
                array_push($blackcoats, $property);
              }
              elseif($property->value == "Others"){
                array_push($nonblackcoats, $property);
              }
            }
            if($property->property_id == 31){ //colorpattern
              if($property->value == "Plain"){
                array_push($plains, $property);
              }
              elseif($property->value == "Socks"){
                array_push($socks, $property);
              }
            }
            if($property->property_id == 32){ //headshape
              if($property->value == "Concave"){
                array_push($concaves, $property);
              }
              elseif($property->value == "Straight"){
                array_push($straightheads, $property);
              }
            }
            if($property->property_id == 33){ //skintype
              if($property->value == "Smooth"){
                array_push($smooths, $property);
              }
              elseif($property->value == "Wrinkled"){
                array_push($wrinkleds, $property);
              }
            }
            if($property->property_id == 34){ //eartype
              if($property->value == "Drooping"){
                array_push($droopingears, $property);
              }
              elseif($property->value == "Semi-lop"){
                array_push($semilops, $property);
              }
              elseif($property->value == "Erect"){
                array_push($erectears, $property);
              }
            }
            if($property->property_id == 62){ //tailtype
              if($property->value == "Curly"){
                array_push($curlytails, $property);
              }
              elseif($property->value == "Straight"){
                array_push($straighttails, $property);
              }
            }
            if($property->property_id == 35){ //backline
              if($property->value == "Swayback"){
                array_push($swaybacks, $property);
              }
              elseif($property->value == "Straight"){
                array_push($straightbacks, $property);
              }
            }
          }
        }

        // count of boars without records
        $nohairtypes = (count($boars)-(count($curlyhairs)+count($straighthairs)));
        $nohairlengths = (count($boars)-(count($shorthairs)+count($longhairs)));
	      $nocoats = (count($boars)-(count($blackcoats)+count($nonblackcoats)));
	      $nopatterns = (count($boars)-(count($plains)+count($socks)));
	      $noheadshapes = (count($boars)-(count($concaves)+count($straightheads)));
	      $noskintypes = (count($boars)-(count($smooths)+count($wrinkleds)));
	      $noeartypes = (count($boars)-(count($droopingears)+count($semilops)+count($erectears)));
	      $notailtypes = (count($boars)-(count($curlytails)+count($straighttails)));
	      $nobacklines = (count($boars)-(count($swaybacks)+count($straightbacks)));
      }
      elseif($filter == "All"){ // data displayed are for all pigs in the herd
        $curlyhairs = [];
        $straighthairs = [];
        $shorthairs = [];
        $longhairs = [];
        $blackcoats = [];
        $nonblackcoats = [];
        $plains = [];
        $socks = [];
        $concaves = [];
        $straightheads = [];
        $smooths = [];
        $wrinkleds = [];
        $droopingears = [];
        $semilops = [];
        $erectears = [];
        $curlytails = [];
        $straighttails = [];
        $swaybacks = [];
        $straightbacks = [];
        foreach ($pigs as $pig) {
          $properties = $pig->getAnimalProperties();
          foreach ($properties as $property) {
            if($property->property_id == 28){ //hairtype
              if($property->value == "Curly"){
                array_push($curlyhairs, $property);
              }
              elseif($property->value == "Straight"){
                array_push($straighthairs, $property);
              }
            }
            if($property->property_id == 29){ //hairlength
              if($property->value == "Short"){
                array_push($shorthairs, $property);
              }
              elseif($property->value == "Long"){
                array_push($longhairs, $property);
              }
            }
            if($property->property_id == 30){ //coatcolor
              if($property->value == "Black"){
                array_push($blackcoats, $property);
              }
              elseif($property->value == "Others"){
                array_push($nonblackcoats, $property);
              }
            }
            if($property->property_id == 31){ //colorpattern
              if($property->value == "Plain"){
                array_push($plains, $property);
              }
              elseif($property->value == "Socks"){
                array_push($socks, $property);
              }
            }
            if($property->property_id == 32){ //headshape
              if($property->value == "Concave"){
                array_push($concaves, $property);
              }
              elseif($property->value == "Straight"){
                array_push($straightheads, $property);
              }
            }
            if($property->property_id == 33){ //skintype
              if($property->value == "Smooth"){
                array_push($smooths, $property);
              }
              elseif($property->value == "Wrinkled"){
                array_push($wrinkleds, $property);
              }
            }
            if($property->property_id == 34){ //eartype
              if($property->value == "Drooping"){
                array_push($droopingears, $property);
              }
              elseif($property->value == "Semi-lop"){
                array_push($semilops, $property);
              }
              elseif($property->value == "Erect"){
                array_push($erectears, $property);
              }
            }
            if($property->property_id == 62){ //tailtype
              if($property->value == "Curly"){
                array_push($curlytails, $property);
              }
              elseif($property->value == "Straight"){
                array_push($straighttails, $property);
              }
            }
            if($property->property_id == 35){ //backline
              if($property->value == "Swayback"){
                array_push($swaybacks, $property);
              }
              elseif($property->value == "Straight"){
                array_push($straightbacks, $property);
              }
            }
          }
        }

        // count of pigs without records
        $nohairtypes = (count($pigs)-(count($curlyhairs)+count($straighthairs)));
        $nohairlengths = (count($pigs)-(count($shorthairs)+count($longhairs)));
	      $nocoats = (count($pigs)-(count($blackcoats)+count($nonblackcoats)));
	      $nopatterns = (count($pigs)-(count($plains)+count($socks)));
	      $noheadshapes = (count($pigs)-(count($concaves)+count($straightheads)));
	      $noskintypes = (count($pigs)-(count($smooths)+count($wrinkleds)));
	      $noeartypes = (count($pigs)-(count($droopingears)+count($semilops)+count($erectears)));
	      $notailtypes = (count($pigs)-(count($curlytails)+count($straighttails)));
	      $nobacklines = (count($pigs)-(count($swaybacks)+count($straightbacks)));
      }

      // return Redirect::back()->with('message','Operation Successful!');
      return view('pigs.grossmorphoreport', compact('pigs', 'filter', 'sows', 'boars', 'curlyhairs', 'straighthairs', 'shorthairs', 'longhairs', 'blackcoats', 'nonblackcoats', 'plains', 'socks', 'concaves', 'straightheads', 'smooths', 'wrinkleds', 'droopingears', 'semilops', 'erectears', 'curlytails', 'straighttails', 'swaybacks', 'straightbacks', 'nohairtypes', 'nohairlengths', 'nocoats', 'nopatterns', 'noheadshapes', 'noskintypes', 'noeartypes', 'notailtypes', 'nobacklines', 'years'));
    }

    static function standardDeviation($arr, $samp = false){ // function to compute standard deviation
	    $ave = array_sum($arr) / count($arr);
	    $variance = 0.0;
	    foreach ($arr as $i) {
	      $variance += pow($i - $ave, 2);
	    }
	    $variance /= ( $samp ? count($arr) - 1 : count($arr) );
	    return (float) sqrt($variance);
		}

		public static function getMorphometricCharacteristicsPerYearOfBirth($year, $property_id, $filter){ // function to display Morphometric Characteristics Report per year of birth
    	$pigs = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

    	// gets pigs born on specified year
    	$pigsbornonyear = [];
    	foreach ($pigs as $pig) {
    		if(substr($pig->registryid, -11, 4) == $year){
          array_push($pigsbornonyear, $pig);
        }
    	}

    	// sorts pigs per sex
    	$sows = [];
      $boars = [];
      foreach ($pigs as $pig) {
        if(substr($pig->registryid, -7, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -7, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      // gets pigs born on specified year per sex
      $sowsbornonyear = [];
      $boarsbornonyear = [];
      foreach ($sows as $sow) {
      	if(substr($sow->registryid, -11, 4) == $year){
      		array_push($sowsbornonyear, $sow);
      	}
      }
      foreach ($boars as $boar) {
      	if(substr($boar->registryid, -11, 4) == $year){
      		array_push($boarsbornonyear, $boar);
      	}
      }

    	if($filter == "All"){ // data returned are for all pigs
    		$morphochars = [];
	    	foreach ($pigsbornonyear as $bornpig) {
	    		$properties = $bornpig->getAnimalProperties();
	    		foreach ($properties as $property) {
	    			if($property->property_id == $property_id){
	    				if($property->value != ""){
	    					$morphochar = $property->value;
	    					array_push($morphochars, $morphochar);
	    				}
	    			}
	    		}
	    	}

    		return $morphochars;
    	}
    	elseif($filter == "Sow"){ // data returned are for all sows
    		$morphochars = [];
	    	foreach ($sowsbornonyear as $bornsow) {
	    		$properties = $bornsow->getAnimalProperties();
	    		foreach ($properties as $property) {
	    			if($property->property_id == $property_id){
	    				if($property->value != ""){
	    					$morphochar = $property->value;
	    					array_push($morphochars, $morphochar);
	    				}
	    			}
	    		}
	    	}

    		return $morphochars;
    	}
    	elseif($filter == "Boar"){ // data returned are all boars
    		$morphochars = [];
	    	foreach ($boarsbornonyear as $bornboar) {
	    		$properties = $bornboar->getAnimalProperties();
	    		foreach ($properties as $property) {
	    			if($property->property_id == $property_id){
	    				if($property->value != ""){
	    					$morphochar = $property->value;
	    					array_push($morphochars, $morphochar);
	    				}
	    			}
	    		}
	    	}

    		return $morphochars;
    	}
    }

    public function getMorphometricCharacteristicsReportPage(){ // function to display Morphometric Characteristics Report page
      $pigs = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

      // default filter
      $filter = "All";

      // sorts pigs per sex
      $sows = [];
      $boars = [];
      foreach ($pigs as $pig) {
        if(substr($pig->registryid, -7, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -7, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      // gets unique years of birth
      $years = [];
      $tempyears = [];
      foreach ($pigs as $pig) {
      	$pigproperties = $pig->getAnimalProperties();
      	foreach ($pigproperties as $pigproperty) {
      		if($pigproperty->property_id == 25){
      			if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
      				$year = Carbon::parse($pigproperty->value)->year;
      				array_push($tempyears, $year);
      				$years = array_sort(array_unique($tempyears));
      			}
      		}
      	}
      }

      $earlengths = [];
      $headlengths = [];
      $snoutlengths = [];
      $bodylengths = [];
      $heartgirths = [];
      $pelvicwidths = [];
      $ponderalindices = [];
      $taillengths = [];
      $heightsatwithers = [];
      $normalteats = [];
      foreach ($pigs as $pig) {
        $properties = $pig->getAnimalProperties();
        foreach ($properties as $property) {
          if($property->property_id == 64){ //earlength
          	if($property->value != ""){
	            $earlength = $property->value;
	            array_push($earlengths, $earlength);
	          }
          }
          if($property->property_id == 39){ //headlength
          	if($property->value != ""){
	            $headlength = $property->value;
	            array_push($headlengths, $headlength);
	          }
          }
          if($property->property_id == 63){ //snoutlength
          	if($property->value != ""){
	            $snoutlength = $property->value;
	            array_push($snoutlengths, $snoutlength);
	          }
          }
          if($property->property_id == 40){ //bodylength
          	if($property->value != ""){
	            $bodylength = $property->value;
	            array_push($bodylengths, $bodylength);
	          }
          }
          if($property->property_id == 42){ //heartgirth
          	if($property->value != ""){
	            $heartgirth = $property->value;
	            array_push($heartgirths, $heartgirth);
	          }
          }
          if($property->property_id == 41){ //pelvicwidth
          	if($property->value != ""){
	            $pelvicwidth = $property->value;
	            array_push($pelvicwidths, $pelvicwidth);
	          }
          }
          if($property->property_id == 43){ //ponderalindex
            if($property->value != ""){
              $ponderalindex = $property->value;
              array_push($ponderalindices, $ponderalindex);
            }
          }
          if($property->property_id == 65){ //taillength
          	if($property->value != ""){
	            $taillength = $property->value;
	            array_push($taillengths, $taillength);
	          }
          }
          if($property->property_id == 66){ //heightatwithers
            if($property->value != ""){
              $heightatwithers = $property->value;
              array_push($heightsatwithers, $heightatwithers);
            }
          }
          if($property->property_id == 44){ //numberofnormalteats
            if($property->value != ""){
              $numberofnormalteats = $property->value;
              array_push($normalteats, $numberofnormalteats);
            }
          }
        }
      }

      if($earlengths != []){
      	$earlengths_sd = static::standardDeviation($earlengths, false);
      }
      if($headlengths != []){
      	$headlengths_sd = static::standardDeviation($headlengths, false);
      }
      if($snoutlengths != []){
      	$snoutlengths_sd = static::standardDeviation($snoutlengths, false);
      }
      if($bodylengths != []){
      	$bodylengths_sd = static::standardDeviation($bodylengths, false);
      }
      if($heartgirths != []){
      	$heartgirths_sd = static::standardDeviation($heartgirths, false);
      }
      if($pelvicwidths != []){
      	$pelvicwidths_sd = static::standardDeviation($pelvicwidths, false);
      }
      if($ponderalindices != []){
      	$ponderalindices_sd = static::standardDeviation($ponderalindices, false);
      }
      if($taillengths != []){
      	$taillengths_sd = static::standardDeviation($taillengths, false);
      }
      if($heightsatwithers != []){
      	$heightsatwithers_sd = static::standardDeviation($heightsatwithers, false);
      }
      if($normalteats != []){
      	$normalteats_sd = static::standardDeviation($normalteats, false);
      }

      return view('pigs.morphocharsreport', compact('pigs', 'filter', 'sows', 'boars', 'earlengths', 'headlengths', 'snoutlengths', 'bodylengths', 'heartgirths', 'pelvicwidths', 'ponderalindices', 'taillengths', 'heightsatwithers', 'normalteats', 'earlengths_sd', 'headlengths_sd', 'snoutlengths_sd', 'bodylengths_sd', 'heartgirths_sd', 'pelvicwidths_sd', 'ponderalindices_sd', 'taillengths_sd', 'heightsatwithers_sd', 'normalteats_sd', 'years'));
    }

    public function filterMorphometricCharacteristicsReport(Request $request){ // function to filter Morphometric Characteristics Report
      $pigs = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

      $filter = $request->filter_keywords2;

      // sorts pigs per sex
      $sows = [];
      $boars = [];
      foreach ($pigs as $pig) {
        if(substr($pig->registryid, -7, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -7, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      // gets unique years of birth
      $years = [];
      $tempyears = [];
      foreach ($pigs as $pig) {
      	$pigproperties = $pig->getAnimalProperties();
      	foreach ($pigproperties as $pigproperty) {
      		if($pigproperty->property_id == 25){
      			if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
      				$year = Carbon::parse($pigproperty->value)->year;
      				array_push($tempyears, $year);
      				$years = array_sort(array_unique($tempyears));
      			}
      		}
      	}
      }

      if($filter == "Sow"){ // data displayed are for all sows
        $earlengths = [];
        $headlengths = [];
        $snoutlengths = [];
        $bodylengths = [];
        $heartgirths = [];
        $pelvicwidths = [];
        $ponderalindices = [];
        $taillengths = [];
        $heightsatwithers = [];
        $normalteats = [];
        foreach ($sows as $sow) {
          $properties = $sow->getAnimalProperties();
          foreach ($properties as $property) {
            if($property->property_id == 64){ //earlength
              if($property->value != ""){
                $earlength = $property->value;
                array_push($earlengths, $earlength);
              }
            }
            if($property->property_id == 39){ //headlength
              if($property->value != ""){
                $headlength = $property->value;
                array_push($headlengths, $headlength);
              }
            }
            if($property->property_id == 63){ //snoutlength
              if($property->value != ""){
                $snoutlength = $property->value;
                array_push($snoutlengths, $snoutlength);
              }
            }
            if($property->property_id == 40){ //bodylength
              if($property->value != ""){
                $bodylength = $property->value;
                array_push($bodylengths, $bodylength);
              }
            }
            if($property->property_id == 42){ //heartgirth
              if($property->value != ""){
                $heartgirth = $property->value;
                array_push($heartgirths, $heartgirth);
              }
            }
            if($property->property_id == 41){ //pelvicwidth
              if($property->value != ""){
                $pelvicwidth = $property->value;
                array_push($pelvicwidths, $pelvicwidth);
              }
            }
            if($property->property_id == 43){ //ponderalindex
              if($property->value != ""){
                $ponderalindex = $property->value;
                array_push($ponderalindices, $ponderalindex);
              }
            }
            if($property->property_id == 65){ //taillength
              if($property->value != ""){
                $taillength = $property->value;
                array_push($taillengths, $taillength);
              }
            }
            if($property->property_id == 66){ //heightatwithers
              if($property->value != ""){
                $heightatwithers = $property->value;
                array_push($heightsatwithers, $heightatwithers);
              }
            }
            if($property->property_id == 44){ //numberofnormalteats
              if($property->value != ""){
                $numberofnormalteats = $property->value;
                array_push($normalteats, $numberofnormalteats);
              }
            }
          }
        }

        if($earlengths != []){
	      	$earlengths_sd = static::standardDeviation($earlengths, false);
	      }
	      if($headlengths != []){
	      	$headlengths_sd = static::standardDeviation($headlengths, false);
	      }
	      if($snoutlengths != []){
	      	$snoutlengths_sd = static::standardDeviation($snoutlengths, false);
	      }
	      if($bodylengths != []){
	      	$bodylengths_sd = static::standardDeviation($bodylengths, false);
	      }
	      if($heartgirths != []){
	      	$heartgirths_sd = static::standardDeviation($heartgirths, false);
	      }
	      if($pelvicwidths != []){
	      	$pelvicwidths_sd = static::standardDeviation($pelvicwidths, false);
	      }
	      if($ponderalindices != []){
	      	$ponderalindices_sd = static::standardDeviation($ponderalindices, false);
	      }
	      if($taillengths != []){
	      	$taillengths_sd = static::standardDeviation($taillengths, false);
	      }
	      if($heightsatwithers != []){
	      	$heightsatwithers_sd = static::standardDeviation($heightsatwithers, false);
	      }
	      if($normalteats != []){
	      	$normalteats_sd = static::standardDeviation($normalteats, false);
	      }
      }
      elseif($filter == "Boar"){ // data displayed are for all boars
        $earlengths = [];
        $headlengths = [];
        $snoutlengths = [];
        $bodylengths = [];
        $heartgirths = [];
        $pelvicwidths = [];
        $ponderalindices = [];
        $taillengths = [];
        $heightsatwithers = [];
        $normalteats = [];
        foreach ($boars as $boar) {
          $properties = $boar->getAnimalProperties();
          foreach ($properties as $property) {
            if($property->property_id == 64){ //earlength
              if($property->value != ""){
                $earlength = $property->value;
                array_push($earlengths, $earlength);
              }
            }
            if($property->property_id == 39){ //headlength
              if($property->value != ""){
                $headlength = $property->value;
                array_push($headlengths, $headlength);
              }
            }
            if($property->property_id == 63){ //snoutlength
              if($property->value != ""){
                $snoutlength = $property->value;
                array_push($snoutlengths, $snoutlength);
              }
            }
            if($property->property_id == 40){ //bodylength
              if($property->value != ""){
                $bodylength = $property->value;
                array_push($bodylengths, $bodylength);
              }
            }
            if($property->property_id == 42){ //heartgirth
              if($property->value != ""){
                $heartgirth = $property->value;
                array_push($heartgirths, $heartgirth);
              }
            }
            if($property->property_id == 41){ //pelvicwidth
              if($property->value != ""){
                $pelvicwidth = $property->value;
                array_push($pelvicwidths, $pelvicwidth);
              }
            }
            if($property->property_id == 43){ //ponderalindex
              if($property->value != ""){
                $ponderalindex = $property->value;
                array_push($ponderalindices, $ponderalindex);
              }
            }
            if($property->property_id == 65){ //taillength
              if($property->value != ""){
                $taillength = $property->value;
                array_push($taillengths, $taillength);
              }
            }
            if($property->property_id == 66){ //heightatwithers
              if($property->value != ""){
                $heightatwithers = $property->value;
                array_push($heightsatwithers, $heightatwithers);
              }
            }
            if($property->property_id == 44){ //numberofnormalteats
              if($property->value != ""){
                $numberofnormalteats = $property->value;
                array_push($normalteats, $numberofnormalteats);
              }
            }
          }
        }

        if($earlengths != []){
	      	$earlengths_sd = static::standardDeviation($earlengths, false);
	      }
	      if($headlengths != []){
	      	$headlengths_sd = static::standardDeviation($headlengths, false);
	      }
	      if($snoutlengths != []){
	      	$snoutlengths_sd = static::standardDeviation($snoutlengths, false);
	      }
	      if($bodylengths != []){
	      	$bodylengths_sd = static::standardDeviation($bodylengths, false);
	      }
	      if($heartgirths != []){
	      	$heartgirths_sd = static::standardDeviation($heartgirths, false);
	      }
	      if($pelvicwidths != []){
	      	$pelvicwidths_sd = static::standardDeviation($pelvicwidths, false);
	      }
	      if($ponderalindices != []){
	      	$ponderalindices_sd = static::standardDeviation($ponderalindices, false);
	      }
	      if($taillengths != []){
	      	$taillengths_sd = static::standardDeviation($taillengths, false);
	      }
	      if($heightsatwithers != []){
	      	$heightsatwithers_sd = static::standardDeviation($heightsatwithers, false);
	      }
	      if($normalteats != []){
	      	$normalteats_sd = static::standardDeviation($normalteats, false);
	      }
      }
      elseif($filter == "All"){ // data displayed are for all pigs in the herd
        $earlengths = [];
        $headlengths = [];
        $snoutlengths = [];
        $bodylengths = [];
        $heartgirths = [];
        $pelvicwidths = [];
        $ponderalindices = [];
        $taillengths = [];
        $heightsatwithers = [];
        $normalteats = [];
        foreach ($pigs as $pig) {
          $properties = $pig->getAnimalProperties();
          foreach ($properties as $property) {
            if($property->property_id == 64){ //earlength
              if($property->value != ""){
                $earlength = $property->value;
                array_push($earlengths, $earlength);
              }
            }
            if($property->property_id == 39){ //headlength
              if($property->value != ""){
                $headlength = $property->value;
                array_push($headlengths, $headlength);
              }
            }
            if($property->property_id == 63){ //snoutlength
              if($property->value != ""){
                $snoutlength = $property->value;
                array_push($snoutlengths, $snoutlength);
              }
            }
            if($property->property_id == 40){ //bodylength
              if($property->value != ""){
                $bodylength = $property->value;
                array_push($bodylengths, $bodylength);
              }
            }
            if($property->property_id == 42){ //heartgirth
              if($property->value != ""){
                $heartgirth = $property->value;
                array_push($heartgirths, $heartgirth);
              }
            }
            if($property->property_id == 41){ //pelvicwidth
              if($property->value != ""){
                $pelvicwidth = $property->value;
                array_push($pelvicwidths, $pelvicwidth);
              }
            }
            if($property->property_id == 43){ //ponderalindex
              if($property->value != ""){
                $ponderalindex = $property->value;
                array_push($ponderalindices, $ponderalindex);
              }
            }
            if($property->property_id == 65){ //taillength
              if($property->value != ""){
                $taillength = $property->value;
                array_push($taillengths, $taillength);
              }
            }
            if($property->property_id == 66){ //heightatwithers
              if($property->value != ""){
                $heightatwithers = $property->value;
                array_push($heightsatwithers, $heightatwithers);
              }
            }
            if($property->property_id == 44){ //numberofnormalteats
              if($property->value != ""){
                $numberofnormalteats = $property->value;
                array_push($normalteats, $numberofnormalteats);
              }
            }
          }
        }

        if($earlengths != []){
	      	$earlengths_sd = static::standardDeviation($earlengths, false);
	      }
	      if($headlengths != []){
	      	$headlengths_sd = static::standardDeviation($headlengths, false);
	      }
	      if($snoutlengths != []){
	      	$snoutlengths_sd = static::standardDeviation($snoutlengths, false);
	      }
	      if($bodylengths != []){
	      	$bodylengths_sd = static::standardDeviation($bodylengths, false);
	      }
	      if($heartgirths != []){
	      	$heartgirths_sd = static::standardDeviation($heartgirths, false);
	      }
	      if($pelvicwidths != []){
	      	$pelvicwidths_sd = static::standardDeviation($pelvicwidths, false);
	      }
	      if($ponderalindices != []){
	      	$ponderalindices_sd = static::standardDeviation($ponderalindices, false);
	      }
	      if($taillengths != []){
	      	$taillengths_sd = static::standardDeviation($taillengths, false);
	      }
	      if($heightsatwithers != []){
	      	$heightsatwithers_sd = static::standardDeviation($heightsatwithers, false);
	      }
	      if($normalteats != []){
	      	$normalteats_sd = static::standardDeviation($normalteats, false);
	      }
      }

      return view('pigs.morphocharsreport', compact('pigs', 'filter', 'sows', 'boars', 'earlengths', 'headlengths', 'snoutlengths', 'bodylengths', 'heartgirths', 'pelvicwidths', 'ponderalindices', 'taillengths', 'heightsatwithers', 'normalteats', 'earlengths_sd', 'headlengths_sd', 'snoutlengths_sd', 'bodylengths_sd', 'heartgirths_sd', 'pelvicwidths_sd', 'ponderalindices_sd', 'taillengths_sd', 'heightsatwithers_sd', 'normalteats_sd', 'years'));
    }

    public static function getWeightsPerYearOfBirth($year, $property_id){ // function to get weights per year of birth
    	$pigs = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

    	// gets pigs born on specified year
    	$bornonyear = [];
    	foreach ($pigs as $pig) {
    		if(substr($pig->registryid, -11, 4) == $year){
          array_push($bornonyear, $pig);
        }
    	}

    	// gets weights of pigs born on specified year and property id
    	$weights = [];
    	foreach ($bornonyear as $bornpig) {
    		$properties = $bornpig->getAnimalProperties();
    		foreach ($properties as $property) {
    			if($property->property_id == $property_id){
    				if($property->value != ""){
    					$weight = $property->value;
    					array_push($weights, $weight);
    				}
    			}
    		}
    	}

    	return $weights;
    }

    public function getBreederProductionReportPage(){
    	$pigs = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

    	// weights
    	$weights45d = [];
    	$weights60d = [];
    	$weights90d = [];
    	$weights180d = [];
    	foreach ($pigs as $pig) {
    		$properties = $pig->getAnimalProperties();
    		foreach ($properties as $property) {
    			if($property->property_id == 45){	//45d
    				if($property->value != ""){
    					$weight45d = $property->value;
    					array_push($weights45d, $weight45d);
    				}
    			}
    			if($property->property_id == 46){	//60d
    				if($property->value != ""){
    					$weight60d = $property->value;
    					array_push($weights60d, $weight60d);
    				}
    			}
    			if($property->property_id == 69){	//90d
    				if($property->value != ""){
    					$weight90d = $property->value;
    					array_push($weights90d, $weight90d);
    				}
    			}
    			if($property->property_id == 47){	//180d
    				if($property->value != ""){
    					$weight180d = $property->value;
    					array_push($weights180d, $weight180d);
    				}
    			}
    		}
    	}
			if($weight45d != []){
        $weights45d_sd = static::standardDeviation($weights45d, false);
      }
      if($weights60d != []){
        $weights60d_sd = static::standardDeviation($weights60d, false);
      }
    	if($weights90d != []){
        $weights90d_sd = static::standardDeviation($weights90d, false);
      }
      if($weights180d != []){
        $weights180d_sd = static::standardDeviation($weights180d, false); 
      }

      //year of birth
      $years = [];
      $tempyears = [];
      foreach ($pigs as $pig) {
      	$pigproperties = $pig->getAnimalProperties();
      	foreach ($pigproperties as $pigproperty) {
      		if($pigproperty->property_id == 25){
      			if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
      				$year = Carbon::parse($pigproperty->value)->year;
      				array_push($tempyears, $year);
      				$years = array_sort(array_unique($tempyears));
      			}
      		}
      	}
      }

 			// age at weaning
      $sows = [];
      $boars = [];
      foreach($pigs as $pig){
        if(substr($pig->registryid, -7, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -7, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      // per sow
      $ages_weanedsow = [];
      foreach ($sows as $sow) {
        $sowproperties = $sow->getAnimalProperties();
        foreach ($sowproperties as $sowproperty) {
          if($sowproperty->property_id == 61){ // date weaned
            if(!is_null($sowproperty->value) && $sowproperty->value != "Not specified"){
              $date_weanedsow = $sowproperty->value;
              $weanedsowproperties = $sow->getAnimalProperties();
              foreach ($weanedsowproperties as $weanedsowproperty) {
                if($weanedsowproperty->property_id == 25){ // date farrowed
                  if(!is_null($weanedsowproperty->value) && $weanedsowproperty->value != "Not specified"){
                    $bday_sow = $weanedsowproperty->value;
                  }
                }
              }
              $age_weanedsow = Carbon::parse($date_weanedsow)->diffInDays(Carbon::parse($bday_sow));
              array_push($ages_weanedsow, $age_weanedsow);
            }
          }
        }
      }
      if($ages_weanedsow != []){
        $ages_weanedsow_sd = static::standardDeviation($ages_weanedsow, false);
      }

      // per boar
      $ages_weanedboar = [];
      foreach ($boars as $boar) {
        $boarproperties = $boar->getAnimalProperties();
        foreach ($boarproperties as $boarproperty) {
          if($boarproperty->property_id == 61){ // date weaned
            if(!is_null($boarproperty->value) && $boarproperty->value != "Not specified"){
              $date_weanedboar = $boarproperty->value;
              $weanedboarproperties = $boar->getAnimalProperties();
              foreach ($weanedboarproperties as $weanedboarproperty) {
                if($weanedboarproperty->property_id == 25){ // date farrowed
                  if(!is_null($weanedboarproperty->value) && $weanedboarproperty->value != "Not specified"){
                    $bday_boar = $weanedboarproperty->value;
                  }
                }
              }
              $age_weanedboar = Carbon::parse($date_weanedboar)->diffInDays(Carbon::parse($bday_boar));
              array_push($ages_weanedboar, $age_weanedboar);
            }
          }
        }
      }
      if($ages_weanedboar != []){
        $ages_weanedboar_sd = static::standardDeviation($ages_weanedboar, false);
      }

      // all pigs
      $ages_weanedpig = [];
      foreach ($pigs as $pig) {
        $pigproperties = $pig->getAnimalProperties();
        foreach ($pigproperties as $pigproperty) {
          if($pigproperty->property_id == 61){ // date weaned
            if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
              $date_weanedpig = $pigproperty->value;
              $weanedpigproperties = $pig->getAnimalProperties();
              foreach ($weanedpigproperties as $weanedpigproperty) {
                if($weanedpigproperty->property_id == 25){ // date farrowed
                  if(!is_null($weanedpigproperty->value) && $weanedpigproperty->value != "Not specified"){
                    $bday_pig = $weanedpigproperty->value;
                  }
                }
              }
              $age_weanedpig = Carbon::parse($date_weanedpig)->diffInDays(Carbon::parse($bday_pig));
              array_push($ages_weanedpig, $age_weanedpig);
            }
          }
        }
      }
      if($ages_weanedpig != []){
        $ages_weanedpig_sd = static::standardDeviation($ages_weanedpig, false);
      }

      //age at first breeding
      $groups = Grouping::whereNotNull("mother_id")->get();

      $firstbreds = [];
      $firstbredsows = [];
      $tempfirstbredsows = [];
      $duplicates = [];
      $firstbredboars = [];
      $firstbredsowsages = [];
      $firstbredboarsages = [];
      $firstbredages = [];

      //for sows

      // gets groups with first bred sows
      foreach ($groups as $group) {
      	$groupproperties = $group->getGroupingProperties();
      	foreach ($groupproperties as $groupproperty) {
      		if($groupproperty->property_id == 76){ // parity
      			if($groupproperty->value == 1 || $groupproperty->value == 0){
      				if($group->getMother()->status == "breeder"){
      					array_push($firstbreds, $group);
      				}
      			}
      		}
      	}
      }
      foreach ($firstbreds as $firstbred) { // gets first bred sows
      	$mother = $firstbred->getMother();
      	if($mother->status == "breeder"){
      		array_push($tempfirstbredsows, $mother);
      		$firstbredsows = array_unique($tempfirstbredsows);
      	}
      }
      array_push($duplicates, array_unique(array_diff_assoc($tempfirstbredsows, $firstbredsows))); // gets the animal with duplicates
      foreach ($firstbredsows as $firstbredsow) {
      	foreach ($duplicates as $duplicate) {
      		$duplicate_keys = array_keys($duplicate); // gets the key of the duplicate
      		foreach ($duplicate_keys as $duplicate_key) {
      			$animal = $duplicate[$duplicate_key];
      			if($firstbredsow->id == $animal->id){ // if duplicate is found
      				$groupings = Grouping::where("mother_id", $animal->id)->get();
      				$duplicates_datesbred = [];
      				foreach ($groupings as $grouping) {
      					$groupingproperties = $grouping->getGroupingProperties();
      					foreach ($groupingproperties as $groupingproperty) {
      						if($groupingproperty->property_id == 48){ // date bred
      							if($groupingproperty->value != "Not specified" && !is_null($groupingproperty->value)){
      								array_push($duplicates_datesbred, $groupingproperty->value);
      							}
      						}
      					}
      				}
      				// sorts dates bred to get first date of breeding
      				$sorted_datesbred = array_sort($duplicates_datesbred);
      				$arrkeys = array_keys($sorted_datesbred);
      				$date_bredsow = $sorted_datesbred[$arrkeys[0]];
      				$bredsowproperties = $animal->getAnimalProperties();
      				foreach ($bredsowproperties as $bredsowproperty) {
      					if($bredsowproperty->property_id == 25){ //date farrowed
      						if(!is_null($bredsowproperty->value) && $bredsowproperty->value != "Not specified"){
      							$bday_sow_duplicate = $bredsowproperty->value;
      						}
      					}
      				}
      				$firstbredsowsage = Carbon::parse($date_bredsow)->diffInMonths(Carbon::parse($bday_sow_duplicate));
      				array_push($firstbredsowsages, $firstbredsowsage);
      				$firstbredsows = array_diff($firstbredsows, [$firstbredsow]); // removes duplicates
      			}
      		}
      	}
      }
      foreach ($firstbredsows as $firstbredsow) { // computation for first bred sows' age without duplicates
      	foreach ($firstbreds as $firstbred) {
      		if($firstbred->getMother()->id == $firstbredsow->id){
      			$firstbredfamilyproperties = $firstbred->getGroupingProperties();
      			foreach ($firstbredfamilyproperties as $firstbredfamilyproperty) {
      				if($firstbredfamilyproperty->property_id == 48){ // date bred
      					if($firstbredfamilyproperty->value != "Not specified" && !is_null($firstbredfamilyproperty->value)){
      						$datebred_family = $firstbredfamilyproperty->value;
      						$firstbredsowsproperties = $firstbredsow->getAnimalProperties();
      						foreach ($firstbredsowsproperties as $firstbredsowsproperty) {
      							if($firstbredsowsproperty->property_id == 25){ // date farrowed
      								if(!is_null($firstbredsowsproperty->value) && $firstbredsowsproperty->value != "Not specified"){
      									$bday_firstbredsow = $firstbredsowsproperty->value;
      									$firstbredsowage = Carbon::parse($datebred_family)->diffInMonths(Carbon::parse($bday_firstbredsow));
      									array_push($firstbredsowsages, $firstbredsowage);
      								}
      							}
      						}
      					}
      				}
      			}
      		}
      	}
      }
      if($firstbredsowsages != []){
      	$firstbredsowsages_sd = static::standardDeviation($firstbredsowsages, false);
      }

      //first bred boars
      $tempboars = [];
      $uniqueboars = [];
      foreach ($boars as $boar) {
      	$boarproperties = $boar->getAnimalProperties();
      	foreach ($boarproperties as $boarproperty) {
      		if($boarproperty->property_id == 88){ // frequency
      			if($boarproperty->value == 1){ //for boars used only once
      				array_push($firstbredboars, $boar);
      			}
      			elseif($boarproperty->value > 1){ //other boars
      				foreach ($groups as $group) {
      					if($group->father_id == $boar->id){
      						array_push($tempboars, $boar);
      						$uniqueboars = array_unique($tempboars);
      					}
      				}
      			}
      		}
      	}
      }
      //for boars used only once
      foreach ($firstbredboars as $firstbredboar) {
      	foreach ($groups as $group) {
      		if($group->father_id == $firstbredboar->id){
      			$groupproperties = $group->getGroupingProperties();
      			foreach ($groupproperties as $groupproperty) {
      				if($groupproperty->property_id == 48){ // date bred
      					$date_bred = $groupproperty->value;
      					$bredboarproperties = $firstbredboar->getAnimalProperties();
      					foreach ($bredboarproperties as $bredboarproperty) {
      						if($bredboarproperty->property_id == 25){ // date farrowed
      							if(!is_null($bredboarproperty->value) && $bredboarproperty->value != "Not specified"){
      								$bday_boar = $bredboarproperty->value;
      								$firstbredboarsage = Carbon::parse($date_bred)->diffInMonths(Carbon::parse($bday_boar));
      								array_push($firstbredboarsages, $firstbredboarsage);
      							}
      						}
      					}
      				}
      			}
      		}
      	}
      }
      //other boars
      foreach ($uniqueboars as $uniqueboar) {
      	$dates_bred = [];
      	foreach ($groups as $group) {
      		if($group->father_id == $uniqueboar->id){
      			$groupproperties = $group->getGroupingProperties();
      			foreach ($groupproperties as $groupproperty) {
      				if($groupproperty->property_id == 48){ // date bred
      					$date_bred = $groupproperty->value;
      					array_push($dates_bred, $date_bred);
      				}
      			}
      			// gets the first date of breeding
      			$sorted_dates = array_sort($dates_bred);
      			$keys = array_keys($sorted_dates);
      			$date_bredboar = $sorted_dates[$keys[0]];
      			$bredboarproperties = $uniqueboar->getAnimalProperties();
      			foreach ($bredboarproperties as $bredboarproperty) {
      				if($bredboarproperty->property_id == 25){ // date farrowed
      					if(!is_null($bredboarproperty->value) && $bredboarproperty->value != "Not specified"){
      						$bday_boar = $bredboarproperty->value;
      					}
      				}
      			}
      		}
      	}
      	// age computation
      	$firstbredboarsage = Carbon::parse($date_bredboar)->diffInMonths(Carbon::parse($bday_boar));
      	array_push($firstbredboarsages, $firstbredboarsage);
      }
      if($firstbredboarsages != []){
      	$firstbredboarsages_sd = static::standardDeviation($firstbredboarsages, false);
      }

      // for all pigs
      $firstbredages = array_merge($firstbredsowsages, $firstbredboarsages);
      if($firstbredages != []){
      	$firstbredages_sd = static::standardDeviation($firstbredages, false);
      }
      
      //age of breeding herd
      // age of all breeders
      $breederages = [];
      $breeders = [];
      foreach ($pigs as $pig) {
        $genproperties = $pig->getAnimalProperties();
        foreach ($genproperties as $genproperty) {
          if($genproperty->property_id == 88){ // frequency
            if($genproperty->value > 0){ // used at least once
              array_push($breeders, $pig);
              $bredpigproperties = $pig->getAnimalProperties();
              foreach ($bredpigproperties as $bredpigproperty) {
                if($bredpigproperty->property_id == 25){ // date farrowed
                  if(!is_null($bredpigproperty->value) && $bredpigproperty->value != "Not specified"){
                    $bday_pig = $bredpigproperty->value;
                    $now = new Carbon();
                    $breederage = $now->diffInMonths(Carbon::parse($bday_pig));
                    array_push($breederages, $breederage);
                  }
                }
              }
            }
          }
        }
      }

      // age of sows
      $breedersowages = [];
      $breedersows = [];
      foreach ($sows as $sow) {
      	$sowproperties = $sow->getAnimalProperties();
      	foreach ($sowproperties as $sowproperty) {
      		if($sowproperty->property_id == 88){ // frequency
      			if($sowproperty->value > 0){ // used at least once
      				array_push($breedersows, $sow);
      				$bredsowproperties = $sow->getAnimalProperties();
      				foreach ($bredsowproperties as $bredsowproperty) {
      					if($bredsowproperty->property_id == 25){ // date farrowed
      						if(!is_null($bredsowproperty->value) && $bredsowproperty->value != "Not specified"){
      							$bday_sow = $bredsowproperty->value;
      							$now = new Carbon();
      							$breedersowage = $now->diffInMonths(Carbon::parse($bday_sow));
      							array_push($breedersowages, $breedersowage);
      						}
      					}
      				}
      			}
      		}
      	}
      }

      //age of boars
      $breederboarages = [];
      $breederboars = [];
      foreach ($boars as $boar) {
      	$boarproperties = $boar->getAnimalProperties();
      	foreach ($boarproperties as $boarproperty) {
      		if($boarproperty->property_id == 88){ // frequency
      			if($boarproperty->value > 0){ // used at least once
      				array_push($breederboars, $boar);
      				$bredboarproperties = $boar->getAnimalProperties();
      				foreach ($bredboarproperties as $bredboarproperty) {
      					if($bredboarproperty->property_id == 25){ // date farrowed
      						if(!is_null($bredboarproperty->value) && $bredboarproperty->value != "Not specified"){
      							$bday_boar = $bredboarproperty->value;
      							$now = new Carbon();
      							$breederboarage = $now->diffInMonths(Carbon::parse($bday_boar));
      							array_push($breederboarages, $breederboarage);
      						}
      					}
      				}
      			}
      		}
      	}
      }

    	return view('pigs.breederproduction', compact('pigs', 'sows', 'boars', 'weights45d', 'weights60d', 'weights90d', 'weights180d', 'weights45d_sd', 'weights60d_sd', 'weights90d_sd', 'weights180d_sd', 'ages_weanedsow', 'ages_weanedsow_sd', 'ages_weanedboar', 'ages_weanedboar_sd', 'ages_weanedpig', 'ages_weanedpig_sd', 'breederages', 'breeders', 'breedersowages', 'breedersows', 'breederboarages', 'breederboars', 'firstbreds', 'firstbredsows', 'firstbredsowsages', 'firstbredsowsages_sd', 'duplicates', 'firstbredboars', 'uniqueboars', 'firstbredboarsages', 'firstbredboarsages_sd', 'firstbredages', 'firstbredages_sd', 'years'));
    }

    public function getProductionPerformancePage(){ // function to display Production Performace page
    	$pigs = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

    	// sorts pigs by sex
    	$sows = [];
    	$boars = [];
    	foreach($pigs as $pig){
        if(substr($pig->registryid, -7, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -7, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      // sow breeders are sows with parity of at least 1
      $sowbreeders = [];
      $boarbreeders = [];
      foreach ($sows as $sow) {
        $sowproperties = $sow->getAnimalProperties();
        foreach ($sowproperties as $sowproperty) {
          if($sowproperty->property_id == 76){ // parity
            if($sowproperty->value > 0){
              array_push($sowbreeders, $sow);
            }
          }
        }
      }
      // boar breeders are boars used at least once
      foreach ($boars as $boar) {
        $boarproperties = $boar->getAnimalProperties();
        foreach ($boarproperties as $boarproperty) {
          if($boarproperty->property_id == 88){ // frequency
            if($boarproperty->value > 0){
              array_push($boarbreeders, $boar);
            }
          }
        }
      }

      //gets all groups
      $groups = Grouping::whereNotNull("mother_id")->get();

      // gets unique parity
      $parity = [];
      $tempparity = [];
      foreach ($groups as $group) {
        $groupproperties = $group->getGroupingProperties();
        foreach ($groupproperties as $groupproperty) {
          if($groupproperty->property_id == 76){
            if($groupproperty->value > 0){
              $parityvalue = $groupproperty->value;
              array_push($tempparity, $parityvalue);
              $parity = array_sort(array_unique($tempparity));
            }
          }
        }
      }

    	return view('pigs.productionperformance', compact('pigs', 'sows', 'boars', 'sowbreeders', 'boarbreeders', 'parity'));
    }

    public function getSowProductionPerformancePage($id){ // function to display Sow Production Performance page
      $sow = Animal::find($id);

      $properties = $sow->getAnimalProperties();

      $groups = Grouping::where("mother_id", $sow->id)->get();

      $stillborn = [];
      $mummified = [];
      $parity = [];
      foreach ($groups as $group) {
        $groupproperties = $group->getGroupingProperties();
        foreach ($groupproperties as $groupproperty) {
          if($groupproperty->property_id == 74){
            array_push($stillborn, $groupproperty->value);
          }
          if($groupproperty->property_id == 75){
            array_push($mummified, $groupproperty->value);
          }
          if($groupproperty->property_id == 76){
            array_push($parity, $groupproperty->value);
          }
        }
      }

      $totalmales = [];
      $totalfemales = [];
      $totallitterbirthweights = [];
      $avelitterbirthweights = [];
      $totallitterweaningweights = [];
      $avelitterweaningweights = [];
      $aveadjweaningweights = [];
      $totalagesweaned = [];
      $totalweaned = [];
      $preweaningmortality = [];
      $lsba = [];
      foreach ($parity as $par) {
        foreach ($groups as $group) {
          $offsprings = [];
          $gproperties = $group->getGroupingProperties();
          foreach ($gproperties as $gproperty) {
            if($gproperty->property_id == 76){
              if($gproperty->value == $par){
                $males = [];
                $females = [];
                $litterbirthweights = [];
                $litterweaningweights = [];
                $agesweaned = [];
                $adjweaningweightsat45d = [];
                $offsprings = $group->getGroupingMembers();
                foreach ($offsprings as $offspring) {
                  $offpsringproperties = $offspring->getAnimalProperties();
                  foreach ($offpsringproperties as $offpsringproperty) {
                    if($offpsringproperty->property_id == 27){
                      if($offpsringproperty->value == 'M'){
                        array_push($males, $offspring);
                      }
                      elseif($offpsringproperty->value == 'F'){
                        array_push($females, $offspring);
                      }
                    }
                    if($offpsringproperty->property_id == 53){
                      if(!is_null($offpsringproperty->value) && $offpsringproperty->value != ""){
                        array_push($litterbirthweights, $offpsringproperty->value);
                      }
                    }
                    if($offpsringproperty->property_id == 54){
                      if(!is_null($offpsringproperty->value) && $offpsringproperty->value != ""){
                        array_push($litterweaningweights, $offpsringproperty->value);
                      }
                    }
                    if($offpsringproperty->property_id == 61){
                      if(!is_null($offpsringproperty->value) && $offpsringproperty->value != "Not specified"){
                        $date_weaned = $offpsringproperty->value;
                        $weanedoffspringproperties = $offspring->getAnimalProperties();
                        foreach ($weanedoffspringproperties as $weanedoffspringproperty) {
                          if($weanedoffspringproperty->property_id == 25){
                            if(!is_null($weanedoffspringproperty->value) && $weanedoffspringproperty->value != "Not specified"){
                              $bday_offspring = $weanedoffspringproperty->value;
                              $ageweaned = Carbon::parse($date_weaned)->diffInMonths(Carbon::parse($bday_offspring));
                              array_push($agesweaned, $ageweaned);
                            }
                          }
                          if($weanedoffspringproperty->property_id == 54){
                            if(!is_null($weanedoffspringproperty->value) && $weanedoffspringproperty->value != ""){
                              $weaningweight = $weanedoffspringproperty->value;
                              $weanedoffspringproperties2 = $offspring->getAnimalProperties();
                              foreach ($weanedoffspringproperties2 as $weanedoffspringproperty2) {
			                          if($weanedoffspringproperty2->property_id == 25){
			                            if(!is_null($weanedoffspringproperty2->value) && $weanedoffspringproperty2->value != "Not specified"){
			                              $bday_offspring2 = $weanedoffspringproperty2->value;
			                              $ageweaned2 = Carbon::parse($date_weaned)->diffInDays(Carbon::parse($bday_offspring2));
			                 							$adjweaningweightat45d = ($weaningweight*45)/$ageweaned2;
                              			array_push($adjweaningweightsat45d, $adjweaningweightat45d);
			                            }
			                          }
			                        }
                            }
                          }
                        }
                      }
                    }
                  }
                }
                array_push($totalmales, count($males));
                array_push($totalfemales, count($females));
                array_push($lsba, (count($males)+count($females)));
                if(count($litterweaningweights) != 0){
                  array_push($preweaningmortality, ((count($males)+count($females))-((count($males)+count($females))-count($litterweaningweights))));
                }
                if($litterbirthweights != []){
                  array_push($totallitterbirthweights, array_sum($litterbirthweights));
                  array_push($avelitterbirthweights, (array_sum($litterbirthweights)/count($litterbirthweights)));
                }
                if($litterweaningweights != []){
                  array_push($totallitterweaningweights, array_sum($litterweaningweights));
                  array_push($avelitterweaningweights, (array_sum($litterweaningweights)/count($litterweaningweights)));
                  array_push($totalweaned, count($litterweaningweights));
                }
                if($adjweaningweightsat45d != []){
                  array_push($aveadjweaningweights, (array_sum($adjweaningweightsat45d)/count($adjweaningweightsat45d)));
                }
                if($agesweaned != []){
                  array_push($totalagesweaned, array_sum($agesweaned));
                }
              }
            }
          }
        }
      }

			if($stillborn !=[]){
				$stillborn_sd = static::standardDeviation($stillborn, false);
			}
			if($mummified != []){
				$mummified_sd = static::standardDeviation($mummified, false);
			}
			if($totalmales != []){
				$totalmales_sd = static::standardDeviation($totalmales, false);
			}
			if($totalfemales != []){
				$totalfemales_sd = static::standardDeviation($totalfemales, false);
			}
			if($totallitterbirthweights != []){
				$totallitterbirthweights_sd = static::standardDeviation($totallitterbirthweights, false);
			}
			if($avelitterbirthweights != []){
				$avelitterbirthweights_sd = static::standardDeviation($avelitterbirthweights, false);
			}
			if($totallitterweaningweights != []){
				$totallitterweaningweights_sd = static::standardDeviation($totallitterweaningweights, false);
			}
			if($avelitterweaningweights != []){
				$avelitterweaningweights_sd = static::standardDeviation($avelitterweaningweights, false);
			}
			if($aveadjweaningweights != []){
				$aveadjweaningweights_sd = static::standardDeviation($aveadjweaningweights, false);
			}
			if($totalagesweaned != []){
				$totalagesweaned_sd = static::standardDeviation($totalagesweaned, false);
			}
			if($totalweaned != []){
				$totalweaned_sd = static::standardDeviation($totalweaned, false);
			}
			if($preweaningmortality != []){
				$preweaningmortality_sd = static::standardDeviation($preweaningmortality, false);
			}
			if($lsba != []){
				$lsba_sd = static::standardDeviation($lsba, false);
			}

      return view('pigs.sowproductionperformance', compact('sow', 'properties', 'stillborn', 'mummified', 'totalmales', 'totalfemales', 'totallitterbirthweights', 'avelitterbirthweights', 'totallitterweaningweights', 'avelitterweaningweights', 'totalagesweaned', 'aveadjweaningweights', 'totalweaned', 'preweaningmortality', 'lsba', 'stillborn_sd', 'mummified_sd', 'totalmales_sd', 'totalfemales_sd', 'totallitterbirthweights_sd', 'avelitterbirthweights_sd', 'totallitterweaningweights_sd', 'avelitterweaningweights_sd', 'aveadjweaningweights_sd', 'totalagesweaned_sd', 'totalweaned_sd', 'preweaningmortality_sd', 'lsba_sd'));
    }

    public function getBoarProductionPerformancePage($id){
      $boar = Animal::find($id);

      $properties = $boar->getAnimalProperties();

      $groups = Grouping::where("father_id", $boar->id)->get();

      $stillborn = [];
      $mummified = [];
      $parity = [];
      foreach ($groups as $group) {
        $groupproperties = $group->getGroupingProperties();
        foreach ($groupproperties as $groupproperty) {
          if($groupproperty->property_id == 74){
            array_push($stillborn, $groupproperty->value);
          }
          if($groupproperty->property_id == 75){
            array_push($mummified, $groupproperty->value);
          }
          if($groupproperty->property_id == 76){
            array_push($parity, $groupproperty->value);
          }
        }
      }

      $totalmales = [];
      $totalfemales = [];
      $totallitterbirthweights = [];
      $avelitterbirthweights = [];
      $totallitterweaningweights = [];
      $avelitterweaningweights = [];
      $aveadjweaningweights = [];
      $totalagesweaned = [];
      $totalweaned = [];
      $preweaningmortality = [];
      $lsba = [];
      foreach ($parity as $par) {
        foreach ($groups as $group) {
          $offsprings = [];
          $gproperties = $group->getGroupingProperties();
          foreach ($gproperties as $gproperty) {
            if($gproperty->property_id == 76){
              if($gproperty->value == $par){
                $males = [];
                $females = [];
                $litterbirthweights = [];
                $litterweaningweights = [];
                $agesweaned = [];
                $adjweaningweightsat45d = [];
                $offsprings = $group->getGroupingMembers();
                foreach ($offsprings as $offspring) {
                  $offpsringproperties = $offspring->getAnimalProperties();
                  foreach ($offpsringproperties as $offpsringproperty) {
                    if($offpsringproperty->property_id == 27){
                      if($offpsringproperty->value == 'M'){
                        array_push($males, $offspring);
                      }
                      elseif($offpsringproperty->value == 'F'){
                        array_push($females, $offspring);
                      }
                    }
                    if($offpsringproperty->property_id == 53){
                      if(!is_null($offpsringproperty->value) && $offpsringproperty->value != ""){
                        array_push($litterbirthweights, $offpsringproperty->value);
                      }
                    }
                    if($offpsringproperty->property_id == 54){
                      if(!is_null($offpsringproperty->value) && $offpsringproperty->value != ""){
                        array_push($litterweaningweights, $offpsringproperty->value);
                      }
                    }
                    if($offpsringproperty->property_id == 61){
                      if(!is_null($offpsringproperty->value) && $offpsringproperty->value != "Not specified"){
                        $date_weaned = $offpsringproperty->value;
                        $weanedoffspringproperties = $offspring->getAnimalProperties();
                        foreach ($weanedoffspringproperties as $weanedoffspringproperty) {
                          if($weanedoffspringproperty->property_id == 25){
                            if(!is_null($weanedoffspringproperty->value) && $weanedoffspringproperty->value != "Not specified"){
                              $bday_offspring = $weanedoffspringproperty->value;
                              $ageweaned = Carbon::parse($date_weaned)->diffInMonths(Carbon::parse($bday_offspring));
                              array_push($agesweaned, $ageweaned);
                            }
                          }
                          if($weanedoffspringproperty->property_id == 54){
                            if(!is_null($weanedoffspringproperty->value) && $weanedoffspringproperty->value != ""){
                              $weaningweight = $weanedoffspringproperty->value;
                              $weanedoffspringproperties2 = $offspring->getAnimalProperties();
                              foreach ($weanedoffspringproperties2 as $weanedoffspringproperty2) {
			                          if($weanedoffspringproperty2->property_id == 25){
			                            if(!is_null($weanedoffspringproperty2->value) && $weanedoffspringproperty2->value != "Not specified"){
			                              $bday_offspring2 = $weanedoffspringproperty2->value;
			                              $ageweaned2 = Carbon::parse($date_weaned)->diffInDays(Carbon::parse($bday_offspring2));
			                 							$adjweaningweightat45d = ($weaningweight*45)/$ageweaned2;
                              			array_push($adjweaningweightsat45d, $adjweaningweightat45d);
			                            }
			                          }
			                        }
                            }
                          }
                        }
                      }
                    }
                  }
                }
                array_push($totalmales, count($males));
                array_push($totalfemales, count($females));
                array_push($lsba, (count($males)+count($females)));
                if(count($litterweaningweights) != 0){
                  array_push($preweaningmortality, ((count($males)+count($females))-((count($males)+count($females))-count($litterweaningweights))));
                }
                if($litterbirthweights != []){
                  array_push($totallitterbirthweights, array_sum($litterbirthweights));
                  array_push($avelitterbirthweights, (array_sum($litterbirthweights)/count($litterbirthweights)));
                }
                if($litterweaningweights != []){
                  array_push($totallitterweaningweights, array_sum($litterweaningweights));
                  array_push($avelitterweaningweights, (array_sum($litterweaningweights)/count($litterweaningweights)));
                  array_push($totalweaned, $count($litterweaningweights));
                }
                if($adjweaningweightsat45d != []){
                  array_push($aveadjweaningweights, (array_sum($adjweaningweightsat45d)/count($adjweaningweightsat45d)));
                }
                if($agesweaned != []){
                  array_push($totalagesweaned, array_sum($agesweaned));
                }
              }
            }
          }
        }
      }

      if($stillborn !=[]){
				$stillborn_sd = static::standardDeviation($stillborn, false);
			}
			if($mummified != []){
				$mummified_sd = static::standardDeviation($mummified, false);
			}
			if($totalmales != []){
				$totalmales_sd = static::standardDeviation($totalmales, false);
			}
			if($totalfemales != []){
				$totalfemales_sd = static::standardDeviation($totalfemales, false);
			}
			if($totallitterbirthweights != []){
				$totallitterbirthweights_sd = static::standardDeviation($totallitterbirthweights, false);
			}
			if($avelitterbirthweights != []){
				$avelitterbirthweights_sd = static::standardDeviation($avelitterbirthweights, false);
			}
			if($totallitterweaningweights != []){
				$totallitterweaningweights_sd = static::standardDeviation($totallitterweaningweights, false);
			}
			if($avelitterweaningweights != []){
				$avelitterweaningweights_sd = static::standardDeviation($avelitterweaningweights, false);
			}
			if($aveadjweaningweights != []){
				$aveadjweaningweights_sd = static::standardDeviation($aveadjweaningweights, false);
			}
			if($totalagesweaned != []){
				$totalagesweaned_sd = static::standardDeviation($totalagesweaned, false);
			}
			if($totalweaned != []){
				$totalweaned_sd = static::standardDeviation($totalweaned, false);
			}
			if($preweaningmortality != []){
				$preweaningmortality_sd = static::standardDeviation($preweaningmortality, false);
			}
			if($lsba != []){
				$lsba_sd = static::standardDeviation($lsba, false);
			}

      return view('pigs.boarproductionperformance', compact('boar', 'properties', 'stillborn', 'mummified', 'totalmales', 'totalfemales', 'totallitterbirthweights', 'avelitterbirthweights', 'totallitterweaningweights', 'avelitterweaningweights', 'totalagesweaned', 'aveadjweaningweights', 'totalweaned', 'preweaningmortality', 'lsba', 'stillborn_sd', 'mummified_sd', 'totalmales_sd', 'totalfemales_sd', 'totallitterbirthweights_sd', 'avelitterbirthweights_sd', 'totallitterweaningweights_sd', 'avelitterweaningweights_sd', 'aveadjweaningweights_sd', 'totalagesweaned_sd', 'totalweaned_sd', 'preweaningmortality_sd', 'lsba_sd'));
    }

    public function getBreederInventoryPage(){
    	$pigs = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

    	$sows = [];
    	$boars = [];
    	foreach($pigs as $pig){
        if(substr($pig->registryid, -7, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -7, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      $groups = Grouping::whereNotNull("mother_id")->get();

      // boars
      foreach ($boars as $boar) {
        $frequencies = [];
        $frequency = 0;
        $freqproperty = $boar->getAnimalProperties()->where("property_id", 88)->first();

        foreach ($groups as $group) {
          if($boar->registryid == $group->getFather()->registryid){
            $frequency = $frequency+1;
            array_push($frequencies, $frequency);
          }
          $frequency = 0;
        }

        if(is_null($freqproperty)){
          $freqprop = new AnimalProperty;
          $freqprop->animal_id = $boar->id;
          $freqprop->property_id = 88;
          $freqprop->value = array_sum($frequencies);
          $freqprop->save();
        }
        else{
          $freqproperty->value = array_sum($frequencies);
          $freqproperty->save();
        }
      }

      $jrboars = [];
      $bredboars = [];
      foreach ($boars as $boar) {
        $iproperties = $boar->getAnimalProperties();
        foreach ($iproperties as $iproperty) {
          if($iproperty->property_id == 88){
            if($iproperty->value == 0){
              array_push($jrboars, $boar);
            }
            elseif($iproperty->value > 0){
              array_push($bredboars, $boar);
            }
          }
        }
      }

      // sows
      $pregnantsows = [];
      $temppregnant = [];
      foreach ($groups as $group) {
        $gproperties = $group->getGroupingProperties();
        foreach ($gproperties as $gproperty) {
          if($gproperty->property_id == 50){
            if($gproperty->value == "Pregnant"){
              $pregnant = $group->getMother()->registryid;
              array_push($temppregnant, $pregnant);
              $pregnantsows = array_unique($temppregnant);
            }
          }
        }
      }

      foreach ($sows as $sow) {
        $sowfrequencies = [];
        $sowfrequency = 0;
        $sowfreqproperty = $sow->getAnimalProperties()->where("property_id", 88)->first();

        foreach ($groups as $group) {
          if($sow->registryid == $group->getMother()->registryid){
            $sowfrequency = $sowfrequency+1;
            array_push($sowfrequencies, $sowfrequency);
          }
          $sowfrequency = 0;
        }

        if(is_null($sowfreqproperty)){
          $sowfreqprop = new AnimalProperty;
          $sowfreqprop->animal_id = $sow->id;
          $sowfreqprop->property_id = 88;
          $sowfreqprop->value = array_sum($sowfrequencies);
          $sowfreqprop->save();
        }
        else{
          $sowfreqproperty->value = array_sum($sowfrequencies);
          $sowfreqproperty->save();
        }
      }

      $gilts = [];
      $bredsows = [];
      foreach ($sows as $sow) {
        $iproperties = $sow->getAnimalProperties();
        foreach ($iproperties as $iproperty) {
          if($iproperty->property_id == 88){
            if($iproperty->value == 0){
              array_push($gilts, $sow);
            }
            elseif($iproperty->value > 0){
              array_push($bredsows, $sow);
            }
          }
        }
      }

      $drysows = [];
      $temprecycled = [];
      $tempdateweaned = [];
      $dryrecycled = [];
      $drydateweaned = [];
      foreach ($bredsows as $bredsow) {
      	$groups = Grouping::where("mother_id", $bredsow->id)->get();
      	foreach ($groups as $group) {
      		if($group->mother_id == $bredsow->id){
      			$groupproperties = $group->getGroupingProperties();
      			foreach ($groupproperties as $groupproperty) {
      				if($groupproperty->property_id == 50){
      					if($groupproperty->value == "Recycled"){
      						array_push($temprecycled, $bredsow);
      						$dryrecycled = array_unique($temprecycled);
      					}
      				}
      				if($groupproperty->property_id == 50){
      					if($groupproperty->value == "Farrowed"){
      						$farrowedproperties = $group->getGroupingProperties();
      						foreach ($farrowedproperties as $farrowedproperty) {
      							if($farrowedproperty->property_id == 61){
			      					if($farrowedproperty->value != "" || !is_null($farrowedproperty->value)){
			      						array_push($tempdateweaned, $bredsow);
			      						$drydateweaned = array_unique($tempdateweaned);
			      					}
			      				}
      						}
      					}
      				}
      			}
      		}
      	}
      }
      $drysows = array_unique(array_merge($dryrecycled, $drydateweaned));

      $lactating = [];
      foreach ($bredsows as $bredsow) {
      	$families = Grouping::whereNotNull("mother_id")->get();
      	foreach ($families as $family) {
      		if($family->mother_id == $bredsow->id){
      			$familyproperties = $family->getGroupingProperties();
      			foreach ($familyproperties as $familyproperty) {
      				if($familyproperty->property_id == 50){
      					if($familyproperty->value == "Farrowed"){
      						if(is_null($family->getGroupingProperties()->where("property_id", 61)->first())){
      							array_push($lactating, $bredsow);
      						}
      					}
      				}
      			}
      		}
      	}
      }


    	return view('pigs.breederinventory', compact('pigs', 'sows', 'boars', 'groups', 'frequency', 'pregnantsows', 'lactating', 'drysows', 'gilts', 'bredsows', 'jrboars', 'bredboars'));
    }

    public function getSowUsagePage($id){
      $sow = Animal::find($id);

      $groups = Grouping::whereNotNull("mother_id")->where("mother_id", $sow->id)->get();

      return view('pigs.sowusage', compact('sow', 'groups'));
    }

    public function getBoarUsagePage($id){
      $boar = Animal::find($id);

      $groups = Grouping::whereNotNull("mother_id")->where("father_id", $boar->id)->get();

      return view('pigs.boarusage', compact('boar', 'groups'));
    }

    public function getGrowerInventoryPage(){
      $pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

      $sows = [];
      $boars = [];
      foreach($pigs as $pig){
        if(substr($pig->registryid, -7, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -7, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

      $index = 0;

      $years = [];
      $tempyears = [];
      foreach ($pigs as $pig) {
        $pigproperties = $pig->getAnimalProperties();
        foreach ($pigproperties as $pigproperty) {
          if($pigproperty->property_id == 25){
            if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
              $year = Carbon::parse($pigproperty->value)->year;
              array_push($tempyears, $year);
              $years = array_sort(array_unique($tempyears));
            }
          }
        }
      }

      // AGES 0 TO 6 MONTHS LANG ANG ANDITO, PAG WALANG DATA, EDI WALA

    	return view('pigs.growerinventory', compact('pigs', 'sows', 'boars', 'months', 'index', 'years'));
    }

    public function getMortalityAndSalesReportPage(){
    	$dead_growers = Animal::where("animaltype_id", 3)->where("status", "dead grower")->get();
    	$dead_breeders = Animal::where("animaltype_id", 3)->where("status", "dead breeder")->get();
    	$sold_growers = Animal::where("animaltype_id", 3)->where("status", "sold grower")->get();
    	$sold_breeders = Animal::where("animaltype_id", 3)->where("status", "sold breeder")->get();
    	$removed = Animal::where("animaltype_id", 3)->where("status", "removed")->get();

    	$ages_dead = [];
    	$ages_sold_grower = [];
    	$ages_sold_breeder = [];
    	$weights_sold_grower = [];
    	$weights_sold_breeder = [];

    	foreach ($dead_growers as $dead_grower) {
    		$properties = $dead_grower->getAnimalProperties();
    		foreach ($properties as $property) {
    			if($property->property_id == 25){
    				if($property->value != "Not specified"){
    					$bday_dead_grower = $property->value;
    					$deadgrowerpropperties = $dead_grower->getAnimalProperties();
    					foreach ($deadgrowerpropperties as $deadgrowerpropperty) {
    						if($deadgrowerpropperty->property_id == 55){
    							$date_died_grower = $deadgrowerpropperty->value;
    						}
    					}
    					$age_dead_grower = Carbon::parse($date_died_grower)->diffInMonths(Carbon::parse($bday_dead_grower));
    					array_push($ages_dead, $age_dead_grower);
    				}
    			}
    		}
    	}

    	foreach ($dead_breeders as $dead_breeder) {
    		$deadproperties = $dead_breeder->getAnimalProperties();
    		foreach ($deadproperties as $deadproperty) {
    			if($deadproperty->property_id == 25){
    				if($deadproperty->value != "Not specified"){
    					$bday_dead_breeder = $deadproperty->value;
    					$deadbreederpropperties = $dead_breeder->getAnimalProperties();
    					foreach ($deadbreederpropperties as $deadbreederpropperty) {
    						if($deadbreederpropperty->property_id == 55){
    							$date_died_breeder = $deadbreederpropperty->value;
    						}
    					}
    					$age_dead_breeder = Carbon::parse($date_died_breeder)->diffInMonths(Carbon::parse($bday_dead_breeder));
    					array_push($ages_dead, $age_dead_breeder);
    				}
    			}
    		}
    	}

    	foreach ($sold_growers as $sold_grower) {
    		$growerproperties = $sold_grower->getAnimalProperties();
    		foreach ($growerproperties as $growerproperty) {
    			if($growerproperty->property_id == 25){
    				if($growerproperty->value != "Not specified"){
    					$bday_sold_grower = $growerproperty->value;
    					$soldgrowerpropperties = $sold_grower->getAnimalProperties();
    					foreach ($soldgrowerpropperties as $soldgrowerpropperty) {
    						if($soldgrowerpropperty->property_id == 56){
    							$date_sold = $soldgrowerpropperty->value;
    						}
    					}
    					$age_sold_grower = Carbon::parse($date_sold)->diffInMonths(Carbon::parse($bday_sold_grower));
    					array_push($ages_sold_grower, $age_sold_grower);
    				}
    			}
    		}
    	}

    	foreach ($sold_breeders as $sold_breeder) {
    		$breederproperties = $sold_breeder->getAnimalProperties();
    		foreach ($breederproperties as $breederproperty) {
    			if($breederproperty->property_id == 25){
    				if($breederproperty->value != "Not specified"){
    					$bday_sold_breeder = $breederproperty->value;
    					$soldbreederpropperties = $sold_breeder->getAnimalProperties();
    					foreach ($soldbreederpropperties as $soldbreederpropperty) {
    						if($soldbreederpropperty->property_id == 56){
    							$date_sold = $soldbreederpropperty->value;
    						}
    					}
    					$age_sold_breeder = Carbon::parse($date_sold)->diffInMonths(Carbon::parse($bday_sold_breeder));
    					array_push($ages_sold_breeder, $age_sold_breeder);
    				}
    			}
    		}
    	}

    	foreach ($sold_growers as $sold_grower) {
    		$grower_properties = $sold_grower->getAnimalProperties();
    		foreach ($grower_properties as $grower_property) {
    			if($grower_property->property_id == 57){
    				if($grower_property->value != ""){
    					$weight_sold_grower = $grower_property->value;
    					array_push($weights_sold_grower, $weight_sold_grower);
    				}
    			}
    		}
    	}

    	foreach ($sold_breeders as $sold_breeder) {
    		$breeder_properties = $sold_breeder->getAnimalProperties();
    		foreach ($breeder_properties as $breeder_property) {
    			if($breeder_property->property_id == 57){
    				if($breeder_property->value != ""){
    					$weight_sold_breeder = $breeder_property->value;
    					array_push($weights_sold_breeder, $weight_sold_breeder);
    				}
    			}
    		}
    	}
	  	

    	return view('pigs.mortalityandsalesreport', compact('dead_breeders', 'dead_growers', 'sold_breeders', 'sold_growers', 'removed', 'ages_dead', 'ages_sold_breeder', 'ages_sold_grower', 'weights_sold_breeder', 'weights_sold_grower'));
    }

    public function getFarmProfilePage(){
      $farm = $this->user->getFarm();
      $breed = $farm->getBreed();

      return view('pigs.farmprofile', compact('farm', 'breed'));
    }

    public function getAddBreedersPage(){
      $pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

      $sows = [];
      $boars = [];
      foreach($pigs as $pig){
        if(substr($pig->registryid, -7, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -7, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      return view('pigs.addbreeders', compact('pigs', 'sows', 'boars'));
    }

    public function getAnimalRecordPage(){
      $pigs = Animal::where("animaltype_id", 3)->where("status", "breeder")->get();

      $sows = [];
      $boars = [];
      foreach($pigs as $pig){
        if(substr($pig->registryid, -7, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -7, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      return view('pigs.individualrecords', compact('pigs', 'sows', 'boars'));
    }

    public function getAddPigPage(){
      return view('pigs.addpig');
    }

    public function getViewSowPage($id){
      $sow = Animal::find($id);
      $properties = $sow->getAnimalProperties();
      $ponderalprop = $properties->where("property_id", 43)->first();

      $now = Carbon::now();
      if(!is_null($properties->where("property_id", 25)->first())){
        $end_date = Carbon::parse($properties->where("property_id", 25)->first()->value);
        $age = $now->diffInMonths($end_date);
      }
      else{
        $age = "";
      }

      if(is_null($properties->where("property_id", 40)->first()) || is_null($properties->where("property_id", 47)->first())){
        $ponderalIndexValue = "";
      }
      else{
        $ponderalIndexValue = $properties->where("property_id", 47)->first()->value/(($properties->where("property_id", 40)->first()->value/100)**3);
      }

      if(is_null($properties->where("property_id", 43)->first())){
        $ponderalindex = new AnimalProperty;
        $ponderalindex->animal_id = $sow->id;
        $ponderalindex->property_id = 43;
        $ponderalindex->value = $ponderalIndexValue;
        $ponderalindex->save();
      }
      else{
        $ponderalprop->value = $ponderalIndexValue;
        $ponderalprop->save();
      }

      if(!is_null($properties->where("property_id", 25)->first()) && !is_null($properties->where("property_id", 61)->first())){
        $start_weaned = Carbon::parse($properties->where("property_id", 25)->first()->value);
        $end_weaned = Carbon::parse($properties->where("property_id", 61)->first()->value);
        $ageAtWeaning = $end_weaned->diffInMonths($start_weaned);
      }
      else{
        $ageAtWeaning = "";
      }

      return view('pigs.viewsow', compact('sow', 'properties', 'age', 'ponderalindex', 'ageAtWeaning'));
    }

    public function getViewBoarPage($id){
      $boar = Animal::find($id);
      $properties = $boar->getAnimalProperties();
      $ponderalprop = $properties->where("property_id", 43)->first();

      $now = Carbon::now();
      if(!is_null($properties->where("property_id", 25)->first())){
        $end_date = Carbon::parse($properties->where("property_id", 25)->first()->value);
        $age = $now->diffInMonths($end_date);
      }
      else{
        $age = "";
      }

      if(is_null($properties->where("property_id", 40)->first()) || is_null($properties->where("property_id", 47)->first())){
        $ponderalIndexValue = "";
      }
      else{
        $ponderalIndexValue = $properties->where("property_id", 47)->first()->value/(($properties->where("property_id", 40)->first()->value/100)**3);
      }

      if(is_null($properties->where("property_id", 43)->first())){
        $ponderalindex = new AnimalProperty;
        $ponderalindex->animal_id = $boar->id;
        $ponderalindex->property_id = 43;
        $ponderalindex->value = $ponderalIndexValue;
        $ponderalindex->save();
      }
      else{
        $ponderalprop->value = $ponderalIndexValue;
        $ponderalprop->save();
      }

      if(!is_null($properties->where("property_id", 25)->first()) && !is_null($properties->where("property_id", 61)->first())){
        $start_weaned = Carbon::parse($properties->where("property_id", 25)->first()->value);
        $end_weaned = Carbon::parse($properties->where("property_id", 61)->first()->value);
        $ageAtWeaning = $end_weaned->diffInMonths($start_weaned);
      }
      else{
        $ageAtWeaning = "";
      }

      return view('pigs.viewboar', compact('boar', 'properties', 'age', 'ponderalindex', 'ageAtWeaning'));
    }

    public function getGrossMorphologyPage($id){
      $animal = Animal::find($id);
      $properties = $animal->getAnimalProperties();

      return view('pigs.grossmorphology', compact('animal', 'properties'));
    }

    public function getEditGrossMorphologyPage($id){
      $animal = Animal::find($id);
      $properties = $animal->getAnimalProperties();

      return view('pigs.editgrossmorphology', compact('animal', 'properties'));
    }

    public function getMorphometricCharsPage($id){
      $animal = Animal::find($id);
      $properties = $animal->getAnimalProperties();

      return view('pigs.morphometriccharacteristics', compact('animal', 'properties'));
    }

    public function getEditMorphometricCharsPage($id){
      $animal = Animal::find($id);
      $properties = $animal->getAnimalProperties();

      return view('pigs.editmorphometriccharacteristics', compact('animal', 'properties'));
    }

    public function getWeightRecordsPage($id){
      $animal = Animal::find($id);
      $properties = $animal->getAnimalProperties();

      return view('pigs.weightrecords', compact('animal', 'properties'));
    }

    public function getEditWeightRecordsPage($id){
      $animal = Animal::find($id);
      $properties = $animal->getAnimalProperties();

      return view('pigs.editweightrecords', compact('animal', 'properties'));
    }

    public function getSowRecordPage($id){
      $sow = Animal::find($id);
      $properties = $sow->getAnimalProperties();

      return view('pigs.sowrecord', compact('sow', 'properties'));
    }

    public function getBoarRecordPage($id){
      $boar = Animal::find($id);
      $properties = $boar->getAnimalProperties();

      return view('pigs.boarrecord', compact('boar', 'properties'));
    }

    public function fetchBreedersAjax($breederid){
      $pig = Animal::where("registryid", $breederid)->first();

      $pig->status = "breeder";
      $pig->save();

      // return view('pigs.addbreeders', compact('pigs', 'sows', 'boars'));
    }
    
    public function addBreedingRecord(Request $request){
      $sow = Animal::where("registryid", $request->sow_id)->first();
      $boar = Animal::where("registryid", $request->boar_id)->first();

      $pair = new Grouping;
      $pair->registryid = $sow->registryid;
      $pair->father_id = $boar->id;
      $pair->mother_id = $sow->id;
      $pair->save();

      $dateBredValue = $request->date_bred;

      $date_bred = new GroupingProperty;
      $date_bred->grouping_id = $pair->id;
      $date_bred->property_id = 48;
      $date_bred->value = $dateBredValue;
      $date_bred->datecollected = new Carbon();
      $date_bred->save();

      $edfValue = Carbon::parse($dateBredValue)->addDays(114);

      $edf = new GroupingProperty;
      $edf->grouping_id = $pair->id;
      $edf->property_id = 49;
      $edf->value = $edfValue;
      $edf->datecollected = new Carbon();
      $edf->save();

      if(isset($_POST['recycled'])){
        $recycledValue = 1;
        $statusValue = "Recycled";
      }
      else{
        $recycledValue = 0;
        $statusValue = "Pregnant";
      }

      $recycled = new GroupingProperty;
      $recycled->grouping_id = $pair->id;
      $recycled->property_id = 51;
      $recycled->value = $recycledValue;
      $recycled->datecollected = new Carbon();
      $recycled->save();

      $status = new GroupingProperty;
      $status->grouping_id = $pair->id;
      $status->property_id = 50;
      $status->value = $statusValue;
      $status->datecollected = new Carbon();
      $status->save();

      return Redirect::back()->with('message','Operation Successful!');

    }

  
    public function addSowLitterRecord(Request $request){
      $grouping = Grouping::find($request->grouping_id);
      $members = $grouping->getGroupingMembers();
      $offspring = new Animal;

      $birthdayValue = new Carbon($request->date_farrowed);
      if(!is_null($request->offspring_earnotch) && !is_null($request->sex) && !is_null($request->birth_weight)){
        $farm = $this->user->getFarm();
        $breed = $farm->getBreed();
        $offspring->animaltype_id = 3;
        $offspring->farm_id = $farm->id;
        $offspring->breed_id = $breed->id;
        $offspring->status = "active";
        $offspring->registryid = $farm->code.$breed->breed."-".$birthdayValue->year.$request->sex.$request->offspring_earnotch;
        $offspring->save();

        $birthday = new AnimalProperty;
        $birthday->animal_id = $offspring->id;
        $birthday->property_id = 25;
        $birthday->value = $request->date_farrowed;
        $birthday->save();

        $sex = new AnimalProperty;
        $sex->animal_id = $offspring->id;
        $sex->property_id = 27;
        $sex->value = $request->sex;
        $sex->save();

        $birthweight = new AnimalProperty;
        $birthweight->animal_id = $offspring->id;
        $birthweight->property_id = 53;
        $birthweight->value = $request->birth_weight;
        $birthweight->save();

        $groupingmember = new GroupingMember;
        $groupingmember->grouping_id = $grouping->id;
        $groupingmember->animal_id = $offspring->id;
        $groupingmember->save();
      }

      $datefarrowedgroupprop = $grouping->getGroupingProperties()->where("property_id", 25)->first();
      if(is_null($datefarrowedgroupprop)){
      	$date_farrowed = new GroupingProperty;
	      $date_farrowed->grouping_id = $grouping->id;
	      $date_farrowed->property_id = 25;
	      $date_farrowed->value = $request->date_farrowed;
	      $date_farrowed->datecollected = new Carbon();
	      $date_farrowed->save();
      }
      else{
      	$datefarrowedgroupprop->value = $request->date_farrowed;
      	$datefarrowedgroupprop->save();
      }

      $status = GroupingProperty::where("property_id", 50)->where("grouping_id", $grouping->id)->first();
      $status->value = "Farrowed";
      $status->save();

      // if(!is_null($request->date_farrowed) || (is_null($request->sex) && is_null($request->birth_weight))){
      //   if(is_null($request->date_weaned)){
      //     $dateWeanedValue = Carbon::parse($request->date_farrowed)->addDays(45);
      //   }
      //   else{
      //     $dateWeanedValue = $request->date_weaned;
      //   }

      //   $date_weaned = new GroupingProperty;
      //   $date_weaned->grouping_id = $grouping->id;
      //   $date_weaned->property_id = 61;
      //   $date_weaned->value = $dateWeanedValue;
      //   $date_weaned->datecollected = new Carbon();
      //   $date_weaned->save();
      // }

      if(is_null($request->number_stillborn)){
        $noStillbornValue = 0;
      }
      else{
        $noStillbornValue = $request->number_stillborn;
      }

      $stillbornprop = $grouping->getGroupingProperties()->where("property_id", 74)->first();
      if(is_null($stillbornprop)){
        $no_stillborn = new GroupingProperty;
        $no_stillborn->grouping_id = $grouping->id;
        $no_stillborn->property_id = 74;
        $no_stillborn->value = $noStillbornValue;
        $no_stillborn->datecollected = new Carbon();
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

      $mummifiedprop = $grouping->getGroupingProperties()->where("property_id", 75)->first();
      if(is_null($mummifiedprop)){
        $no_mummified = new GroupingProperty;
        $no_mummified->grouping_id = $grouping->id;
        $no_mummified->property_id = 75;
        $no_mummified->value = $noMummifiedValue;
        $no_mummified->datecollected = new Carbon();
        $no_mummified->save();
      }
      else{
        $mummifiedprop->value = $noMummifiedValue;
        $mummifiedprop->save();
      }

      // $parityValue = substr($request->parity, -2, 2);
      $datefarrowedprop = $grouping->getGroupingProperties()->where("property_id", 25)->first();
      $parityprop = $grouping->getGroupingProperties()->where("property_id", 76)->first();
      if(is_null($datefarrowedprop)){ // NEW RECORD
        if(is_null($parityprop)){
          $paritymotherprop = $grouping->getMother()->getAnimalProperties()->where("property_id", 76)->first();
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
            $parity->datecollected = new Carbon();
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
            $parity->property_id = 76;
            $parity->value = $parityValue;
            $parity->datecollected = new Carbon();
            $parity->save();
          }
        }
      }
      else{ // EXISTING RECORD
        if(is_null($parityprop)){
          $paritymotherprop = $grouping->getMother()->getAnimalProperties()->where("property_id", 76)->first();
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
	          $parity->datecollected = new Carbon();
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
	          $parity->property_id = 76;
	          $parity->value = $parityValue;
	          $parity->datecollected = new Carbon();
	          $parity->save();
          }
        }
        else{
          $parityprop->value = $request->parity;
          $parityprop->save();
        }
      }

      static::addParityMother($grouping->id);

      $grouping->members = 1;
      $grouping->save();

      return Redirect::back()->with('message', 'Operation Successful!');
    }

    public function addWeaningWeights(Request $request){
      $grouping = Grouping::find($request->family_id);
      $offspring = Animal::where("registryid", $request->offspring_id)->first();

      $dateweanedprop = $grouping->getGroupingProperties()->where("property_id", 61)->first();
      if(is_null($dateweanedprop)){
      	$date_weaned_group = new GroupingProperty;
      	$date_weaned_group->grouping_id = $grouping->id;
        $date_weaned_group->property_id = 61;
        $date_weaned_group->value = Carbon::parse($grouping->getGroupingProperties()->where("property_id", 25)->first()->value)->addDays(45);
        $date_weaned_group->datecollected = new Carbon();
        $date_weaned_group->save();

      	$date_weaned_individual = new AnimalProperty;
	      $date_weaned_individual->animal_id = $offspring->id;
	      $date_weaned_individual->property_id = 61;
	      $date_weaned_individual->value = Carbon::parse($grouping->getGroupingProperties()->where("property_id", 25)->first()->value)->addDays(45);
	      $date_weaned_individual->save();

	      $weaningweight = new AnimalProperty;
	      $weaningweight->animal_id = $offspring->id;
	      $weaningweight->property_id = 54;
	      $weaningweight->value = $request->weaning_weight;
	      $weaningweight->save();
      }
      else{
      	$dateweanedprop->value = Carbon::parse($grouping->getGroupingProperties()->where("property_id", 25)->first()->value)->addDays(45);
      	$dateweanedprop->save();

      	$date_weaned_individual = new AnimalProperty;
	      $date_weaned_individual->animal_id = $offspring->id;
	      $date_weaned_individual->property_id = 61;
	      $date_weaned_individual->value = $dateweanedprop->value;
	      $date_weaned_individual->save();

	      $weaningweight = new AnimalProperty;
	      $weaningweight->animal_id = $offspring->id;
	      $weaningweight->property_id = 54;
	      $weaningweight->value = $request->weaning_weight;
	      $weaningweight->save();
      }

      return Redirect::back()->with('message', 'Operation Successful!');
    }

    public function fetchNewPigRecord(Request $request){
      // $pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

      $birthdayValue = new Carbon($request->date_farrowed);
      $newpig = new Animal;
      $farm = $this->user->getFarm();
      $breed = $farm->getBreed();
      $newpig->animaltype_id = 3;
      $newpig->farm_id = $farm->id;
      $newpig->breed_id = $breed->id;
      $newpig->status = "active";
      if(is_null($request->date_farrowed)){
        $newpig->registryid = $farm->code.$breed->breed."-".$request->sex.$request->earnotch;
      }
      else{
        $newpig->registryid = $farm->code.$breed->breed."-".$birthdayValue->year.$request->sex.$request->earnotch;
      }
      $newpig->save();

      if(is_null($request->date_farrowed)){
        $bdayValue = "Not specified";
      }
      else{
        $bdayValue = $request->date_farrowed;
      }

      $birthday = new AnimalProperty;
      $birthday->animal_id = $newpig->id;
      $birthday->property_id = 25;
      $birthday->value = $bdayValue;
      $birthday->save();

      $sex = new AnimalProperty;
      $sex->animal_id = $newpig->id;
      $sex->property_id = 27;
      $sex->value = $request->sex;
      $sex->save();

      if(is_null($request->birth_weight)){
        $birthWeightValue = "";
      }
      else{
        $birthWeightValue = $request->birth_weight;
      }

      $birthweight = new AnimalProperty;
      $birthweight->animal_id = $newpig->id;
      $birthweight->property_id = 53;
      $birthweight->value = $birthWeightValue;
      $birthweight->save();

      if(is_null($request->date_weaned)){
        if(!is_null($request->date_farrowed)){
        	$dateWeanedValue = Carbon::parse($bdayValue)->addDays(60);
        }
        else{
        	$dateWeanedValue = "Not specified";
        }
      }
      else{
        $dateWeanedValue = $request->date_weaned;
      }

      $date_weaned = new AnimalProperty;
      $date_weaned->animal_id = $newpig->id;
      $date_weaned->property_id = 61;
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
      $weaningweight->property_id = 54;
      $weaningweight->value = $weaningWeightValue;
      $weaningweight->save();

      $pigs = Animal::where("animaltype_id", 3)->get();

      if(!is_null($request->mother) && !is_null($request->father)){
        $grouping = new Grouping;

        foreach ($pigs as $pig) {
          if(substr($pig->registryid, -6, 6) == $request->mother){
            $grouping->registryid = $pig->registryid;
            $grouping->mother_id = $pig->id;
            $foundmother = 1;
          }
          if(substr($pig->registryid, -6, 6) == $request->father){
            $grouping->father_id = $pig->id;
            $foundfather = 1;
          }
        }

        if($foundmother != 1){
          $motheranimal = new AnimalProperty;
          $motheranimal->animal_id = $newpig->id;
          $motheranimal->property_id = 86;
          $motheranimal->value = $farm->code.$breed->breed."-"."F".$request->mother;
          $motheranimal->save();

          $grouping->registryid = $motheranimal->value;
          $grouping->mother_id = null;
        }
        if($foundfather != 1){
          $fatheranimal = new AnimalProperty;
          $fatheranimal->animal_id = $newpig->id;
          $fatheranimal->property_id = 87;
          $fatheranimal->value = $farm->code.$breed->breed."-"."M".$request->father;
          $fatheranimal->save();
          $grouping->father_id = null;
        }

        if($foundmother == 1 || $foundfather == 1){
          $grouping->members = 1;
          $grouping->save();

          $groupingmember = new GroupingMember;
          $groupingmember->grouping_id = $grouping->id;
          $groupingmember->animal_id = $newpig->id;
          $groupingmember->save();

          if(!is_null($request->date_farrowed)){
            $farrowed = new GroupingProperty;
            $farrowed->grouping_id = $grouping->id;
            $farrowed->property_id = 25;
            $farrowed->value = $request->date_farrowed;
            $farrowed->datecollected = new Carbon();
            $farrowed->save();

            $dateFarrowedValue = new Carbon($request->date_farrowed);

            $date_bred = new GroupingProperty;
            $date_bred->grouping_id = $grouping->id;
            $date_bred->property_id = 48;
            $date_bred->value = $dateFarrowedValue->subDays(114);
            $date_bred->datecollected = new Carbon();
            $date_bred->save();

            $edf = new GroupingProperty;
            $edf->grouping_id = $grouping->id;
            $edf->property_id = 49;
            $edf->value = $request->date_farrowed;
            $edf->datecollected = new Carbon();
            $edf->save();

            $recycled = new GroupingProperty;
            $recycled->grouping_id = $grouping->id;
            $recycled->property_id = 51;
            $recycled->value = 0;
            $recycled->datecollected = new Carbon();
            $recycled->save();

            $status = new GroupingProperty;
            $status->grouping_id = $grouping->id;
            $status->property_id = 50;
            $status->value = "Farrowed";
            $status->datecollected = new Carbon();
            $status->save();

            $date_weaned = new AnimalProperty;
            $date_weaned->animal_id = $newpig->id;
            $date_weaned->property_id = 61;
            $date_weaned->value = $dateFarrowedValue->addDays(60);
            $date_weaned->save();
          }
        }
      }

      return Redirect::back()->with('message', 'Operation Successful!');
    }

    public function fetchGrossMorphology(Request $request){
      $animalid = $request->animal_id;

      //GROSS MORPHOLOGY
      $dcgross = new AnimalProperty;
      $hairtype1 = new AnimalProperty;
      $hairtype2 = new AnimalProperty;
      $coatcolor = new AnimalProperty;
      $colorpattern = new AnimalProperty;
      $headshape = new AnimalProperty;
      $skintype = new AnimalProperty;
      $eartype = new AnimalProperty;
      $backline = new AnimalProperty;
      $tailtype = new AnimalProperty;
      $othermarks = new AnimalProperty;

      if(is_null($request->date_collected_gross)){
        $dateCollectedGrossValue = new Carbon();
      }
      else{
        $dateCollectedGrossValue = $request->date_collected_gross;
      }

      $dcgross->animal_id = $animalid;
      $dcgross->property_id = 67;
      $dcgross->value = $dateCollectedGrossValue;

      if(is_null($request->hair_type1)){
        $hairTypeValue = "Not specified";
      }
      else{
        $hairTypeValue = $request->hair_type1;
      }

      $hairtype1->animal_id = $animalid;
      $hairtype1->property_id = 28;
      $hairtype1->value = $hairTypeValue;

      if(is_null($request->hair_type2)){
        $hairLengthValue = "Not specified";
      }
      else{
        $hairLengthValue = $request->hair_type2;
      }

      $hairtype2->animal_id = $animalid;
      $hairtype2->property_id = 29;
      $hairtype2->value = $hairLengthValue;

      if(is_null($request->coat_color)){
        $coatColorValue = "Not specified";
      }
      else{
        $coatColorValue = $request->coat_color;
      }

      $coatcolor->animal_id = $animalid;
      $coatcolor->property_id = 30;
      $coatcolor->value = $coatColorValue;

      if(is_null($request->color_pattern)){
        $colorPatternValue = "Not specified";
      }
      else{
        $colorPatternValue = $request->color_pattern;
      }

      $colorpattern->animal_id = $animalid;
      $colorpattern->property_id = 31;
      $colorpattern->value = $colorPatternValue;

      if(is_null($request->head_shape)){
        $headShapeValue = "Not specified";
      }
      else{
        $headShapeValue = $request->head_shape;
      }

      $headshape->animal_id = $animalid;
      $headshape->property_id = 32;
      $headshape->value = $headShapeValue;

      if(is_null($request->skin_type)){
        $skinTypeValue = "Not specified";
      }
      else{
        $skinTypeValue = $request->skin_type;
      }

      $skintype->animal_id = $animalid;
      $skintype->property_id = 33;
      $skintype->value = $skinTypeValue;

      if(is_null($request->ear_type)){
        $earTypeValue = "Not specified";
      }
      else{
        $earTypeValue = $request->ear_type;
      }

      $eartype->animal_id = $animalid;
      $eartype->property_id = 34;
      $eartype->value = $earTypeValue;

      if(is_null($request->tail_type)){
        $tailTypeValue = "Not specified";
      }
      else{
        $tailTypeValue = $request->tail_type;
      }

      $tailtype->animal_id = $animalid;
      $tailtype->property_id = 62;
      $tailtype->value = $tailTypeValue;

      if(is_null($request->backline)){
        $backlineValue = "Not specified";
      }
      else{
        $backlineValue = $request->backline;
      }

      $backline->animal_id = $animalid;
      $backline->property_id = 35;
      $backline->value = $backlineValue;

      if(is_null($request->other_marks)){
        $otherMarksValue = "None";
      }
      else{
        $otherMarksValue = $request->other_marks;
      }

      $othermarks->animal_id = $animalid;
      $othermarks->property_id = 36;
      $othermarks->value = $otherMarksValue;

      $dcgross->save();
      $hairtype1->save();
      $hairtype2->save();
      $coatcolor->save();
      $colorpattern->save();
      $headshape->save();
      $skintype->save();
      $eartype->save();
      $tailtype->save();
      $backline->save();
      $othermarks->save();

      $animal = Animal::find($animalid);
      $animal->phenotypic = 1;
      $animal->save();

      return Redirect::back()->with('message','Animal record successfully saved');
    }

    public function fetchMorphometricCharacteristics(Request $request){
      $animalid = $request->animal_id;

      //MORPHOMETRIC CHARACTERISTICS
      // $agefirstmating = new AnimalProperty;
      // $finalweight = new AnimalProperty;
      $dcmorpho = new AnimalProperty;
      // $finalWeightValue = $request->final_weight_at_8_months;
      $earlength = new AnimalProperty;
      $headlength = new AnimalProperty;
      $bodylength = new AnimalProperty;
      $snoutlength = new AnimalProperty;
      $heartgirth = new AnimalProperty;
      $pelvicwidth = new AnimalProperty;
      $taillength = new AnimalProperty;
      $heightatwithers = new AnimalProperty;
      // $ponderalindex = new AnimalProperty;
      $normalteats = new AnimalProperty;

      if(is_null($request->date_collected_morpho)){
        $dateCollectedMorphoValue = new Carbon();
      }
      else{
        $dateCollectedMorphoValue = $request->date_collected_morpho;
      }

      $dcmorpho->animal_id = $animalid;
      $dcmorpho->property_id = 68;
      $dcmorpho->value = $dateCollectedMorphoValue;

      if(is_null($request->ear_length)){
        $earLengthValue = "";
      }
      else{
        $earLengthValue = $request->ear_length;
      }

      $earlength->animal_id = $animalid;
      $earlength->property_id = 64;
      $earlength->value = $earLengthValue;

      if(is_null($request->head_length)){
        $headLengthValue = "";
      }
      else{
        $headLengthValue = $request->head_length;
      }

      $headlength->animal_id = $animalid;
      $headlength->property_id = 39;
      $headlength->value = $headLengthValue;

      if(is_null($request->snout_length)){
        $snoutLengthValue = "";
      }
      else{
        $snoutLengthValue = $request->snout_length;
      }

      $snoutlength->animal_id = $animalid;
      $snoutlength->property_id = 63;
      $snoutlength->value = $snoutLengthValue;

      if(is_null($request->body_length)){
        $bodyLengthValue = "";
      }
      else{
        $bodyLengthValue = $request->body_length;
      }

      $bodylength->animal_id = $animalid;
      $bodylength->property_id = 40;
      $bodylength->value = $bodyLengthValue;

      if(is_null($request->heart_girth)){
        $heartGirthValue = "";
      }
      else{
        $heartGirthValue = $request->heart_girth;
      }

      $heartgirth->animal_id = $animalid;
      $heartgirth->property_id = 42;
      $heartgirth->value = $heartGirthValue;

      if(is_null($request->pelvic_width)){
        $pelvicWidthValue = "";
      }
      else{
        $pelvicWidthValue = $request->pelvic_width;
      }

      $pelvicwidth->animal_id = $animalid;
      $pelvicwidth->property_id = 41;
      $pelvicwidth->value = $pelvicWidthValue;

      if(is_null($request->tail_length)){
        $tailLengthValue = "";
      }
      else{
        $tailLengthValue = $request->tail_length;
      }

      $taillength->animal_id = $animalid;
      $taillength->property_id = 65;
      $taillength->value = $tailLengthValue;

      if(is_null($request->height_at_withers)){
        $heightAtWithersValue = "";
      }
      else{
        $heightAtWithersValue = $request->height_at_withers;
      }

      $heightatwithers->animal_id = $animalid;
      $heightatwithers->property_id = 66;
      $heightatwithers->value = $heightAtWithersValue;


      $animal = Animal::find($animalid);

      if(is_null($request->number_of_normal_teats)){
        $normalTeatsValue = "";
      }
      else{
        $normalTeatsValue = $request->number_of_normal_teats;
      }

      $normalteats->animal_id = $animalid;
      $normalteats->property_id = 44;
      $normalteats->value = $normalTeatsValue;
      $normalteats->save();
      

      // $agefirstmating->save();
      // $finalweight->save();
      $dcmorpho->save();
      $earlength->save();
      $headlength->save();
      $snoutlength->save();
      $bodylength->save();
      $pelvicwidth->save();
      $heartgirth->save();
      $taillength->save();
      $heightatwithers->save();
      // $ponderalindex->save();

      $animal->morphometric = 1;
      $animal->save();

      return Redirect::back()->with('message','Animal record successfully saved');
    }

    public function fetchWeightRecords(Request $request){
      $animalid = $request->animal_id;
      $animal = Animal::find($animalid);

      $bday = $animal->getAnimalProperties()->where("property_id", 25)->first();

      //BODY WEIGHTS
      $bw45d = new AnimalProperty;
      $dc45d = new AnimalProperty;
      $bw60d = new AnimalProperty;
      $dc60d = new AnimalProperty;
      $bw90d = new AnimalProperty;
      $dc90d = new AnimalProperty;
      $bw180d = new AnimalProperty;
      $dc180d = new AnimalProperty;

      if(is_null($request->body_weight_at_45_days)){
        $bw45dValue = "";
      }
      else{
        $bw45dValue = $request->body_weight_at_45_days;
      }

      $bw45d->animal_id = $animalid;
      $bw45d->property_id = 45;
      $bw45d->value = $bw45dValue;

      if(is_null($request->date_collected_45_days)){
        if(!is_null($bday)){
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
      $dc45d->property_id = 58;
      $dc45d->value = $dc45dValue;

      if(is_null($request->body_weight_at_60_days)){
        $bw60dValue = "";
      }
      else{
        $bw60dValue = $request->body_weight_at_60_days;
      }

      $bw60d->animal_id = $animalid;
      $bw60d->property_id = 46;
      $bw60d->value = $bw60dValue;

      if(is_null($request->date_collected_60_days)){
        if(!is_null($bday)){
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
      $dc60d->property_id = 59;
      $dc60d->value = $dc60dValue;

      if(is_null($request->body_weight_at_90_days)){
        $bw90dValue = "";
      }
      else{
        $bw90dValue = $request->body_weight_at_90_days;
      }

      $bw90d->animal_id = $animalid;
      $bw90d->property_id = 69;
      $bw90d->value = $bw90dValue;

      if(is_null($request->date_collected_90_days)){
        if(!is_null($bday)){
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
      $dc90d->property_id = 70;
      $dc90d->value = $dc90dValue;

      if(is_null($request->body_weight_at_180_days)){
        $bw180dValue = "";
      }
      else{
        $bw180dValue = $request->body_weight_at_180_days;
      }

      $bw180d->animal_id = $animalid;
      $bw180d->property_id = 47;
      $bw180d->value = $bw180dValue;

      if(is_null($request->date_collected_180_days)){
        if(!is_null($bday)){
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
      $dc180d->property_id = 60;
      $dc180d->value = $dc180dValue;

      $bw45d->save();
      $dc45d->save();
      $bw60d->save();
      $dc60d->save();
      $bw90d->save();
      $dc90d->save();
      $bw180d->save();
      $dc180d->save();

      $animal = Animal::find($animalid);
      $animal->weightrecord = 1;
      $animal->save();

      return Redirect::back()->with('message','Animal record successfully saved');
    }

    public function editGrossMorphology(Request $request){
      $animal = Animal::find($request->animal_id);
      $properties = $animal->getAnimalProperties();

      $hairtype = $properties->where("property_id", 28)->first();
      if(is_null($request->hair_type1)){
        $hairTypeValue = "Not specified";
      }
      else{
        $hairTypeValue = $request->hair_type1;
      }
      $hairtype->value = $hairTypeValue;

      $hairlength = $properties->where("property_id", 29)->first();
      if(is_null($request->hair_type2)){
        $hairLengthValue = "Not specified";
      }
      else{
        $hairLengthValue = $request->hair_type2;
      }
      $hairlength->value = $hairLengthValue;

      $coatcolor = $properties->where("property_id", 30)->first();
      if(is_null($request->coat_color)){
        $coatColorValue = "Not specified";
      }
      else{
        $coatColorValue = $request->coat_color;
      }
      $coatcolor->value = $coatColorValue;

      $colorpattern = $properties->where("property_id", 31)->first();
      if(is_null($request->color_pattern)){
        $colorPatternValue = "Not specified";
      }
      else{
        $colorPatternValue = $request->color_pattern;
      }
      $colorpattern->value = $colorPatternValue;

      $headshape = $properties->where("property_id", 32)->first();
      if(is_null($request->head_shape)){
        $headShapeValue = "Not specified";
      }
      else{
        $headShapeValue = $request->head_shape;
      }
      $headshape->value = $headShapeValue;

      $skintype = $properties->where("property_id", 33)->first();
      if(is_null($request->skin_type)){
        $skinTypeValue = "Not specified";
      }
      else{
        $skinTypeValue = $request->skin_type;
      }
      $skintype->value = $skinTypeValue;

      $eartype = $properties->where("property_id", 34)->first();
      if(is_null($request->ear_type)){
        $earTypeValue = "Not specified";
      }
      else{
        $earTypeValue = $request->ear_type;
      }
      $eartype->value = $earTypeValue;

      $tailtype = $properties->where("property_id", 62)->first();
      if(is_null($request->tail_type)){
        $tailTypeValue = "Not specified";
      }
      else{
        $tailTypeValue = $request->tail_type;
      }
      $tailtype->value = $tailTypeValue;

      $backline = $properties->where("property_id", 35)->first();
      if(is_null($request->backline)){
        $backlineValue = "Not specified";
      }
      else{
        $backlineValue = $request->backline;
      }
      $backline->value = $backlineValue;

      $othermarks = $properties->where("property_id", 36)->first();
      if(is_null($request->other_marks)){
        $otherMarksValue = "Not specified";
      }
      else{
        $otherMarksValue = $request->other_marks;
      }
      $othermarks->value = $otherMarksValue;

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

      return Redirect::back()->with('message','Animal record successfully saved');
    }

    public function editMorphometricCharacteristics(Request $request){
      $animal = Animal::find($request->animal_id);
      $properties = $animal->getAnimalProperties();

      $earlength = $properties->where("property_id", 64)->first();
      if(is_null($request->ear_length)){
        $earLengthValue = "";
      }
      else{
        $earLengthValue = $request->ear_length;
      }
      $earlength->value = $earLengthValue;

      $headlength = $properties->where("property_id", 39)->first();
      if(is_null($request->head_length)){
        $headLengthValue = "";
      }
      else{
        $headLengthValue = $request->head_length;
      }
      $headlength->value = $headLengthValue;

      $snoutlength = $properties->where("property_id", 63)->first();
      if(is_null($request->snout_length)){
        $snoutLengthValue = "";
      }
      else{
        $snoutLengthValue = $request->snout_length;
      }
      $snoutlength->value = $snoutLengthValue;

      $bodylength = $properties->where("property_id", 40)->first();
      if(is_null($request->body_length)){
        $bodyLengthValue = "";
      }
      else{
        $bodyLengthValue = $request->body_length;
      }
      $bodylength->value = $bodyLengthValue;

      $heartgirth = $properties->where("property_id", 42)->first();
      if(is_null($request->heart_girth)){
        $heartGirthValue = "";
      }
      else{
        $heartGirthValue = $request->heart_girth;
      }
      $heartgirth->value = $heartGirthValue;

      $pelvicwidth = $properties->where("property_id", 41)->first();
      if(is_null($request->pelvic_width)){
        $pelvicWidthValue = "";
      }
      else{
        $pelvicWidthValue = $request->pelvic_width;
      }
      $pelvicwidth->value = $pelvicWidthValue;

      $taillength = $properties->where("property_id", 65)->first();
      if(is_null($request->tail_length)){
        $tailLengthValue = "";
      }
      else{
        $tailLengthValue = $request->tail_length;
      }
      $taillength->value = $tailLengthValue;

      $heightatwithers = $properties->where("property_id", 66)->first();
      if(is_null($request->height_at_withers)){
        $heightAtWithersValue = "";
      }
      else{
        $heightAtWithersValue = $request->height_at_withers;
      }
      $heightatwithers->value =  $heightAtWithersValue;

      $normalteats = $properties->where("property_id", 44)->first();
      if(is_null($request->number_of_normal_teats)){
        $normalTeatsValue = "";
      }
      else{
        $normalTeatsValue = $request->number_of_normal_teats;
      }
      $normalteats->value = $normalTeatsValue;

      $earlength->save();
      $headlength->save();
      $snoutlength->save();
      $bodylength->save();
      $heartgirth->save();
      $pelvicwidth->save();
      $taillength->save();
      $heightatwithers->save();
      $normalteats->save();

      return Redirect::back()->with('message','Animal record successfully saved');
    }

    public function editWeightRecords(Request $request){
      $animal = Animal::find($request->animal_id);
      $properties = $animal->getAnimalProperties();

      $bw45d = $properties->where("property_id", 45)->first();
      if(is_null($request->body_weight_at_45_days)){
        $bw45dValue = "";
      }
      else{
        $bw45dValue = $request->body_weight_at_45_days;
      }
      $bw45d->value = $bw45dValue;

      $bw60d = $properties->where("property_id", 46)->first();
      if(is_null($request->body_weight_at_60_days)){
        $bw60dValue = "";
      }
      else{
        $bw60dValue = $request->body_weight_at_60_days;
      }
      $bw60d->value = $bw60dValue;

      $bw90d = $properties->where("property_id", 69)->first();
      if(is_null($request->body_weight_at_90_days)){
        $bw90dValue = "";
      }
      else{
        $bw90dValue = $request->body_weight_at_90_days;
      }
      $bw90d->value = $bw90dValue;

      $bw180d = $properties->where("property_id", 47)->first();
      if(is_null($request->body_weight_at_180_days)){
        $bw180dValue = "";
      }
      else{
        $bw180dValue = $request->body_weight_at_180_days;
      }
      $bw180d->value = $bw180dValue;

      $bday = $properties->where("property_id", 25)->first();
      
      if(is_null($request->date_collected_45_days)){
      	if(!is_null($bday)){
      		$dc45dValue = Carbon::parse($bday->value)->addDays(45)->toDateString();
      	}
      	else{
      		$dc45dValue = "";
      	}
      }
      else{
      	$dc45dValue = $request->date_collected_45_days;
      }

      $dc45d = $properties->where("property_id", 58)->first();
      $dc45d->value = $dc45dValue;

      if(is_null($request->date_collected_60_days)){
      	if(!is_null($bday)){
      		$dc60dValue = Carbon::parse($bday->value)->addDays(60)->toDateString();
      	}
      	else{
      		$dc60dValue = "";
      	}
      }
      else{
      	$dc60dValue = $request->date_collected_60_days;
      }

      $dc60d = $properties->where("property_id", 59)->first();
      $dc60d->value = $dc60dValue;

      if(is_null($request->date_collected_90_days)){
      	if(!is_null($bday)){
      		$dc90dValue = Carbon::parse($bday->value)->addDays(90)->toDateString();
      	}
      	else{
      		$dc90dValue = "";
      	}
      }
      else{
      	$dc90dValue = $request->date_collected_90_days;
      }

      $dc90d = $properties->where("property_id", 70)->first();
      $dc90d->value = $dc90dValue;

      if(is_null($request->date_collected_180_days)){
      	if(!is_null($bday)){
      		$dc180dValue = Carbon::parse($bday->value)->addDays(180)->toDateString();
      	}
      	else{
      		$dc180dValue = "";
      	}
      }
      else{
      	$dc180dValue = $request->date_collected_180_days;
      }

      $dc180d = $properties->where("property_id", 60)->first();
      $dc180d->value = $dc180dValue;

      $bw45d->save();
      $bw60d->save();
      $bw90d->save();
      $bw180d->save();
      $dc45d->save();
      $dc60d->save();
      $dc90d->save();
      $dc180d->save();

      return Redirect::back()->with('message','Animal record successfully saved');
    }

    public function addMortalityRecord(Request $request){
      $dead = Animal::where("registryid", $request->registrationid_dead)->first();

      if($dead->status == "active"){
      	$dead->status = "dead grower";
	      $dead->save();
      }
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

      $date_died = new AnimalProperty;
      $date_died->animal_id = $dead->id;
      $date_died->property_id = 55;
      $date_died->value = $dateDiedValue;
      $date_died->save();

      if(is_null($request->cause_death)){
        $causeDeathValue = "";
      }
      else{
        $causeDeathValue = $request->cause_death;
      }

      $cause_death = new AnimalProperty;
      $cause_death->animal_id = $dead->id;
      $cause_death->property_id = 71;
      $cause_death->value = $causeDeathValue;
      $cause_death->save();

      return Redirect::back()->with('message', 'Operation Successful!');
    }

    public function addSalesRecord(Request $request){
      $sold = Animal::where("registryid", $request->registrationid_sold)->first();

      if($sold->status == "active"){
      	$sold->status = "sold grower";
	      $sold->save();
      }
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

      $date_sold = new AnimalProperty;
      $date_sold->animal_id = $sold->id;
      $date_sold->property_id = 56;
      $date_sold->value = $dateSoldValue;
      $date_sold->save();

      if(is_null($request->weight_sold)){
        $weightSoldValue = "";
      }
      else{
        $weightSoldValue = $request->weight_sold;
      }

      $weight_sold = new AnimalProperty;
      $weight_sold->animal_id = $sold->id;
      $weight_sold->property_id = 57;
      $weight_sold->value = $weightSoldValue;
      $weight_sold->save();

      return Redirect::back()->with('message','Operation Successful!');
    }

    public function addRemovedAnimalRecord(Request $request){
      $removed =  Animal::where("registryid", $request->registrationid_removed)->first();

      $removed->status = "removed";
      $removed->save();

      if(is_null($request->date_removed)){
        $dateRemovedValue = new Carbon();
      }
      else{
        $dateRemovedValue = $request->date_removed;
      }

      $date_removed = new AnimalProperty;
      $date_removed->animal_id = $removed->id;
      $date_removed->property_id = 72;
      $date_removed->value = $dateRemovedValue;
      $date_removed->save();

      $reason_removed = new AnimalProperty;
      $reason_removed->animal_id = $removed->id;
      $reason_removed->property_id = 73;
      $reason_removed->value = $request->reason_removed;
      $reason_removed->save();

      return Redirect::back()->with('message','Operation Successful!');
    }

    public function addFarmProfile(Request $request){
      $farm = $this->user->getFarm();
      $breed = $farm->getBreed();

      $farm->name = $request->farm_name;
      $farm->address = $request->province;
      $farm->save();

      return Redirect::back()->with('message', 'Operation Successful!');
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */

    
    /***** FUNCTIONS FOR CHICKEN & DUCK *****/

    public function getTestPage()
    {
      return view('poultry.chicken.breeder.familyrecord');
    }

    public function getIndex(){
      return view('poultry.dashboard');
    }

    public function getPageFamilyRecord(){
      return view('poultry.chicken.breeder.familyrecord');
    }

    public function getPageAddToBreeder() {
      $families = AnimalProperty::where('property_id', 5)->get();
      $replacements = Animal::where('status', 'replacement')->get();
      $breeders = Animal::where('status', 'breeder')->get();
      // $femalebreeders = [];
      // $malebreeders = [];
      // foreach($breeders as $breeder){
      //   if(substr($breeder->registryid, 13, 1) == 'F'){
      //     array_push($femalebreeders, $breeder);
      //   }
      //   if(substr($breeder->registryid, 13, 1) == 'M'){
      //     array_push($malebreeders, $breeder);
      //   }
      // }
      return view('poultry.chicken.breeder.addtobreeder', compact('replacements', 'families'));
    }

    public function addToFamily(){

    }

    public function createFamily($id){
      $families = AnimalProperty::where('property_id', 5)->get();
      $replacements = Animal::where('status', 'replacement')->get();
      $group = new Grouping;
      $animal = Animal::where('id', $id)->first();
      $group->registryid = $animal->registryid;
      $group->father_id = $animal->id;
      $group->save();

      $breedermember = new GroupingMember;
      $breedermember->grouping_id = $group->id;
      $breedermember->animal_id = $animal->id;
      $breedermember->save();
      $animal->status = "breeder";
      $animal->save();
      return Redirect::back()->with('message','Operation Successful !');
    }

    // public function addAnimalsToBreeder(Request $request){
    //   dd($request);
    // }

    public function getDailyRecords(){
      return view('poultry.chicken.breeder.eggproductionanddaily');
    }

    public function getPageEggQuality(){
      return view('poultry.chicken.breeder.eggquality');
    }

    public function getPageHatcheryParameter(){
      return view('poultry.chicken.breeder.hatcheryparameters');
    }

    public function getPagePhenotypicCharacteristic(){
      return view('poultry.chicken.breeder.phenotypic');
    }

    public function getPageMorphometricCharacteristic(){
      return view('poultry.chicken.breeder.morphometric');
    }

    public function getPageReplacementIndividualRecord(){
      return view('poultry.chicken.replacement.individualrecord');
    }

    // Registry ID -> year.generation.line.family.gender.wingband_id
    public function addReplacementIndividualRecord(Request $request){
      $now = new Carbon;
      $animal = new Animal;
      $farm = $this->user->getFarm();
      $breed = $farm->getBreed();
      $animaltype = $farm->getFarmType();
      $registryid = $farm->code.'-'.$now->year.$request->generation.$request->line.$request->family.$request->gender.$request->individual_id;

      $animal->animaltype_id = $animaltype->id;
      $animal->farm_id = $farm->id;
      $animal->breed_id = $breed->id;
      $animal->status = "replacement";
      $animal->registryid = $registryid;
      $animal->save();

      $animalproperty1 = new AnimalProperty;
      $animalproperty1->animal_id = $animal->id;
      $animalproperty1->property_id = 1;
      $animalproperty1->value = $request->date_hatched;
      $animalproperty1->save();

      $animalproperty2 = new AnimalProperty;
      $animalproperty2->animal_id = $animal->id;
      $animalproperty2->property_id = 2;
      $animalproperty2->value = $request->individual_id;
      $animalproperty2->save();

      $animalproperty3 = new AnimalProperty;
      $animalproperty3->animal_id = $animal->id;
      $animalproperty3->property_id = 3;
      $animalproperty3->value = $request->generation;
      $animalproperty3->save();

      $animalproperty4 = new AnimalProperty;
      $animalproperty4->animal_id = $animal->id;
      $animalproperty4->property_id = 4;
      $animalproperty4->value = $request->line;
      $animalproperty4->save();

      $animalproperty5 = new AnimalProperty;
      $animalproperty5->animal_id = $animal->id;
      $animalproperty5->property_id = 5;
      $animalproperty5->value = $request->family;
      $animalproperty5->save();

      $animalproperty6 = new AnimalProperty;
      $animalproperty6->animal_id = $animal->id;
      $animalproperty6->property_id = 6;
      $animalproperty6->value = $request->gender;
      $animalproperty6->save();

      $animalproperty7 = new AnimalProperty;
      $animalproperty7->animal_id = $animal->id;
      $animalproperty7->property_id = 7;
      $animalproperty7->value = $request->date_transferred;
      $animalproperty7->save();

      return Redirect::back()->with('message','Animal record successfully saved');
    }

    public function getPageReplacementGrowthPerformance(){
      return view('poultry.chicken.replacement.growthperformance');
    }

    public function getPageSearchID(){
        $replacement = Animal::where('status', 'replacement')->where(function ($query) {
                      $query->where('phenotypic', '==', false)
                            ->orWhere('morphometric', '==', false);
                            })->get();
        return view('poultry.chicken.replacement.phenomorphoidsearch', compact('replacement'));
    }

    public function searchID(Request $request){
      $animals =  Animal::where('status', 'replacement')->where(function ($query) {
                    $query->where('phenotypic', '==', false)
                          ->orWhere('morphometric', '==', false);
                          })->get();
      $replacement = [];
      foreach ($animals as $animal) {
        $id = substr($animal->registryid, 8);
        if(strpos($id, $request->id_no)!== false){
          array_push($replacement, $animal);
        }
      }
      return view('poultry.chicken.replacement.phenomorphoidsearch', compact('replacement'));
    }

    public function getPageReplacementPhenotypic($id){
      $farm = $this->user->getFarm();
      $breed = $farm->getBreed();
      $animaltype = $farm->getFarmType();
      $province = $farm->address;
      $breedname = $breed->breed;
      $animaltype_name = $animaltype->species;
      $code = $farm->code;
      $animal = Animal::find($id);
      $properties = $animal->getAnimalProperties();
      return view('poultry.chicken.breeder.phenotypic', compact('province', 'breedname', 'animaltype_name', 'code', 'animal', 'properties'));
    }

    public function fetchDataReplacementPhenotypic(Request $request){
      $pheno1 = new AnimalProperty;
      $pheno2 = new AnimalProperty;
      $pheno3 = new AnimalProperty;
      $pheno4 = new AnimalProperty;
      $pheno5 = new AnimalProperty;
      $pheno6 = new AnimalProperty;
      $pheno7 = new AnimalProperty;
      $pheno8 = new AnimalProperty;
      $pheno9 = new AnimalProperty;
      $pheno10 = new AnimalProperty;
      $pheno11 = new AnimalProperty;

      $pheno1->animal_id = $request->animal_id;
      $pheno1->property_id = 8;
      if($request->plummage_color_others != null && $request->plummage_color != null){
        $pheno1->value = $request->plummage_color.','.ucfirst($request->plummage_color_others);
      }else{
        $pheno1->value = $request->plummage_color.ucfirst($request->plummage_color_others);
      }

      $pheno2->animal_id = $request->animal_id;
      $pheno2->property_id = 9;
      if($request->plummage_pattern_others != null && $request->plummage_pattern != null){
        $pheno2->value = $request->plummage_pattern.','.ucfirst($request->plummage_pattern_others);
      }else{
        $pheno2->value = $request->plummage_pattern.ucfirst($request->plummage_pattern_others);
      }

      $pheno3->animal_id = $request->animal_id;
      $pheno3->property_id = 10;
      if($request->body_carriage_others != null && $request->body_carriage != null){
        $pheno3->value = $request->body_carriage.','.ucfirst($request->body_carriage_others);
      }else{
        $pheno3->value = $request->body_carriage.ucfirst($request->body_carriage_others);
      }

      $pheno4->animal_id = $request->animal_id;
      $pheno4->property_id = 11;
      if($request->comb_type_others != null && $request->comb_type != null){
        $pheno4->value = $request->comb_type.','.ucfirst($request->comb_type_others);
      }else{
        $pheno4->value = $request->comb_type.ucfirst($request->comb_type_others);
      }

      $pheno5->animal_id = $request->animal_id;
      $pheno5->property_id = 12;
      if($request->comb_color_others != null && $request->comb_color != null){
        $pheno5->value = $request->comb_color.','.ucfirst($request->comb_color_others);
      }else{
        $pheno5->value = $request->comb_color.ucfirst($request->comb_color_others);
      }

      $pheno6->animal_id = $request->animal_id;
      $pheno6->property_id = 13;
      if($request->earlobe_color_others != null && $request->earlobe_color != null){
        $pheno6->value = $request->earlobe_color.','.ucfirst($request->earlobe_color_others);
      }else{
        $pheno6->value = $request->earlobe_color.ucfirst($request->earlobe_color_others);
      }

      $pheno7->animal_id = $request->animal_id;
      $pheno7->property_id = 14;
      if($request->shank_color_others != null && $request->shank_color != null){
        $pheno7->value = $request->shank_color.','.ucfirst($request->shank_color_others);
      }else{
        $pheno7->value = $request->shank_color.ucfirst($request->shank_color_others);
      }

      $pheno8->animal_id = $request->animal_id;
      $pheno8->property_id = 15;
      if($request->skin_color_others != null && $request->skin_color != null){
        $pheno8->value = $request->skin_color.','.ucfirst($request->skin_color_others);
      }else{
        $pheno8->value = $request->skin_color.ucfirst($request->skin_color_others);
      }

      $pheno9->animal_id = $request->animal_id;
      $pheno9->property_id = 16;
      if($request->iris_color_others != null && $request->iris_color != null){
        $pheno9->value = $request->iris_color.','.ucfirst($request->iris_color_others);
      }else{
        $pheno9->value = $request->iris_color.ucfirst($request->iris_color_others);
      }

      $pheno10->animal_id = $request->animal_id;
      $pheno10->property_id = 17;
      if($request->beak_color_others != null && $request->beak_color != null){
        $pheno10->value = $request->beak_color.','.ucfirst($request->beak_color_others);
      }else{
        $pheno10->value = $request->beak_color.ucfirst($request->beak_color_others);
      }

      $pheno11->animal_id = $request->animal_id;
      $pheno11->property_id = 18;
      if($request->other_features != null){
        $pheno11->value = ucfirst($request->other_features);
      }else{
        $pheno11->value = "None";
      }

      $pheno1->save();
      $pheno2->save();
      $pheno3->save();
      $pheno4->save();
      $pheno5->save();
      $pheno6->save();
      $pheno7->save();
      $pheno8->save();
      $pheno9->save();
      $pheno10->save();
      $pheno11->save();

      $animal = Animal::find($request->animal_id);
      $animal->phenotypic = 1;
      $animal->save();
      $replacement = Animal::where('status', 'replacement')->where(function ($query) {
                    $query->where('phenotypic', '==', false)
                          ->orWhere('morphometric', '==', false);
                          })->get();
      return view('poultry.chicken.replacement.phenomorphoidsearch', compact('replacement'));
    }

    public function getPageReplacementMorphometric($id){
      $farm = $this->user->getFarm();
      $breed = $farm->getBreed();
      $animaltype = $farm->getFarmType();
      $province = $farm->address;
      $breedname = $breed->breed;
      $animaltype_name = $animaltype->species;
      $code = $farm->code;
      $animal = Animal::find($id);
      $properties = $animal->getAnimalProperties();

      return view('poultry.chicken.breeder.morphometric', compact('province', 'breedname', 'animaltype_name', 'code', 'animal', 'properties'));
    }

    public function fetchDataReplacementMorphometric(Request $request){
      $morpho1 = new AnimalProperty;
      $morpho2 = new AnimalProperty;
      $morpho3 = new AnimalProperty;
      $morpho4 = new AnimalProperty;
      $morpho5 = new AnimalProperty;
      $morpho6 = new AnimalProperty;

      $morpho1->animal_id = $request->animal_id;
      $morpho1->property_id = 19;
      $morpho1->value = $request->height;

      $morpho2->animal_id = $request->animal_id;
      $morpho2->property_id = 20;
      $morpho2->value = $request->body_length;

      $morpho3->animal_id = $request->animal_id;
      $morpho3->property_id = 21;
      $morpho3->value = $request->chest_circumference;

      $morpho4->animal_id = $request->animal_id;
      $morpho4->property_id = 22;
      $morpho4->value = $request->wing_span;

      $morpho5->animal_id = $request->animal_id;
      $morpho5->property_id = 23;
      $morpho5->value = $request->shank_length;

      $morpho6->animal_id = $request->animal_id;
      $morpho6->property_id = 24;
      $morpho6->value = $request->date_first_lay;

      $morpho1->save();
      $morpho2->save();
      $morpho3->save();
      $morpho4->save();
      $morpho5->save();
      $morpho6->save();

      $animal = Animal::find($request->animal_id);
      $animal->morphometric = 1;
      $animal->save();
      $replacement = Animal::where('status', 'replacement')->where(function ($query) {
                    $query->where('phenotypic', '==', false)
                          ->orWhere('morphometric', '==', false);
                          })->get();
      return view('poultry.chicken.replacement.phenomorphoidsearch', compact('replacement'));
    }

    public function getPageFeedingRecords(){
      return view('poultry.chicken.feeding');
    }

    public function getPageMonthlySales(){
      return view('poultry.chicken.monthlysales');
    }


    public function getFamilyRecord(Request $request){
      $farm = $this->user->getFarm();
      // $animaltype = $farm->getFarmType();
      // $breed = $farm->getBreed();
      $date_transferred = new Carbon($request->date_transferred);
      $date_hatched = new Carbon($request->date_hatched);
      $registry_id = $farm->code."-".$date_transferred->year."-".$request->family_id;

    }

}
