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

          $sows = [];
          $boars = [];
          foreach($pigs as $pig){
            if(substr($pig->registryid, -6, 1) == 'F'){
              array_push($sows, $pig);
            }
            if(substr($pig->registryid, -6, 1) == 'M'){
              array_push($boars, $pig);
            }
          }

          $dead = Animal::where("animaltype_id", 3)->where("status", "dead")->get();

          $sold = Animal::where("animaltype_id", 3)->where("status", "sold")->get();

          $sum = 0;
          $averageWeight = 0;
          $weights = [];
   
          foreach ($sold as $sold_pig) {
            $properties = $sold_pig->getAnimalProperties();
            foreach ($properties as $property) {
              if($property->property_id == 57){
              	if($property->value != ""){
                  $weight = $property->value;
                  array_push($weights, $weight);
                }
              }
            }
          }

          $mortalityRate = (count($dead)/count($pigs))*100;
          $salesRate = (count($sold)/count($pigs))*100;
          
          return view('pigs.dashboard', compact('user', 'farm', 'pigs', 'sows', 'boars', 'dead', 'sold', 'weights', 'mortalityRate', 'salesRate'));
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

    static function addParity($id){
      $grouping = Grouping::find($id);
      $mother = $grouping->getMother();

      $parityprop = $mother->getAnimalProperties()->where("property_id", 76)->first();
      $paritypropgroup = $grouping->getGroupingProperties()->where("property_id", 76)->first();
      $status = $grouping->getGroupingProperties()->where("property_id", 50)->first();
      $families = Grouping::where("mother_id", $mother->id)->get();

			$dates_bred = [];
			foreach ($families as $family) {
				$familyproperties = $family->getGroupingProperties();
				foreach ($familyproperties as $familyproperty) {
					if($familyproperty->property_id == 48){
						$date_bred = $familyproperty->value;
						array_push($dates_bred, $date_bred);
					}
      	}
    	}
    	
    	if(is_null($parityprop)){
    		$parity = new AnimalProperty;
    		$parity->animal_id = $mother->id;
    		$parity->property_id = 76;
    		$parity->value = count($dates_bred);
    		$parity->save();
    	}
    	else{
    		$parityprop->value = count($dates_bred);
    		$parityprop->save();
    	}

    	$sorted_dates = array_sort($dates_bred);
    	$count = 0;
    	foreach ($sorted_dates as $sorted_date) {
    		$count = $count + 1;
    		if($sorted_date == $grouping->getGroupingProperties()->where("property_id", 48)->first()->value){
    			if($status->value == "Farrowed" || $status->value == "Pregnant"){
    				if(is_null($paritypropgroup)){
		    			$paritygroup = new GroupingProperty;
		    			$paritygroup->grouping_id = $grouping->id;
				      $paritygroup->property_id = 76;
				      $paritygroup->value = $count;
				      $paritygroup->datecollected = new Carbon();
				      $paritygroup->save();
	    			}
	    			else{
	  					$paritypropgroup->value = $count;
	  					$paritypropgroup->save();
	    			}
    			}
    			elseif($status->value == "Recycled"){
    				$count = $count - 1;
    				if(is_null($paritypropgroup)){
		    			$paritygroup = new GroupingProperty;
		    			$paritygroup->grouping_id = $grouping->id;
				      $paritygroup->property_id = 76;
				      $paritygroup->value = $count;
				      $paritygroup->datecollected = new Carbon();
				      $paritygroup->save();
	    			}
	    			else{
	  					$paritypropgroup->value = $count;
	  					$paritypropgroup->save();
	    			}
    			}
    		}
    	}
    }

    public function getAddSowLitterRecordPage($id){
      $family = Grouping::find($id);
      $properties = $family->getGroupingProperties();
      $offsprings = $family->getGroupingMembers();

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

      $weaned = 0;
      foreach ($offsprings as $offspring) {
        if(!is_null($offspring->getAnimalProperties()->where("property_id", 54)->first())){
          $weaned = $weaned + 1;
        }
      }

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
      static::addParity($id);

      return view('pigs.sowlitterrecord', compact('family', 'offsprings', 'properties', 'countMales', 'countFemales', 'aveBirthWeight', 'weaned', 'aveWeaningWeight'));
    }

    public function getBreedingRecordPage(){
      $pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();
      $family = Grouping::whereNotNull("mother_id")->get();

      $sows = [];
      $boars = [];
      foreach($pigs as $pig){
        if(substr($pig->registryid, -6, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -6, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      $years = ["2010", "2011", "2012", "2013", "2014", "2015", "2016", "2017", "2018", "2019", "2020", "2021", "2022", "2023", "2024", "2025"];

      return view('pigs.breedingrecord', compact('pigs', 'sows', 'boars', 'family', 'years'));
    }

    public function getMortalityAndSalesPage(){
      $pigs = Animal::where("animaltype_id", 3)->get();
      $breeders = Animal::where("animaltype_id", 3)->where("status", "active")->get();

      $sold = [];
      $dead = [];
      $removed = [];
      foreach ($pigs as $pig){
        if($pig->status == "sold"){
          array_push($sold, $pig);
        }
        if($pig->status == "dead"){
          array_push($dead, $pig);
        }
        if($pig->status == "removed"){
          array_push($removed, $pig);
        }
      }
      
      $age = null;
      $years = ["2010", "2011", "2012", "2013", "2014", "2015", "2016", "2017", "2018", "2019", "2020", "2021", "2022", "2023", "2024", "2025"];

      return view('pigs.mortalityandsales', compact('pigs', 'breeders', 'sold', 'dead', 'removed', 'age', 'years'));
    }

    public function getGrossMorphologyReportPage(){
      $pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

      $filter = "All";

      $sows = [];
      $boars = [];

      foreach ($pigs as $pig) {
        if(substr($pig->registryid, -6, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -6, 1) == 'M'){
          array_push($boars, $pig);
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
          if($property->property_id == 28){
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

      $nohairtypes = (count($pigs)-(count($curlyhairs)+count($straighthairs)));
      $nohairlengths = (count($pigs)-(count($shorthairs)+count($longhairs)));
      $nocoats = (count($pigs)-(count($blackcoats)+count($nonblackcoats)));
      $nopatterns = (count($pigs)-(count($plains)+count($socks)));
      $noheadshapes = (count($pigs)-(count($concaves)+count($straightheads)));
      $noskintypes = (count($pigs)-(count($smooths)+count($wrinkleds)));
      $noeartypes = (count($pigs)-(count($droopingears)+count($semilops)+count($erectears)));
      $notailtypes = (count($pigs)-(count($curlytails)+count($straighttails)));
      $nobacklines = (count($pigs)-(count($swaybacks)+count($straightbacks)));

      return view('pigs.grossmorphoreport', compact('pigs', 'filter', 'sows', 'boars', 'curlyhairs', 'straighthairs', 'shorthairs', 'longhairs', 'blackcoats', 'nonblackcoats', 'plains', 'socks', 'concaves', 'straightheads', 'smooths', 'wrinkleds', 'droopingears', 'semilops', 'erectears', 'curlytails', 'straighttails', 'swaybacks', 'straightbacks', 'nohairtypes', 'nohairlengths', 'nocoats', 'nopatterns', 'noheadshapes', 'noskintypes', 'noeartypes', 'notailtypes', 'nobacklines'));
    }

    public function filterGrossMorphologyReport(Request $request){
      $pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

      $filter = $request->filter_keywords;

      $sows = [];
      $boars = [];

      $sowwithdata = 0;
      $boarwithdata = 0;

      foreach ($pigs as $pig) {
        if(substr($pig->registryid, -6, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -6, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      if($filter == "Sow"){
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
      elseif($filter == "Boar"){
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
      elseif($filter == "All"){
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
            if($property->property_id == 28){
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
      return view('pigs.grossmorphoreport', compact('pigs', 'filter', 'sows', 'boars', 'curlyhairs', 'straighthairs', 'shorthairs', 'longhairs', 'blackcoats', 'nonblackcoats', 'plains', 'socks', 'concaves', 'straightheads', 'smooths', 'wrinkleds', 'droopingears', 'semilops', 'erectears', 'curlytails', 'straighttails', 'swaybacks', 'straightbacks', 'nohairtypes', 'nohairlengths', 'nocoats', 'nopatterns', 'noheadshapes', 'noskintypes', 'noeartypes', 'notailtypes', 'nobacklines'));
    }

    static function standardDeviation($arr, $samp = false){
	    $ave = array_sum($arr) / count($arr);
	    $variance = 0.0;
	    foreach ($arr as $i) {
	      $variance += pow($i - $ave, 2);
	    }
	    $variance /= ( $samp ? count($arr) - 1 : count($arr) );
	    return (float) sqrt($variance);
		}

    public function getMorphometricCharacteristicsReportPage(){
      $pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

      $filter = "All";

      $sows = [];
      $boars = [];

      foreach ($pigs as $pig) {
        if(substr($pig->registryid, -6, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -6, 1) == 'M'){
          array_push($boars, $pig);
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

      return view('pigs.morphocharsreport', compact('pigs', 'filter', 'sows', 'boars', 'earlengths', 'headlengths', 'snoutlengths', 'bodylengths', 'heartgirths', 'pelvicwidths', 'ponderalindices', 'taillengths', 'heightsatwithers', 'normalteats', 'earlengths_sd', 'headlengths_sd', 'snoutlengths_sd', 'bodylengths_sd', 'heartgirths_sd', 'pelvicwidths_sd', 'ponderalindices_sd', 'taillengths_sd', 'heightsatwithers_sd', 'normalteats_sd'));
    }

    public function filterMorphometricCharacteristicsReport(Request $request){
      $pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

      $filter = $request->filter_keywords2;

      $sows = [];
      $boars = [];

      foreach ($pigs as $pig) {
        if(substr($pig->registryid, -6, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -6, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      if($filter == "Sow"){
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
      elseif($filter == "Boar"){
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
      elseif($filter == "All"){
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

      return view('pigs.morphocharsreport', compact('pigs', 'filter', 'sows', 'boars', 'earlengths', 'headlengths', 'snoutlengths', 'bodylengths', 'heartgirths', 'pelvicwidths', 'ponderalindices', 'taillengths', 'heightsatwithers', 'normalteats', 'earlengths_sd', 'headlengths_sd', 'snoutlengths_sd', 'bodylengths_sd', 'heartgirths_sd', 'pelvicwidths_sd', 'ponderalindices_sd', 'taillengths_sd', 'heightsatwithers_sd', 'normalteats_sd'));
    }

    public function getBreederProductionReportPage(){
    	$pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

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
        if(substr($pig->registryid, -6, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -6, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      $ages_weanedsow = [];
      foreach ($sows as $sow) {
        $sowproperties = $sow->getAnimalProperties();
        foreach ($sowproperties as $sowproperty) {
          if($sowproperty->property_id == 61){
            if(!is_null($sowproperty->value) && $sowproperty->value != "Not specified"){
              $date_weanedsow = $sowproperty->value;
              $weanedsowproperties = $sow->getAnimalProperties();
              foreach ($weanedsowproperties as $weanedsowproperty) {
                if($weanedsowproperty->property_id == 25){
                  if(!is_null($weanedsowproperty->value) && $weanedsowproperty->value != "Not specified"){
                    $bday_sow = $weanedsowproperty->value;
                  }
                }
              }
              $age_weanedsow = Carbon::parse($date_weanedsow)->diffInMonths(Carbon::parse($bday_sow));
              array_push($ages_weanedsow, $age_weanedsow);
            }
          }
        }
      }
      if($ages_weanedsow != []){
        $ages_weanedsow_sd = static::standardDeviation($ages_weanedsow, false);
      }

      $ages_weanedboar = [];
      foreach ($boars as $boar) {
        $boarproperties = $boar->getAnimalProperties();
        foreach ($boarproperties as $boarproperty) {
          if($boarproperty->property_id == 61){
            if(!is_null($boarproperty->value) && $boarproperty->value != "Not specified"){
              $date_weanedboar = $boarproperty->value;
              $weanedboarproperties = $boar->getAnimalProperties();
              foreach ($weanedboarproperties as $weanedboarproperty) {
                if($weanedboarproperty->property_id == 25){
                  if(!is_null($weanedboarproperty->value) && $weanedboarproperty->value != "Not specified"){
                    $bday_boar = $weanedboarproperty->value;
                  }
                }
              }
              $age_weanedboar = Carbon::parse($date_weanedboar)->diffInMonths(Carbon::parse($bday_boar));
              array_push($ages_weanedboar, $age_weanedboar);
            }
          }
        }
      }
      if($ages_weanedboar != []){
        $ages_weanedboar_sd = static::standardDeviation($ages_weanedboar, false);
      }

      $ages_weanedpig = [];
      foreach ($pigs as $pig) {
        $pigproperties = $pig->getAnimalProperties();
        foreach ($pigproperties as $pigproperty) {
          if($pigproperty->property_id == 61){
            if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
              $date_weanedpig = $pigproperty->value;
              $weanedpigproperties = $pig->getAnimalProperties();
              foreach ($weanedpigproperties as $weanedpigproperty) {
                if($weanedpigproperty->property_id == 25){
                  if(!is_null($weanedpigproperty->value) && $weanedpigproperty->value != "Not specified"){
                    $bday_pig = $weanedpigproperty->value;
                  }
                }
              }
              $age_weanedpig = Carbon::parse($date_weanedpig)->diffInMonths(Carbon::parse($bday_pig));
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
      $firstbredboars = [];
      $firstbredsowsages = [];
      $firstbredboarsages = [];
      $firstbredages = [];

      //first bred sows
      foreach ($groups as $group) {
      	$groupproperties = $group->getGroupingProperties();
      	foreach ($groupproperties as $groupproperty) {
      		if($groupproperty->property_id == 76){
      			if($groupproperty->value <= 1){
      				if($group->getMother()->status == "active"){
      					array_push($firstbreds, $group);
      				}
      			}
      		}
      	}
      }
      foreach ($firstbreds as $firstbred) {
      	$mother = $firstbred->getMother();
      	if($mother->status == "active"){
      		array_push($firstbredsows, $mother);
      	}
      }
      foreach ($firstbreds as $firstbred) {
      	$firstbredsowproperties = $firstbred->getGroupingProperties();
      	foreach ($firstbredsowproperties as $firstbredsowproperty) {
      		if($firstbredsowproperty->property_id == 48){
      			$date_bred = $firstbredsowproperty->value;
      			$bredsowproperties = $firstbred->getMother()->getAnimalProperties();
      			foreach ($bredsowproperties as $bredsowproperty) {
      				if($bredsowproperty->property_id == 25){
      					if(!is_null($bredsowproperty->value) && $bredsowproperty->value != "Not specified"){
      						$bday_sow = $bredsowproperty->value;
      						$firstbredsowsage = Carbon::parse($date_bred)->diffInMonths(Carbon::parse($bday_sow));
      						array_push($firstbredsowsages, $firstbredsowsage);
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
      		if($boarproperty->property_id == 88){
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
      				if($groupproperty->property_id == 48){
      					$date_bred = $groupproperty->value;
      					$bredboarproperties = $firstbredboar->getAnimalProperties();
      					foreach ($bredboarproperties as $bredboarproperty) {
      						if($bredboarproperty->property_id == 25){
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
      				if($groupproperty->property_id == 48){
      					$date_bred = $groupproperty->value;
      					array_push($dates_bred, $date_bred);
      				}
      			}
      			$sorted_dates = array_sort($dates_bred);
      			$keys = array_keys($sorted_dates);
      			$date_bredboar = $sorted_dates[$keys[0]];
      			$bredboarproperties = $uniqueboar->getAnimalProperties();
      			foreach ($bredboarproperties as $bredboarproperty) {
      				if($bredboarproperty->property_id == 25){
      					if(!is_null($bredboarproperty->value) && $bredboarproperty->value != "Not specified"){
      						$bday_boar = $bredboarproperty->value;
      					}
      				}
      			}
      		}
      	}
      	$firstbredboarsage = Carbon::parse($date_bredboar)->diffInMonths(Carbon::parse($bday_boar));
      	array_push($firstbredboarsages, $firstbredboarsage);
      }

      if($firstbredboarsages != []){
      	$firstbredboarsages_sd = static::standardDeviation($firstbredboarsages, false);
      }

      $firstbredages = array_merge($firstbredsowsages, $firstbredboarsages);
      if($firstbredages != []){
      	$firstbredages_sd = static::standardDeviation($firstbredages, false);
      }
      
      //age of breeding herd
      $breederages = [];
      $breeders = [];
      foreach ($pigs as $pig) {
        $genproperties = $pig->getAnimalProperties();
        foreach ($genproperties as $genproperty) {
          if($genproperty->property_id == 88){
            if($genproperty->value > 0){
              array_push($breeders, $pig);
              $bredpigproperties = $pig->getAnimalProperties();
              foreach ($bredpigproperties as $bredpigproperty) {
                if($bredpigproperty->property_id == 25){
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

      $breedersowages = [];
      $breedersows = [];
      foreach ($sows as $sow) {
      	$sowproperties = $sow->getAnimalProperties();
      	foreach ($sowproperties as $sowproperty) {
      		if($sowproperty->property_id == 88){
      			if($sowproperty->value > 0){
      				array_push($breedersows, $sow);
      				$bredsowproperties = $sow->getAnimalProperties();
      				foreach ($bredsowproperties as $bredsowproperty) {
      					if($bredsowproperty->property_id == 25){
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

      $breederboarages = [];
      $breederboars = [];
      foreach ($boars as $boar) {
      	$boarproperties = $boar->getAnimalProperties();
      	foreach ($boarproperties as $boarproperty) {
      		if($boarproperty->property_id == 88){
      			if($boarproperty->value > 0){
      				array_push($breederboars, $boar);
      				$bredboarproperties = $boar->getAnimalProperties();
      				foreach ($bredboarproperties as $bredboarproperty) {
      					if($bredboarproperty->property_id == 25){
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

    	return view('pigs.breederproduction', compact('pigs', 'weights45d', 'weights60d', 'weights90d', 'weights180d', 'weights45d_sd', 'weights60d_sd', 'weights90d_sd', 'weights180d_sd', 'ages_weanedsow', 'ages_weanedsow_sd', 'ages_weanedboar', 'ages_weanedboar_sd', 'ages_weanedpig', 'ages_weanedpig_sd', 'breederages', 'breeders', 'breedersowages', 'breedersows', 'breederboarages', 'breederboars', 'firstbreds', 'firstbredsows', 'firstbredsowsages', 'firstbredsowsages_sd', 'firstbredboars', 'uniqueboars', 'firstbredboarsages', 'firstbredboarsages_sd', 'firstbredages', 'firstbredages_sd', 'years'));
    }

    public function getProductionPerformancePage(){
    	$pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

    	$sows = [];
    	$boars = [];
    	foreach($pigs as $pig){
        if(substr($pig->registryid, -6, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -6, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

    	return view('pigs.productionperformance', compact('pigs', 'sows', 'boars'));
    }

    public function getBreederInventoryPage(){
    	$pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

    	$sows = [];
    	$boars = [];
    	foreach($pigs as $pig){
        if(substr($pig->registryid, -6, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -6, 1) == 'M'){
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
      foreach ($groups as $group) {
        $gproperties = $group->getGroupingProperties();
        foreach ($gproperties as $gproperty) {
          if($gproperty->property_id == 50){
            if($gproperty->value == "Pregnant"){
              $pregnant = $group->getMother()->registryid;
              array_push($pregnantsows, $pregnant);
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

      $lactating = count($bredsows) - count($pregnantsows);
      $drysows = count($sows) - (count($pregnantsows) + $lactating);

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
        if(substr($pig->registryid, -6, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -6, 1) == 'M'){
          array_push($boars, $pig);
        }
      }

      // AGES 0 TO 6 MONTHS LANG ANG ANDITO, PAG WALANG DATA, EDI WALA

    	return view('pigs.growerinventory', compact('pigs', 'sows', 'boars'));
    }

    public function getMortalityAndSalesReportPage(){
    	$dead = Animal::where("animaltype_id", 3)->where("status", "dead")->get();
    	$sold = Animal::where("animaltype_id", 3)->where("status", "sold")->get();
    	$removed = Animal::where("animaltype_id", 3)->where("status", "removed")->get();

    	$ages_dead = [];
    	$ages_sold = [];
    	$weights_sold = [];

    	foreach ($dead as $dead_pig) {
    		$properties = $dead_pig->getAnimalProperties();
    		foreach ($properties as $property) {
    			if($property->property_id == 25){
    				if($property->value != "Not specified"){
    					$bday_dead = $property->value;
    					$deadpropperties = $dead_pig->getAnimalProperties();
    					foreach ($deadpropperties as $deadproperty) {
    						if($deadproperty->property_id == 55){
    							$date_died = $deadproperty->value;
    						}
    					}
    					$age_dead = Carbon::parse($date_died)->diffInMonths(Carbon::parse($bday_dead));
    					array_push($ages_dead, $age_dead);
    				}
    			}
    		}
    	}

    	foreach ($sold as $sold_pig) {
    		$properties = $sold_pig->getAnimalProperties();
    		foreach ($properties as $property) {
    			if($property->property_id == 25){
    				if($property->value != "Not specified"){
    					$bday_sold = $property->value;
    					$soldpropperties = $sold_pig->getAnimalProperties();
    					foreach ($soldpropperties as $soldproperty) {
    						if($soldproperty->property_id == 56){
    							$date_sold = $soldproperty->value;
    						}
    					}
    					$age_sold = Carbon::parse($date_sold)->diffInMonths(Carbon::parse($bday_sold));
    					array_push($ages_sold, $age_sold);
    				}
    			}
    		}
    	}

    	foreach ($sold as $sold_pig) {
    		$properties = $sold_pig->getAnimalProperties();
    		foreach ($properties as $property) {
    			if($property->property_id == 57){
    				if($property->value != ""){
    					$weight_sold = $property->value;
    					array_push($weights_sold, $weight_sold);
    				}
    			}
    		}
    	}
	  	

    	return view('pigs.mortalityandsalesreport', compact('dead', 'sold', 'removed', 'ages_dead', 'ages_sold', 'weights_sold'));
    }

    public function getFarmProfilePage(){
      $farm = $this->user->getFarm();
      $breed = $farm->getBreed();

      return view('pigs.farmprofile', compact('farm', 'breed'));
    }

    public function getAnimalRecordPage(){
      $pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

      $sows = [];
      $boars = [];
      foreach($pigs as $pig){
        if(substr($pig->registryid, -6, 1) == 'F'){
          array_push($sows, $pig);
        }
        if(substr($pig->registryid, -6, 1) == 'M'){
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

      $date_farrowed = new GroupingProperty;
      $date_farrowed->grouping_id = $grouping->id;
      $date_farrowed->property_id = 25;
      $date_farrowed->value = $request->date_farrowed;
      $date_farrowed->datecollected = new Carbon();
      $date_farrowed->save();

      if(!is_null($request->date_farrowed) || (is_null($request->sex) && is_null($request->birth_weight))){
        if(is_null($request->date_weaned)){
          $dateWeanedValue = Carbon::parse($request->date_farrowed)->addDays(90);
        }
        else{
          $dateWeanedValue = $request->date_weaned;
        }

        $date_weaned = new GroupingProperty;
        $date_weaned->grouping_id = $grouping->id;
        $date_weaned->property_id = 61;
        $date_weaned->value = $dateWeanedValue;
        $date_weaned->datecollected = new Carbon();
        $date_weaned->save();

        // $date_weaned_individual = new AnimalProperty;
        // $date_weaned_individual->animal_id = $offspring->id;
        // $date_weaned_individual->property_id = 61;
        // $date_weaned_individual->value = $request->date_weaned;
        // $date_weaned_individual->save();
      }

      if(is_null($request->number_stillborn)){
        $noStillbornValue = 0;
      }
      else{
        $noStillbornValue = $request->number_stillborn;
      }

      $no_stillborn = new GroupingProperty;
      $no_stillborn->grouping_id = $grouping->id;
      $no_stillborn->property_id = 74;
      $no_stillborn->value = $noStillbornValue;
      $no_stillborn->datecollected = new Carbon();
      $no_stillborn->save();

      if(is_null($request->number_mummified)){
        $noMummifiedValue = 0;
      }
      else{
        $noMummifiedValue = $request->number_mummified;
      }

      $no_mummified = new GroupingProperty;
      $no_mummified->grouping_id = $grouping->id;
      $no_mummified->property_id = 75;
      $no_mummified->value = $noMummifiedValue;
      $no_mummified->datecollected = new Carbon();
      $no_mummified->save();

      // if(count($members) != 0){
      //   $tsb = new AnimalProperty;
      //   $tsb->animal_id = $offspring->id;
      //   $tsb->property_id = 77;
      //   $tsb->value = count($members);
      //   $tsb->save();

      //   $countMales = 0;
      //   $countFemales = 0;
      //   foreach ($members as $member) {
      //     if($member->getAnimalProperties()->where("property_id", 27)->first()->value == 'M'){
      //       $countMales = $countMales + 1;
      //     }
      //     elseif($member->getAnimalProperties()->where("property_id", 27)->first()->value == 'F'){
      //       $countFemales = $countFemales + 1;
      //     }
      //   }

      //   $numbermales = new AnimalProperty;
      //   $numbermales->animal_id = $offspring->id;
      //   $numbermales->property_id = 80;
      //   $numbermales->value = $countMales;
      //   $numbermales->save();

      //   $numberfemales = new AnimalProperty;
      //   $numberfemales->animal_id = $offspring->id;
      //   $numberfemales->property_id = 81;
      //   $numberfemales->value = $countFemales;
      //   $numberfemales->save();

      //   $sexratio = new AnimalProperty;
      //   $sexratio->animal_id = $offspring->id;
      //   $sexratio->property_id = 82;
      //   $sexratio->value = $countMales.':'.$countFemales;
      //   $sexratio->save();

      //   $sum = 0;
      //   $aveBirthWeight = 0;
      //   if(count($members) != 0){
      //     foreach ($members as $member) {
      //       $sum = $sum + $offspring->getAnimalProperties()->where("property_id", 53)->first()->value;
      //     }
      //     $aveBirthWeight = $sum/count($members);
      //   }
      // }

      $status = GroupingProperty::where("property_id", 50)->where("grouping_id", $grouping->id)->first();
      $status->value = "Farrowed";
      $status->save();

      $grouping->members = 1;
      $grouping->save();

      return Redirect::back()->with('message', 'Operation Successful!');
    }

    public function addWeaningWeights(Request $request){
      $grouping = Grouping::find($request->family_id);
      $offspring = Animal::where("registryid", $request->offspring_id)->first();
      // dd($request->date_weaned);

      // $date_weaned = new GroupingProperty;
      // $date_weaned->grouping_id = $grouping->id;
      // $date_weaned->property_id = 61;
      // $date_weaned->value = $request->date_weaned;
      // $date_weaned->datecollected = new Carbon();
      // $date_weaned->save();

      $date_weaned_individual = new AnimalProperty;
      $date_weaned_individual->animal_id = $offspring->id;
      $date_weaned_individual->property_id = 61;
      $date_weaned_individual->value = $grouping->getGroupingProperties()->where("property_id", 61)->first()->value;
      $date_weaned_individual->save();

      $weaningweight = new AnimalProperty;
      $weaningweight->animal_id = $offspring->id;
      $weaningweight->property_id = 54;
      $weaningweight->value = $request->weaning_weight;
      $weaningweight->save();

      return Redirect::back()->with('message', 'Operation Successful!');
    }

    public function fetchNewPigRecord(Request $request){
      $pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

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
        $dateWeanedValue = Carbon::parse($bdayValue)->addDays(60);
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
          if(substr($pig->registryid, -5, 5) == $request->mother){
            $grouping->registryid = $pig->registryid;
            $grouping->mother_id = $pig->id;
            $foundmother = 1;
          }
          if(substr($pig->registryid, -5, 5) == $request->father){
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

      $dead->status = "dead";
      $dead->save();

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

      $sold->status = "sold";
      $sold->save();

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
