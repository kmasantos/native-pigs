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
					$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "active")->get();
					$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();
					$now = Carbon::now();

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
					
					return view('pigs.dashboard', compact('user', 'farm', 'pigs', 'breeders', 'femalegrowers', 'malegrowers', 'femalebreeders', 'malebreeders', 'now'));
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
			$numberweanedprop = $family->getGroupingProperties()->where("property_id", 78)->first();
			if(is_null($numberweanedprop)){
				$number_weaned = new GroupingProperty;
				$number_weaned->grouping_id = $family->id;
				$number_weaned->property_id = 78;
				$number_weaned->value = $weaned;
				$number_weaned->datecollected = new Carbon();
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
						if($propwweight->property_id == 54){
							$weight = $propwweight->value;
							array_push($weights, $weight);
						}
					}
				}
				$sumww = array_sum($weights);
				$aveWeaningWeight = $sumww/$weaned;
			}

			return view('pigs.sowlitterrecord', compact('family', 'offsprings', 'properties', 'countMales', 'countFemales', 'aveBirthWeight', 'weaned', 'aveWeaningWeight'));
		}

		public function getBreedingRecordPage(){ // function to display Breeding Record page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$growers = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "active")->get();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();
			$family = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

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
			$now = Carbon::now();
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			return view('pigs.breedingrecord', compact('pigs', 'sows', 'boars', 'femalegrowers', 'malegrowers', 'family', 'years'));
		}

		public function getMortalityAndSalesPage(){ // function to display Mortality and Sales page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
			$growers = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "active")->get();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();

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
				if($pig->status == "removed breeder" || $pig->status == "removed grower"){
					array_push($removed, $pig);
				}
			}

			// TO FOLLOW: this will be used for filtering results
			$now = Carbon::now();
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			return view('pigs.mortalityandsales', compact('pigs', 'growers', 'breeders', 'sold', 'dead', 'removed', 'years'));
		}

		public static function getNumPigsBornOnYear($year, $filter){ // function to get number of pigs born on specific year
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder");
													})->get();

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
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder")
													->orWhere("status", "removed breeder");
													})->get();

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
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder")
													->orWhere("status", "removed breeder");
													})->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "removed breeder")->get();
			$sowsalive = [];
			$soldsows = [];
			$deadsows = [];
			$removedsows = [];
			$boarsalive = [];
			$soldboars = [];
			$deadboars = [];
			$removedboars = [];

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
					if($pigproperty->property_id == 25){ //date farrowed
						if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
							$year = Carbon::parse($pigproperty->value)->year;
							array_push($tempyears, $year);
							$years = array_reverse(array_sort(array_unique($tempyears)));
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

			return view('pigs.grossmorphoreport', compact('pigs', 'filter', 'sows', 'boars', 'curlyhairs', 'straighthairs', 'shorthairs', 'longhairs', 'blackcoats', 'nonblackcoats', 'plains', 'socks', 'concaves', 'straightheads', 'smooths', 'wrinkleds', 'droopingears', 'semilops', 'erectears', 'curlytails', 'straighttails', 'swaybacks', 'straightbacks', 'nohairtypes', 'nohairlengths', 'nocoats', 'nopatterns', 'noheadshapes', 'noskintypes', 'noeartypes', 'notailtypes', 'nobacklines', 'years', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars'));
		}

		public function filterGrossMorphologyReport(Request $request){ // function to filter Gross Morphology Report onclick
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder");
													})->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "removed breeder")->get();

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
					if($pigproperty->property_id == 25){ //date farrowed
						if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
							$year = Carbon::parse($pigproperty->value)->year;
							array_push($tempyears, $year);
							$years = array_reverse(array_sort(array_unique($tempyears)));
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

			if($filter == "Sow"){ // data displayed are for all sows
				$sowsalive = [];
				$soldsows = [];
				$deadsows = [];
				$removedsows = [];
				foreach ($sows as $sow) {
					if($sow->status == "breeder"){
						array_push($sowsalive, $sow);
					}
					elseif($sow->status == "sold breeder"){
						array_push($soldsows, $sow);
					}
					elseif($sow->status == "dead breeder"){
						array_push($deadsows, $sow);
					}
					elseif($sow->status == "removed breeder"){
						array_push($removedsows, $sow);
					}
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
				$boarsalive = [];
				$soldboars = [];
				$deadboars = [];
				$removedboars = [];
				foreach ($boars as $boar) {
					if($boar->status == "breeder"){
						array_push($boarsalive, $boar);
					}
					elseif($boar->status == "sold breeder"){
						array_push($soldboars, $boar);
					}
					elseif($boar->status == "dead breeder"){
						array_push($deadboars, $boar);
					}
					elseif($boar->status == "removed breeder"){
						array_push($removedboars, $boar);
					}
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
			return view('pigs.grossmorphoreport', compact('pigs', 'filter', 'sows', 'boars', 'curlyhairs', 'straighthairs', 'shorthairs', 'longhairs', 'blackcoats', 'nonblackcoats', 'plains', 'socks', 'concaves', 'straightheads', 'smooths', 'wrinkleds', 'droopingears', 'semilops', 'erectears', 'curlytails', 'straighttails', 'swaybacks', 'straightbacks', 'nohairtypes', 'nohairlengths', 'nocoats', 'nopatterns', 'noheadshapes', 'noskintypes', 'noeartypes', 'notailtypes', 'nobacklines', 'years', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars'));
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
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder")
													->orWhere("status", "removed breeder");
													})->get();

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
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder")
													->orWhere("status", "removed breeder");
													})->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "removed breeder")->get();
			$sowsalive = [];
			$soldsows = [];
			$deadsows = [];
			$removedsows = [];
			$boarsalive = [];
			$soldboars = [];
			$deadboars = [];
			$removedboars = [];

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
					if($pigproperty->property_id == 25){ //date farrowed
						if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
							$year = Carbon::parse($pigproperty->value)->year;
							array_push($tempyears, $year);
							$years = array_reverse(array_sort(array_unique($tempyears)));
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
			$ages_collected = [];
			foreach ($pigs as $pig) {
				$properties = $pig->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 68){ // date collected
						if($property->value != ""){
							$date_collected = $property->value;
							$bday = $pig->getAnimalProperties()->where("property_id", 25)->first()->value;
							$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday));
							array_push($ages_collected, $age);
						}
					}
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

			return view('pigs.morphocharsreport', compact('pigs', 'filter', 'sows', 'boars', 'earlengths', 'headlengths', 'snoutlengths', 'bodylengths', 'heartgirths', 'pelvicwidths', 'ponderalindices', 'taillengths', 'heightsatwithers', 'normalteats', 'earlengths_sd', 'headlengths_sd', 'snoutlengths_sd', 'bodylengths_sd', 'heartgirths_sd', 'pelvicwidths_sd', 'ponderalindices_sd', 'taillengths_sd', 'heightsatwithers_sd', 'normalteats_sd', 'years', 'ages_collected', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars'));
		}

		public function filterMorphometricCharacteristicsReport(Request $request){ // function to filter Morphometric Characteristics Report
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->orWhere("status", "dead breeder")->orWhere("status", "sold breeder")->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "removed breeder")->get();

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
					if($pigproperty->property_id == 25){ //date farrowed
						if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
							$year = Carbon::parse($pigproperty->value)->year;
							array_push($tempyears, $year);
							$years = array_reverse(array_sort(array_unique($tempyears)));
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
			$ages_collected = [];
			if($filter == "Sow"){ // data displayed are for all sows
				$sowsalive = [];
				$soldsows = [];
				$deadsows = [];
				$removedsows = [];
				foreach ($sows as $sow) {
					if($sow->status == "breeder"){
						array_push($sowsalive, $sow);
					}
					elseif($sow->status == "sold breeder"){
						array_push($soldsows, $sow);
					}
					elseif($sow->status == "dead breeder"){
						array_push($deadsows, $sow);
					}
					elseif($sow->status == "removed breeder"){
						array_push($removedsows, $sow);
					}
					$properties = $sow->getAnimalProperties();
					foreach ($properties as $property) {
						if($property->property_id == 68){ // date collected
							if($property->value != ""){
								$date_collected = $property->value;
								$bday = $sow->getAnimalProperties()->where("property_id", 25)->first()->value;
								$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday));
								array_push($ages_collected, $age);
							}
						}
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
				$boarsalive = [];
				$soldboars = [];
				$deadboars = [];
				$removedboars = [];
				foreach ($boars as $boar) {
					if($boar->status == "breeder"){
						array_push($boarsalive, $boar);
					}
					elseif($boar->status == "sold breeder"){
						array_push($soldboars, $boar);
					}
					elseif($boar->status == "dead breeder"){
						array_push($deadboars, $boar);
					}
					elseif($boar->status == "removed breeder"){
						array_push($removedboars, $boar);
					}
					$properties = $boar->getAnimalProperties();
					foreach ($properties as $property) {
						if($property->property_id == 68){ // date collected
							if($property->value != ""){
								$date_collected = $property->value;
								$bday = $boar->getAnimalProperties()->where("property_id", 25)->first()->value;
								$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday));
								array_push($ages_collected, $age);
							}
						}
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
				foreach ($pigs as $pig) {
					$properties = $pig->getAnimalProperties();
					foreach ($properties as $property) {
						if($property->property_id == 68){ // date collected
							if($property->value != ""){
								$date_collected = $property->value;
								$bday = $pig->getAnimalProperties()->where("property_id", 25)->first()->value;
								$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday));
								array_push($ages_collected, $age);
							}
						}
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

			return view('pigs.morphocharsreport', compact('pigs', 'filter', 'sows', 'boars', 'earlengths', 'headlengths', 'snoutlengths', 'bodylengths', 'heartgirths', 'pelvicwidths', 'ponderalindices', 'taillengths', 'heightsatwithers', 'normalteats', 'earlengths_sd', 'headlengths_sd', 'snoutlengths_sd', 'bodylengths_sd', 'heartgirths_sd', 'pelvicwidths_sd', 'ponderalindices_sd', 'taillengths_sd', 'heightsatwithers_sd', 'normalteats_sd', 'years', 'ages_collected', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars'));
		}

		public static function getWeightsPerYearOfBirth($year, $property_id){ // function to get weights per year of birth
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();

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

		public function getGrowthPerformanceReportPage(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();
			$growers = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "active")->get();
			$now = Carbon::now();

			//year of birth
			$years = [];
			$tempyears = [];
			foreach ($pigs as $pig) {
				$pigproperties = $pig->getAnimalProperties();
				foreach ($pigproperties as $pigproperty) {
					if($pigproperty->property_id == 25){ //date farrowed
						if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
							$year = Carbon::parse($pigproperty->value)->year;
							array_push($tempyears, $year);
							$years = array_reverse(array_sort(array_unique($tempyears)));
						}
					}
				}
			}

			// weights for all pigs
			$bweights = [];
			$wweights = [];
			$weights45d = [];
			$weights60d = [];
			$weights90d = [];
			$weights150d = [];
			$weights180d = [];
			foreach ($pigs as $pig) {
				$properties = $pig->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 53){ //birth weights
						if($property->value != ""){
							$bweight = $property->value;
							array_push($bweights, $bweight);
						}
					}
					if($property->property_id == 54){ //weaning weights
						if($property->value != ""){
							$wweight = $property->value;
							array_push($wweights, $wweight);
						}
					}
					if($property->property_id == 45){ //45d
						if($property->value != ""){
							$weight45d = $property->value;
							array_push($weights45d, $weight45d);
						}
					}
					if($property->property_id == 46){ //60d
						if($property->value != ""){
							$weight60d = $property->value;
							array_push($weights60d, $weight60d);
						}
					}
					if($property->property_id == 69){ //90d
						if($property->value != ""){
							$weight90d = $property->value;
							array_push($weights90d, $weight90d);
						}
					}
					if($property->property_id == 90){ //150d
						if($property->value != ""){
							$weight1500d = $property->value;
							array_push($weights150d, $weight150d);
						}
					}
					if($property->property_id == 47){ //180d
						if($property->value != ""){
							$weight180d = $property->value;
							array_push($weights180d, $weight180d);
						}
					}
				}
			}
			
			if($bweights != []){
				$bweights_sd = static::standardDeviation($bweights, false);
			}
			if($wweights != []){
				$wweights_sd = static::standardDeviation($wweights, false);
			}
			if($weights45d != []){
				$weights45d_sd = static::standardDeviation($weights45d, false);
			}
			if($weights60d != []){
				$weights60d_sd = static::standardDeviation($weights60d, false);
			}
			if($weights90d != []){
				$weights90d_sd = static::standardDeviation($weights90d, false);
			}
			if($weights150d != []){
				$weights150d_sd = static::standardDeviation($weights150d, false); 
			}
			if($weights180d != []){
				$weights180d_sd = static::standardDeviation($weights180d, false); 
			}

			// weights for breeders
			$bweights_breeders = [];
			$wweights_breeders = [];
			$weights45d_breeders = [];
			$weights60d_breeders = [];
			$weights90d_breeders = [];
			$weights150d_breeders = [];
			$weights180d_breeders = [];
			foreach ($breeders as $breeder) {
				$breederproperties = $breeder->getAnimalProperties();
				foreach ($breederproperties as $breederproperty) {
					if($breederproperty->property_id == 53){ //birth weights
						if($breederproperty->value != ""){
							$bweight_breeders = $breederproperty->value;
							array_push($bweights_breeders, $bweight_breeders);
						}
					}
					if($breederproperty->property_id == 54){ //weaning weights
						if($breederproperty->value != ""){
							$wweight_breeders = $breederproperty->value;
							array_push($wweights_breeders, $wweight_breeders);
						}
					}
					if($breederproperty->property_id == 45){ //45d
						if($breederproperty->value != ""){
							$weight45d_breeders = $breederproperty->value;
							array_push($weights45d_breeders, $weight45d_breeders);
						}
					}
					if($breederproperty->property_id == 46){ //60d
						if($breederproperty->value != ""){
							$weight60d_breeders = $breederproperty->value;
							array_push($weights60d_breeders, $weight60d_breeders);
						}
					}
					if($breederproperty->property_id == 69){ //90d
						if($breederproperty->value != ""){
							$weight90d_breeders = $breederproperty->value;
							array_push($weights90d_breeders, $weight90d_breeders);
						}
					}
					if($breederproperty->property_id == 90){ //150d
						if($breederproperty->value != ""){
							$weight1500d_breeders = $breederproperty->value;
							array_push($weights150d_breeders, $weight150d_breeders);
						}
					}
					if($breederproperty->property_id == 47){ //180d
						if($breederproperty->value != ""){
							$weight180d_breeders = $breederproperty->value;
							array_push($weights180d_breeders, $weight180d_breeders);
						}
					}
				}
			}
			if($bweights_breeders != []){
				$bweights_breeders_sd = static::standardDeviation($bweights_breeders, false);
			}
			if($wweights_breeders != []){
				$wweights_breeders_sd = static::standardDeviation($wweights_breeders, false);
			}
			if($weights45d_breeders != []){
				$weights45d_breeders_sd = static::standardDeviation($weights45d_breeders, false);
			}
			if($weights60d_breeders != []){
				$weights60d_breeders_sd = static::standardDeviation($weights60d_breeders, false);
			}
			if($weights90d_breeders != []){
				$weights90d_breeders_sd = static::standardDeviation($weights90d_breeders, false);
			}
			if($weights150d_breeders != []){
				$weights150d_breeders_sd = static::standardDeviation($weights150d_breeders, false); 
			}
			if($weights180d_breeders != []){
				$weights180d_breeders_sd = static::standardDeviation($weights180d_breeders, false); 
			}

			// weights for growers
			$bweights_growers = [];
			$wweights_growers = [];
			$weights45d_growers = [];
			$weights60d_growers = [];
			$weights90d_growers = [];
			$weights150d_growers = [];
			$weights180d_growers = [];
			foreach ($growers as $grower) {
				$growerproperties = $grower->getAnimalProperties();
				foreach ($growerproperties as $growerproperty) {
					if($growerproperty->property_id == 53){ //birth weights
						if($growerproperty->value != ""){
							$bweight_growers = $growerproperty->value;
							array_push($bweights_growers, $bweight_growers);
						}
					}
					if($growerproperty->property_id == 54){ //weaning weights
						if($growerproperty->value != ""){
							$wweight_growers = $growerproperty->value;
							array_push($wweights_growers, $wweight_growers);
						}
					}
					if($growerproperty->property_id == 45){ //45d
						if($growerproperty->value != ""){
							$weight45d_growers = $growerproperty->value;
							array_push($weights45d_growers, $weight45d_growers);
						}
					}
					if($growerproperty->property_id == 46){ //60d
						if($growerproperty->value != ""){
							$weight60d_growers = $growerproperty->value;
							array_push($weights60d_growers, $weight60d_growers);
						}
					}
					if($growerproperty->property_id == 69){ //90d
						if($growerproperty->value != ""){
							$weight90d_growers = $growerproperty->value;
							array_push($weights90d_growers, $weight90d_growers);
						}
					}
					if($growerproperty->property_id == 90){ //150d
						if($growerproperty->value != ""){
							$weight1500d_growers = $growerproperty->value;
							array_push($weights150d_growers, $weight150d_growers);
						}
					}
					if($growerproperty->property_id == 47){ //180d
						if($growerproperty->value != ""){
							$weight180d_growers = $growerproperty->value;
							array_push($weights180d_growers, $weight180d_growers);
						}
					}
				}
			}
			if($bweights_growers != []){
				$bweights_growers_sd = static::standardDeviation($bweights_growers, false);
			}
			if($wweights_growers != []){
				$wweights_growers_sd = static::standardDeviation($wweights_growers, false);
			}
			if($weights45d_growers != []){
				$weights45d_growers_sd = static::standardDeviation($weights45d_growers, false);
			}
			if($weights60d_growers != []){
				$weights60d_growers_sd = static::standardDeviation($weights60d_growers, false);
			}
			if($weights90d_growers != []){
				$weights90d_growers_sd = static::standardDeviation($weights90d_growers, false);
			}
			if($weights150d_growers != []){
				$weights150d_growers_sd = static::standardDeviation($weights150d_growers, false); 
			}
			if($weights180d_growers != []){
				$weights180d_growers_sd = static::standardDeviation($weights180d_growers, false); 
			}

			return view('pigs.growthperformancereport', compact('pigs', 'breeders', 'growers', 'bweights', 'wweights', 'weights45d', 'weights60d', 'weights90d', 'weights150d', 'weights180d', 'bweights_sd', 'wweights_sd', 'weights45d_sd', 'weights60d_sd', 'weights90d_sd', 'weights150d_sd', 'weights180d_sd', 'bweights_breeders', 'wweights_breeders', 'weights45d_breeders', 'weights60d_breeders', 'weights90d_breeders', 'weights150d_breeders', 'weights180d_breeders', 'bweights_breeders_sd', 'wweights_breeders_sd', 'weights45d_breeders_sd', 'weights60d_breeders_sd', 'weights90d_breeders_sd', 'weights150d_breeders_sd', 'weights180d_breeders_sd', 'bweights_growers', 'wweights_growers', 'weights45d_growers', 'weights60d_growers', 'weights90d_growers', 'weights150d_growers', 'weights180d_growers', 'bweights_growers_sd', 'wweights_growers_sd', 'weights45d_growers_sd', 'weights60d_growers_sd', 'weights90d_growers_sd', 'weights150d_growers_sd', 'weights180d_growers_sd', 'years', 'now'));
		}

		public function getBreederProductionReportPage(){ // function to display Breeder Production Report page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();

			// age at weaning
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
			$ages_weanedbreeder = [];
			foreach ($breeders as $breeder) {
				$breederproperties = $breeder->getAnimalProperties();
				foreach ($breederproperties as $breederproperty) {
					if($breederproperty->property_id == 61){ // date weaned
						if(!is_null($breederproperty->value) && $breederproperty->value != "Not specified"){
							$date_weanedbreeder = $breederproperty->value;
							$weanedbreederproperties = $breeder->getAnimalProperties();
							foreach ($weanedbreederproperties as $weanedbreederproperty) {
								if($weanedbreederproperty->property_id == 25){ // date farrowed
									if(!is_null($weanedbreederproperty->value) && $weanedbreederproperty->value != "Not specified"){
										$bday_breeder = $weanedbreederproperty->value;
									}
								}
							}
							$age_weanedbreeder = Carbon::parse($date_weanedbreeder)->diffInDays(Carbon::parse($bday_breeder));
							array_push($ages_weanedbreeder, $age_weanedbreeder);
						}
					}
				}
			}
			if($ages_weanedbreeder != []){
				$ages_weanedbreeder_sd = static::standardDeviation($ages_weanedbreeder, false);
			}

			//age at first breeding
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

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
					foreach ($duplicate_keys as $duplicate_key) { // since $duplicates is an array of arrays
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
			$herdbreeders = [];
			foreach ($breeders as $breeder) {
				$genproperties = $breeder->getAnimalProperties();
				foreach ($genproperties as $genproperty) {
					if($genproperty->property_id == 88){ // frequency
						if($genproperty->value > 0){ // used at least once
							array_push($herdbreeders, $breeder);
							$bredbreederproperties = $breeder->getAnimalProperties();
							foreach ($bredbreederproperties as $bredbreederproperty) {
								if($bredbreederproperty->property_id == 25){ // date farrowed
									if(!is_null($bredbreederproperty->value) && $bredbreederproperty->value != "Not specified"){
										$bday_breeder = $bredbreederproperty->value;
										$now = new Carbon();
										$breederage = $now->diffInMonths(Carbon::parse($bday_breeder));
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

			$months = ["December", "November", "October", "September", "August", "July", "June", "May", "April", "March", "Febraury", "January"];

			// gets unique years of age at weaning
			$years_weaning = [];
			$tempyears_weaning = [];
			foreach ($breeders as $breeder) {
				$breederproperties = $breeder->getAnimalProperties();
				foreach ($breederproperties as $breederproperty) {
					if($breederproperty->property_id == 61){ //date weaned
						if(!is_null($breederproperty->value) && $breederproperty->value != "Not specified"){
							$year_weaning = Carbon::parse($breederproperty->value)->year;
							array_push($tempyears_weaning, $year_weaning);
							$years_weaning = array_reverse(array_sort(array_unique($tempyears_weaning)));
						}
					}
				}
			}

			return view('pigs.breederproduction', compact('breeders', 'sows', 'boars', 'ages_weanedsow', 'ages_weanedsow_sd', 'ages_weanedboar', 'ages_weanedboar_sd', 'ages_weanedbreeder', 'ages_weanedbreeder_sd', 'breederages', 'herdbreeders', 'breedersowages', 'breedersows', 'breederboarages', 'breederboars', 'firstbreds', 'firstbredsows', 'firstbredsowsages', 'firstbredsowsages_sd', 'duplicates', 'firstbredboars', 'uniqueboars', 'firstbredboarsages', 'firstbredboarsages_sd', 'firstbredages', 'firstbredages_sd', 'months', 'years_weaning'));
		}

		static function getMonthlyAgeAtWeaning($year, $month, $filter){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();

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

			if($filter == "All"){
				$ages = [];
				foreach ($breeders as $breeder) {
					$breederproperties = $breeder->getAnimalProperties();
					foreach ($breederproperties as $breederproperty) {
						if($breederproperty->property_id == 61){ //date weaned
							if(!is_null($breederproperty->value) && $breederproperty->value != "Not specified"){
								$date = Carbon::parse($breederproperty->value);
								if($date->year == $year && $date->format('F') == $month){
									$weanedproperties = $breeder->getAnimalProperties();
									foreach ($weanedproperties as $weanedproperty) {
										if($weanedproperty->property_id == 25){
											if(!is_null($weanedproperty->value) && $weanedproperty->value != "Not specified"){
												$bday = Carbon::parse($weanedproperty->value);
												$age = $date->diffInDays($bday);
												array_push($ages, $age);
											}
										}
									}
									/*$bdayprop = $breeder->getAnimalProperties()->where("property_id", 25)->first(); //date farrowed
									if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
										$age = $date->diffInDays(Carbon::parse($bdayprop->value));
										array_push($ages, $age);
									}*/
								}
							}
						}
					}
				}

				return $ages;
			}
			elseif($filter == "Sow"){
				$ages = [];
				foreach ($sows as $sow) {
					$sowbreederproperties = $sow->getAnimalProperties();
					foreach ($sowbreederproperties as $sowbreederproperty) {
						if($sowbreederproperty->property_id == 61){ //date weaned
							if(!is_null($sowbreederproperty->value) && $sowbreederproperty->value != "Not specified"){
								$date = Carbon::parse($sowbreederproperty->value);
								if($date->year == $year && $date->format('F') == $month){
									$weanedproperties = $sow->getAnimalProperties();
									foreach ($weanedproperties as $weanedproperty) {
										if($weanedproperty->property_id == 25){
											if(!is_null($weanedproperty->value) && $weanedproperty->value != "Not specified"){
												$bday = Carbon::parse($weanedproperty->value);
												$age = $date->diffInDays($bday);
												array_push($ages, $age);
											}
										}
									}
									/*$bdayprop = $breeder->getAnimalProperties()->where("property_id", 25)->first(); //date farrowed
									if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
										$age = $date->diffInDays(Carbon::parse($bdayprop->value));
										array_push($ages, $age);
									}*/
								}
							}
						}
					}
				}

				return $ages;
			}
			elseif($filter == "Boar"){
				$ages = [];
				foreach ($boars as $boar) {
					$boarbreederproperties = $boar->getAnimalProperties();
					foreach ($boarbreederproperties as $boarbreederproperty) {
						if($boarbreederproperty->property_id == 61){ //date weaned
							if(!is_null($boarbreederproperty->value) && $boarbreederproperty->value != "Not specified"){
								$date = Carbon::parse($boarbreederproperty->value);
								if($date->year == $year && $date->format('F') == $month){
									$weanedproperties = $boar->getAnimalProperties();
									foreach ($weanedproperties as $weanedproperty) {
										if($weanedproperty->property_id == 25){
											if(!is_null($weanedproperty->value) && $weanedproperty->value != "Not specified"){
												$bday = Carbon::parse($weanedproperty->value);
												$age = $date->diffInDays($bday);
												array_push($ages, $age);
											}
										}
									}
									/*$bdayprop = $breeder->getAnimalProperties()->where("property_id", 25)->first(); //date farrowed
									if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
										$age = $date->diffInDays(Carbon::parse($bdayprop->value));
										array_push($ages, $age);
									}*/
								}
							}
						}
					}
				}

				return $ages;
			}
		}

		/*public static function filterProductionPerformancePerParityAjax($filter){ // function to filter production performance per parity onclick
			// $farm = $this->user->getFarm();
			// $breed = $farm->getBreed();
			$groups = Grouping::whereNotNull("mother_id")->get();

			$groupswiththisparity = [];
			foreach ($groups as $group) {
				$groupproperties = $group->getGroupingProperties();
				foreach ($groupproperties as $groupproperty) {
					if($groupproperty->property_id == 76){ //parity
						if($groupproperty->value == $filter){
							array_push($groupswiththisparity, $group);
						}
					}
				}
			}

			$lsba = [];
			$totalmales = [];
			$totalfemales = [];
			$stillborn = [];
			$mummified = [];
			$totallitterbirthweights = [];
			$avelitterbirthweights = [];
			$totallitterweaningweights = [];
			$avelitterweaningweights = [];
			$aveadjweaningweights = [];
			$totalweaned = [];
			$totalagesweaned = [];
			$preweaningmortality = [];
			foreach ($groupswiththisparity as $groupwiththisparity) {
				$thisproperties = $groupwiththisparity->getGroupingProperties();
				foreach ($thisproperties as $thisproperty) {
					if($thisproperty->property_id == 74){ // stillborn
						array_push($stillborn, $thisproperty->value);
					}
					if($thisproperty->property_id == 75){ // mummified
						array_push($mummified, $thisproperty->value);
					}
				}
				$males = [];
				$females = [];
				$litterbirthweights = [];
				$litterweaningweights = [];
				$agesweaned = [];
				$adjweaningweightsat45d = [];
				$thisoffsprings = $groupwiththisparity->getGroupingMembers();
				foreach ($thisoffsprings as $thisoffspring) {
					$thisoffspringproperties = $thisoffspring->getAnimalProperties();
					foreach ($thisoffspringproperties as $thisoffspringproperty) {
						if($thisoffspringproperty->property_id == 27){ // sex
							if($thisoffspringproperty->value == 'M'){
								array_push($males, $thisoffspring);
							}
							elseif($thisoffspringproperty->value == 'F'){
								array_push($females, $thisoffspring);
							}
						}
						if($thisoffspringproperty->property_id == 53){ // birth weight
							if(!is_null($thisoffspringproperty->value) && $thisoffspringproperty->value != ""){
								array_push($litterbirthweights, $thisoffspringproperty->value);
							}
						}
						if($thisoffspringproperty->property_id == 54){ // weaning weight
							if(!is_null($thisoffspringproperty->value) && $thisoffspringproperty->value != ""){
								array_push($litterweaningweights, $thisoffspringproperty->value);
							}
						}
						if($thisoffspringproperty->property_id == 61){ // date weaned
							if(!is_null($thisoffspringproperty->value) && $thisoffspringproperty->value != "Not specified"){
								// computes age weaned in months
								$date_weaned = $thisoffspringproperty->value;
								$thisweanedoffspringproperties = $thisoffspring->getAnimalProperties();
								foreach ($thisweanedoffspringproperties as $thisweanedoffspringproperty) {
									if($thisweanedoffspringproperty->property_id == 25){ // date farrowed
										if(!is_null($thisweanedoffspringproperty->value) && $thisweanedoffspringproperty->value != "Not specified"){
											$bday_thisoffspring = $thisweanedoffspringproperty->value;
											$thisageweaned = Carbon::parse($date_weaned)->diffInMonths(Carbon::parse($bday_thisoffspring));
											array_push($agesweaned, $thisageweaned);
										}
									}
									// computes adjused weaning weight at 45 days
									if($thisweanedoffspringproperty->property_id == 54){ // weaning weight
										if(!is_null($thisweanedoffspringproperty->value) && $thisweanedoffspringproperty->value != ""){
											// computes age weaned in days first
											$weaningweight = $thisweanedoffspringproperty->value;
											$weanedoffspringproperties = $thisoffspring->getAnimalProperties();
											foreach ($weanedoffspringproperties as $weanedoffspringproperty) {
												if($weanedoffspringproperty->property_id == 25){ // date farrowed
													if(!is_null($weanedoffspringproperty->value) && $weanedoffspringproperty->value != "Not specified"){
														$bday_offspring = $weanedoffspringproperty->value;
														$ageweaned = Carbon::parse($date_weaned)->diffInDays(Carbon::parse($bday_offspring));
														$adjweaningweightat45d = ($weaningweight*45)/$ageweaned;
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
				// adding all data to respective arrays
				array_push($totalmales, count($males));
				array_push($totalfemales, count($females));
				array_push($lsba, (count($males)+count($females)));
				if(count($litterweaningweights) != 0){
					array_push($preweaningmortality, (count($males)+count($females))-count($litterweaningweights));
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
					array_push($totalagesweaned, array_sum($agesweaned)/count($agesweaned));
				}
			}

			// standard deviation function calls
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

			return compact('stillborn', 'mummified', 'totalmales', 'totalfemales', 'lsba', 'totallitterbirthweights', 'avelitterbirthweights', 'totallitterweaningweights', 'avelitterweaningweights', 'aveadjweaningweights', 'totalagesweaned', 'totalweaned', 'preweaningmortality', 'stillborn_sd', 'mummified_sd', 'totalmales_sd', 'totalfemales_sd', 'lsba_sd', 'totallitterbirthweights_sd', 'avelitterbirthweights_sd', 'totallitterweaningweights_sd', 'avelitterweaningweights_sd', 'aveadjweaningweights_sd', 'totalagesweaned_sd', 'totalweaned_sd', 'preweaningmortality_sd', 'filter');
		}*/

		public function fetchProdPerformanceParity(Request $request){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();

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

			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

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

			$filter = $request->filter_parity;

			$groupswiththisparity = [];
			foreach ($groups as $group) {
				$groupproperties = $group->getGroupingProperties();
				foreach ($groupproperties as $groupproperty) {
					if($groupproperty->property_id == 76){ //parity
						if($groupproperty->value == $filter){
							array_push($groupswiththisparity, $group);
						}
					}
				}
			}

			$lsba = [];
			$totalmales = [];
			$totalfemales = [];
			$stillborn = [];
			$mummified = [];
			$totallitterbirthweights = [];
			$avelitterbirthweights = [];
			$totallitterweaningweights = [];
			$avelitterweaningweights = [];
			$aveadjweaningweights = [];
			$totalweaned = [];
			$totalagesweaned = [];
			$preweaningmortality = [];
			foreach ($groupswiththisparity as $groupwiththisparity) {
				$thisproperties = $groupwiththisparity->getGroupingProperties();
				foreach ($thisproperties as $thisproperty) {
					if($thisproperty->property_id == 74){ // stillborn
						array_push($stillborn, $thisproperty->value);
					}
					if($thisproperty->property_id == 75){ // mummified
						array_push($mummified, $thisproperty->value);
					}
					$males = [];
					$females = [];
					$litterbirthweights = [];
					$litterweaningweights = [];
					$agesweaned = [];
					$adjweaningweightsat45d = [];
					$thisoffsprings = $groupwiththisparity->getGroupingMembers();
					foreach ($thisoffsprings as $thisoffspring) {
						$thisoffspringproperties = $thisoffspring->getAnimalProperties();
						foreach ($thisoffspringproperties as $thisoffspringproperty) {
							if($thisoffspringproperty->property_id == 27){ // sex
								if($thisoffspringproperty->value == 'M'){
									array_push($males, $thisoffspring);
								}
								elseif($thisoffspringproperty->value == 'F'){
									array_push($females, $thisoffspring);
								}
							}
							if($thisoffspringproperty->property_id == 53){ // birth weight
								if(!is_null($thisoffspringproperty->value) && $thisoffspringproperty->value != ""){
									array_push($litterbirthweights, $thisoffspringproperty->value);
								}
							}
							if($thisoffspringproperty->property_id == 54){ // weaning weight
								if(!is_null($thisoffspringproperty->value) && $thisoffspringproperty->value != ""){
									array_push($litterweaningweights, $thisoffspringproperty->value);
								}
							}
							if($thisoffspringproperty->property_id == 61){ // date weaned
								if(!is_null($thisoffspringproperty->value) && $thisoffspringproperty->value != "Not specified"){
									// computes age weaned in months
									$date_weaned = $thisoffspringproperty->value;
									$thisweanedoffspringproperties = $thisoffspring->getAnimalProperties();
									foreach ($thisweanedoffspringproperties as $thisweanedoffspringproperty) {
										if($thisweanedoffspringproperty->property_id == 25){ // date farrowed
											if(!is_null($thisweanedoffspringproperty->value) && $thisweanedoffspringproperty->value != "Not specified"){
												$bday_thisoffspring = $thisweanedoffspringproperty->value;
												$thisageweaned = Carbon::parse($date_weaned)->diffInMonths(Carbon::parse($bday_thisoffspring));
												array_push($agesweaned, $thisageweaned);
											}
										}
										// computes adjused weaning weight at 45 days
										if($thisweanedoffspringproperty->property_id == 54){ // weaning weight
											if(!is_null($thisweanedoffspringproperty->value) && $thisweanedoffspringproperty->value != ""){
												// computes age weaned in days first
												$weaningweight = $thisweanedoffspringproperty->value;
												$weanedoffspringproperties = $thisoffspring->getAnimalProperties();
												foreach ($weanedoffspringproperties as $weanedoffspringproperty) {
													if($weanedoffspringproperty->property_id == 25){ // date farrowed
														if(!is_null($weanedoffspringproperty->value) && $weanedoffspringproperty->value != "Not specified"){
															$bday_offspring = $weanedoffspringproperty->value;
															$ageweaned = Carbon::parse($date_weaned)->diffInDays(Carbon::parse($bday_offspring));
															$adjweaningweightat45d = ($weaningweight*45)/$ageweaned;
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
				}
				// adding all data to respective arrays
				array_push($totalmales, count($males));
				array_push($totalfemales, count($females));
				array_push($lsba, (count($males)+count($females)));
				if(count($litterweaningweights) != 0){
					array_push($preweaningmortality, (count($males)+count($females))-count($litterweaningweights));
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
					array_push($totalagesweaned, array_sum($agesweaned)/count($agesweaned));
				}
			}
			// standard deviation function calls
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

			$filter_year = Carbon::now()->year;
			
			$years = [];
			$tempyears = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 25){
						if(!is_null($groupingproperty->value) && $groupingproperty->value != "Not specified"){
							$year = Carbon::parse($groupingproperty->value)->year;
							array_push($tempyears, $year);
							$years = array_sort(array_unique($tempyears));
						}
					}
				}
			}

			return view('pigs.productionperformance', compact('pigs', 'sows', 'boars', 'sowbreeders', 'boarbreeders', 'parity', 'filter', 'lsba', 'totalmales', 'totalfemales', 'stillborn', 'mummified', 'totallitterbirthweights', 'avelitterbirthweights', 'totallitterweaningweights', 'avelitterweaningweights', 'aveadjweaningweights', 'totalweaned', 'totalagesweaned', 'preweaningmortality', 'stillborn_sd', 'mummified_sd', 'totalmales_sd', 'totalfemales_sd', 'lsba_sd', 'totallitterbirthweights_sd', 'avelitterbirthweights_sd', 'totallitterweaningweights_sd', 'avelitterweaningweights_sd', 'aveadjweaningweights_sd', 'totalagesweaned_sd', 'totalweaned_sd', 'preweaningmortality_sd', 'filter_year', 'years'));
		}

		public function fetchProdPerformanceMonth(Request $request){

		}

		static function getPropertyAveragePerParity($parity, $filter){
			set_time_limit(3600);
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

			$groupswiththisparity = [];
			foreach ($groups as $group) {
				$groupproperties = $group->getGroupingProperties();
				foreach ($groupproperties as $groupproperty) {
					if($groupproperty->property_id == 76){ //parity
						if($groupproperty->value == $parity){
							array_push($groupswiththisparity, $group);
						}
					}
				}
			}

			$lsba = [];
			$totalmales = [];
			$totalfemales = [];
			$stillborn = [];
			$mummified = [];
			$totallitterbirthweights = [];
			$avelitterbirthweights = [];
			$totallitterweaningweights = [];
			$avelitterweaningweights = [];
			$aveadjweaningweights = [];
			$totalweaned = [];
			$totalagesweaned = [];
			$preweaningmortality = [];
			foreach ($groupswiththisparity as $groupwiththisparity) {
				$thisproperties = $groupwiththisparity->getGroupingProperties();
				foreach ($thisproperties as $thisproperty) {
					if($thisproperty->property_id == 74){ // stillborn
						array_push($stillborn, $thisproperty->value);
					}
					if($thisproperty->property_id == 75){ // mummified
						array_push($mummified, $thisproperty->value);
					}
					$males = [];
					$females = [];
					$litterbirthweights = [];
					$litterweaningweights = [];
					$agesweaned = [];
					$adjweaningweightsat45d = [];
					$thisoffsprings = $groupwiththisparity->getGroupingMembers();
					foreach ($thisoffsprings as $thisoffspring) {
						$thisoffspringproperties = $thisoffspring->getAnimalProperties();
						foreach ($thisoffspringproperties as $thisoffspringproperty) {
							if($thisoffspringproperty->property_id == 27){ // sex
								if($thisoffspringproperty->value == 'M'){
									array_push($males, $thisoffspring);
								}
								elseif($thisoffspringproperty->value == 'F'){
									array_push($females, $thisoffspring);
								}
							}
							if($thisoffspringproperty->property_id == 53){ // birth weight
								if(!is_null($thisoffspringproperty->value) && $thisoffspringproperty->value != ""){
									array_push($litterbirthweights, $thisoffspringproperty->value);
								}
							}
							if($thisoffspringproperty->property_id == 54){ // weaning weight
								if(!is_null($thisoffspringproperty->value) && $thisoffspringproperty->value != ""){
									array_push($litterweaningweights, $thisoffspringproperty->value);
								}
							}
							if($thisoffspringproperty->property_id == 61){ // date weaned
								if(!is_null($thisoffspringproperty->value) && $thisoffspringproperty->value != "Not specified"){
									// computes age weaned in months
									$date_weaned = $thisoffspringproperty->value;
									$thisweanedoffspringproperties = $thisoffspring->getAnimalProperties();
									foreach ($thisweanedoffspringproperties as $thisweanedoffspringproperty) {
										if($thisweanedoffspringproperty->property_id == 25){ // date farrowed
											if(!is_null($thisweanedoffspringproperty->value) && $thisweanedoffspringproperty->value != "Not specified"){
												$bday_thisoffspring = $thisweanedoffspringproperty->value;
												$thisageweaned = Carbon::parse($date_weaned)->diffInMonths(Carbon::parse($bday_thisoffspring));
												array_push($agesweaned, $thisageweaned);
											}
										}
										// computes adjused weaning weight at 45 days
										if($thisweanedoffspringproperty->property_id == 54){ // weaning weight
											if(!is_null($thisweanedoffspringproperty->value) && $thisweanedoffspringproperty->value != ""){
												// computes age weaned in days first
												$weaningweight = $thisweanedoffspringproperty->value;
												$weanedoffspringproperties = $thisoffspring->getAnimalProperties();
												foreach ($weanedoffspringproperties as $weanedoffspringproperty) {
													if($weanedoffspringproperty->property_id == 25){ // date farrowed
														if(!is_null($weanedoffspringproperty->value) && $weanedoffspringproperty->value != "Not specified"){
															$bday_offspring = $weanedoffspringproperty->value;
															$ageweaned = Carbon::parse($date_weaned)->diffInDays(Carbon::parse($bday_offspring));
															$adjweaningweightat45d = ($weaningweight*45)/$ageweaned;
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
				}
				// adding all data to respective arrays
				array_push($totalmales, count($males));
				array_push($totalfemales, count($females));
				array_push($lsba, (count($males)+count($females)));
				if(count($litterweaningweights) != 0){
					array_push($preweaningmortality, (count($males)+count($females))-count($litterweaningweights));
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
					array_push($totalagesweaned, array_sum($agesweaned)/count($agesweaned));
				}
			}

			if($filter == "lsba"){
				return round(array_sum($lsba)/count($lsba), 2);
			}
			elseif($filter == "number of males"){
				return round(array_sum($totalmales)/count($totalmales), 2);
			}
			elseif($filter == "number of females"){
				return round(array_sum($totalfemales)/count($totalfemales), 2);
			}
			elseif($filter == "stillborn"){
				return round(array_sum($stillborn)/count($stillborn), 2);
			}
			elseif($filter == "mummified"){
				return round(array_sum($mummified)/count($mummified), 2);
			}
			elseif($filter == "birth weight"){
				return round(array_sum($totallitterbirthweights)/count($totallitterbirthweights), 2);
			}
			elseif($filter == "ave birth weight"){
				return round(array_sum($avelitterbirthweights)/count($avelitterbirthweights), 2);
			}
			elseif($filter == "weaning weight"){
				return round(array_sum($totallitterweaningweights)/count($totallitterweaningweights), 2);
			}
			elseif($filter == "ave weaning weight"){
				return round(array_sum($avelitterweaningweights)/count($avelitterweaningweights), 2);
			}
			elseif($filter == "adj weaning weight"){
				return round(array_sum($aveadjweaningweights)/count($aveadjweaningweights), 2);
			}
			elseif($filter == "number weaned"){
				return round(array_sum($totalweaned)/count($totalweaned), 2);
			}
			elseif($filter == "age weaned"){
				return round(array_sum($totalagesweaned)/count($totalagesweaned), 2);
			}
			elseif($filter == "preweaning mortality"){
				return round(array_sum($preweaningmortality)/count($preweaningmortality), 2);
			}
		

		}

		public function getProductionPerformancePage(Request $request){ // function to display Production Performace page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();

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
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

			/*** PER PARITY ***/
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

			// default filter
			$filter = 1;

			$groupswiththisparity = [];
			foreach ($groups as $group) {
				$groupproperties = $group->getGroupingProperties();
				foreach ($groupproperties as $groupproperty) {
					if($groupproperty->property_id == 76){ //parity
						if($groupproperty->value == $filter){
							array_push($groupswiththisparity, $group);
						}
					}
				}
			}

			$lsba = [];
			$totalmales = [];
			$totalfemales = [];
			$stillborn = [];
			$mummified = [];
			$totallitterbirthweights = [];
			$avelitterbirthweights = [];
			$totallitterweaningweights = [];
			$avelitterweaningweights = [];
			$aveadjweaningweights = [];
			$totalweaned = [];
			$totalagesweaned = [];
			$preweaningmortality = [];
			foreach ($groupswiththisparity as $groupwiththisparity) {
				$thisproperties = $groupwiththisparity->getGroupingProperties();
				foreach ($thisproperties as $thisproperty) {
					if($thisproperty->property_id == 74){ // stillborn
						array_push($stillborn, $thisproperty->value);
					}
					if($thisproperty->property_id == 75){ // mummified
						array_push($mummified, $thisproperty->value);
					}
					$males = [];
					$females = [];
					$litterbirthweights = [];
					$litterweaningweights = [];
					$agesweaned = [];
					$adjweaningweightsat45d = [];
					$thisoffsprings = $groupwiththisparity->getGroupingMembers();
					foreach ($thisoffsprings as $thisoffspring) {
						$thisoffspringproperties = $thisoffspring->getAnimalProperties();
						foreach ($thisoffspringproperties as $thisoffspringproperty) {
							if($thisoffspringproperty->property_id == 27){ // sex
								if($thisoffspringproperty->value == 'M'){
									array_push($males, $thisoffspring);
								}
								elseif($thisoffspringproperty->value == 'F'){
									array_push($females, $thisoffspring);
								}
							}
							if($thisoffspringproperty->property_id == 53){ // birth weight
								if(!is_null($thisoffspringproperty->value) && $thisoffspringproperty->value != ""){
									array_push($litterbirthweights, $thisoffspringproperty->value);
								}
							}
							if($thisoffspringproperty->property_id == 54){ // weaning weight
								if(!is_null($thisoffspringproperty->value) && $thisoffspringproperty->value != ""){
									array_push($litterweaningweights, $thisoffspringproperty->value);
								}
							}
							if($thisoffspringproperty->property_id == 61){ // date weaned
								if(!is_null($thisoffspringproperty->value) && $thisoffspringproperty->value != "Not specified"){
									// computes age weaned in months
									$date_weaned = $thisoffspringproperty->value;
									$thisweanedoffspringproperties = $thisoffspring->getAnimalProperties();
									foreach ($thisweanedoffspringproperties as $thisweanedoffspringproperty) {
										if($thisweanedoffspringproperty->property_id == 25){ // date farrowed
											if(!is_null($thisweanedoffspringproperty->value) && $thisweanedoffspringproperty->value != "Not specified"){
												$bday_thisoffspring = $thisweanedoffspringproperty->value;
												$thisageweaned = Carbon::parse($date_weaned)->diffInMonths(Carbon::parse($bday_thisoffspring));
												array_push($agesweaned, $thisageweaned);
											}
										}
										// computes adjused weaning weight at 45 days
										if($thisweanedoffspringproperty->property_id == 54){ // weaning weight
											if(!is_null($thisweanedoffspringproperty->value) && $thisweanedoffspringproperty->value != ""){
												// computes age weaned in days first
												$weaningweight = $thisweanedoffspringproperty->value;
												$weanedoffspringproperties = $thisoffspring->getAnimalProperties();
												foreach ($weanedoffspringproperties as $weanedoffspringproperty) {
													if($weanedoffspringproperty->property_id == 25){ // date farrowed
														if(!is_null($weanedoffspringproperty->value) && $weanedoffspringproperty->value != "Not specified"){
															$bday_offspring = $weanedoffspringproperty->value;
															$ageweaned = Carbon::parse($date_weaned)->diffInDays(Carbon::parse($bday_offspring));
															$adjweaningweightat45d = ($weaningweight*45)/$ageweaned;
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
				}
				// adding all data to respective arrays
				array_push($totalmales, count($males));
				array_push($totalfemales, count($females));
				array_push($lsba, (count($males)+count($females)));
				if(count($litterweaningweights) != 0){
					array_push($preweaningmortality, (count($males)+count($females))-count($litterweaningweights));
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
					array_push($totalagesweaned, array_sum($agesweaned)/count($agesweaned));
				}
			}
			// standard deviation function calls
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

			/*** PER YEAR & MONTH ***/
			$years = [];
			$tempyears = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 25){
						if(!is_null($groupingproperty->value) && $groupingproperty->value != "Not specified"){
							$year = Carbon::parse($groupingproperty->value)->year;
							array_push($tempyears, $year);
							$years = array_sort(array_unique($tempyears));
						}
					}
				}
			}

			$filter_year = Carbon::now()->year;

			$groupswiththisyear = [];


			return view('pigs.productionperformance', compact('pigs', 'sows', 'boars', 'sowbreeders', 'boarbreeders', 'parity', 'filter', 'lsba', 'totalmales', 'totalfemales', 'stillborn', 'mummified', 'totallitterbirthweights', 'avelitterbirthweights', 'totallitterweaningweights', 'avelitterweaningweights', 'aveadjweaningweights', 'totalweaned', 'totalagesweaned', 'preweaningmortality', 'stillborn_sd', 'mummified_sd', 'totalmales_sd', 'totalfemales_sd', 'lsba_sd', 'totallitterbirthweights_sd', 'avelitterbirthweights_sd', 'totallitterweaningweights_sd', 'avelitterweaningweights_sd', 'aveadjweaningweights_sd', 'totalagesweaned_sd', 'totalweaned_sd', 'preweaningmortality_sd', 'years', 'filter_year'));
		}

		public function getSowProductionPerformancePage($id){ // function to display Sow Production Performance page
			$sow = Animal::find($id);
			$properties = $sow->getAnimalProperties();
			$groups = Grouping::where("mother_id", $sow->id)->get();

			$usage = [];
			$count = 1;
			$temp = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 48){ //date bred
						$date = $groupingproperty->value;
						array_push($temp, $date);
					}
				}
			}
			$usage = array_sort($temp);

			return view('pigs.sowproductionperformance', compact('sow', 'properties', 'usage'));
		}

		static function getGroupingPerParity($sow_id, $usage, $filter){
			$groups = Grouping::where("mother_id", $sow_id)->get();

			foreach ($groups as $group) {
				$properties = $group->getGroupingProperties();
				foreach ($properties as $property) {
					if($property->property_id == 48){
						if($property->value == $usage){
							$groupperusage = $group;
						}
					}
				}
			}

			if($filter == "Boar Used"){
				return $groupperusage->getFather()->registryid;
			}
			elseif($filter == "Parity"){
				if(is_null($groupperusage->getGroupingProperties()->where("property_id", 76)->first())){
					return 0;
				}
				else{
					return $groupperusage->getGroupingProperties()->where("property_id", 76)->first()->value;
				}
			}
			elseif($filter == "Status"){
				return $groupperusage->getGroupingProperties()->where("property_id", 50)->first()->value;
			}
			elseif($filter == "Group ID"){
				return $groupperusage->id;
			}
		}

		public function getSowProductionPerformancePerParityPage($id){
			$group = Grouping::find($id);
			$groupingproperties = $group->getGroupingProperties();

			foreach ($groupingproperties as $groupingproperty) {
				if($groupingproperty->property_id == 76){ //parity
					$parity = $groupingproperty->value;
				}
				if($groupingproperty->property_id == 74){ //number stillborn
					$stillborn = $groupingproperty->value;
				}
				if($groupingproperty->property_id == 75){ //number mummified
					$mummified = $groupingproperty->value;
				}
			}

			$males = [];
			$females = [];
			$litterbirthweights = [];
			$litterweaningweights = [];
			$adjweaningweights = [];
			$agesweaned = [];
			
			$offsprings = $group->getGroupingMembers();
			foreach ($offsprings as $offspring) {
				$offspringproperties = $offspring->getAnimalProperties();
				foreach ($offspringproperties as $offspringproperty) {
					if($offspringproperty->property_id == 27){ //sex
						if($offspringproperty->value == "M"){
							array_push($males, $offspring);
						}
						elseif($offspringproperty->value == "F"){
							array_push($females, $offspring);
						}
					}
					if($offspringproperty->property_id == 53){ //birth weight
						if($offspringproperty->value != ""){
							array_push($litterbirthweights, $offspringproperty->value);
						}
					}
					if($offspringproperty->property_id == 54){ //weaning weight
						if($offspringproperty->value != ""){
							array_push($litterweaningweights, $offspringproperty->value);
						}
					}
					if($offspringproperty->property_id == 61){ //date weaned
						if($offspringproperty->value != "Not specified"){
							$date_weaned = Carbon::parse($offspringproperty->value);
							$bday = $offspring->getAnimalProperties()->where("property_id", 25)->first()->value;
							$age = $date_weaned->diffInDays(Carbon::parse($bday));
							array_push($agesweaned, $age);
							$weaningweight = $offspring->getAnimalProperties()->where("property_id", 54)->first()->value;
							$adjweaningweightat45d = ($weaningweight*45)/$age;
							array_push($adjweaningweights, $adjweaningweightat45d);
						}
					}
				}
			}
			$lsba = count($males) + count($females);
			$numberweaned = count($litterweaningweights);
			$preweaningmortality = $lsba - $numberweaned;
			if($litterbirthweights != []){
				$avebirthweight = round(array_sum($litterbirthweights)/count($litterbirthweights), 2);
			}
			else{
				$avebirthweight = "No data available";
			}
			if($litterweaningweights != []){
				$aveweaningweight = round(array_sum($litterweaningweights)/count($litterweaningweights), 2);
			}
			else{
				$aveweaningweight = "No data available";
			}
			if($adjweaningweights != []){
				$aveadjweaningweights = round(array_sum($adjweaningweights)/count($adjweaningweights), 2);
			}
			else{
				$aveadjweaningweights = "No data available";
			}
			if($agesweaned != []){
				$aveageweaned = round(array_sum($agesweaned)/$numberweaned, 2);
			}
			else{
				$aveageweaned = "No data available";
			}
			

			return view('pigs.sowproductionperformanceperparity', compact('group', 'parity', 'stillborn', 'mummified', 'lsba', 'males', 'females', 'litterbirthweights', 'avebirthweight', 'litterweaningweights', 'aveweaningweight', 'aveadjweaningweights', 'numberweaned', 'aveageweaned', 'preweaningmortality'));
		}

		public function getBoarProductionPerformancePage($id){ // function to display Boar Production Performance page
			$boar = Animal::find($id);
			$properties = $boar->getAnimalProperties();
			$groups = Grouping::where("father_id", $boar->id)->get();

			$services = [];
			$count = 1;
			$temp = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 48){ //date bred
						$date = $groupingproperty->value;
						array_push($temp, $date);
					}
				}
			}
			$services = array_sort($temp);

			return view('pigs.boarproductionperformance', compact('boar', 'properties', 'services', 'count'));
		}

		static function getGroupingPerService($boar_id, $service, $filter){
			$groups = Grouping::where("father_id", $boar_id)->get();

			foreach ($groups as $group) {
				$properties = $group->getGroupingProperties();
				foreach ($properties as $property) {
					if($property->property_id == 48){
						if($property->value == $service){
							$groupperservice = $group;
						}
					}
				}
			}

			if($filter == "Sow Used"){
				return $groupperservice->getMother()->registryid;
			}
			elseif($filter == "Status"){
				return $groupperservice->getGroupingProperties()->where("property_id", 50)->first()->value;
			}
		}

		public function getBoarProductionPerformancePerServicePage($id){
			$group = Grouping::find($id);
			$groupingproperties = $group->getGroupingProperties();

			foreach ($groupingproperties as $groupingproperty) {
				if($groupingproperty->property_id == 74){ //number stillborn
					$stillborn = $groupingproperty->value;
				}
				if($groupingproperty->property_id == 75){ //number mummified
					$mummified = $groupingproperty->value;
				}
			}

			$males = [];
			$females = [];
			$litterbirthweights = [];
			$litterweaningweights = [];
			$adjweaningweights = [];
			$agesweaned = [];
			
			$offsprings = $group->getGroupingMembers();
			foreach ($offsprings as $offspring) {
				$offspringproperties = $offspring->getAnimalProperties();
				foreach ($offspringproperties as $offspringproperty) {
					if($offspringproperty->property_id == 27){ //sex
						if($offspringproperty->value == "M"){
							array_push($males, $offspring);
						}
						elseif($offspringproperty->value == "F"){
							array_push($females, $offspring);
						}
					}
					if($offspringproperty->property_id == 53){ //birth weight
						if($offspringproperty->value != ""){
							array_push($litterbirthweights, $offspringproperty->value);
						}
					}
					if($offspringproperty->property_id == 54){ //weaning weight
						if($offspringproperty->value != ""){
							array_push($litterweaningweights, $offspringproperty->value);
						}
					}
					if($offspringproperty->property_id == 61){ //date weaned
						if($offspringproperty->value != "Not specified"){
							$date_weaned = Carbon::parse($offspringproperty->value);
							$bday = $offspring->getAnimalProperties()->where("property_id", 25)->first()->value;
							$age = $date_weaned->diffInDays(Carbon::parse($bday));
							array_push($agesweaned, $age);
							$weaningweight = $offspring->getAnimalProperties()->where("property_id", 54)->first()->value;
							$adjweaningweightat45d = ($weaningweight*45)/$age;
							array_push($adjweaningweights, $adjweaningweightat45d);
						}
					}
				}
			}
			$lsba = count($males) + count($females);
			$numberweaned = count($litterweaningweights);
			$preweaningmortality = $lsba - $numberweaned;
			if($litterbirthweights != []){
				$avebirthweight = round(array_sum($litterbirthweights)/count($litterbirthweights), 2);
			}
			else{
				$avebirthweight = "No data available";
			}
			if($litterweaningweights != []){
				$aveweaningweight = round(array_sum($litterweaningweights)/count($litterweaningweights), 2);
			}
			else{
				$aveweaningweight = "No data available";
			}
			if($adjweaningweights != []){
				$aveadjweaningweights = round(array_sum($adjweaningweights)/count($adjweaningweights), 2);
			}
			else{
				$aveadjweaningweights = "No data available";
			}
			if($agesweaned != []){
				$aveageweaned = round(array_sum($agesweaned)/$numberweaned, 2);
			}
			else{
				$aveageweaned = "No data available";
			}
			

			return view('pigs.boarproductionperformanceperservice', compact('group', 'parity', 'stillborn', 'mummified', 'lsba', 'males', 'females', 'litterbirthweights', 'avebirthweight', 'litterweaningweights', 'aveweaningweight', 'aveadjweaningweights', 'numberweaned', 'aveageweaned', 'preweaningmortality'));
		}

		public function getBreederInventoryPage(){ // function to display Breeder Inventory page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();
			$now = Carbon::now();

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

			// gets all groups available
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

			// BOAR INVENTORY
			foreach ($boars as $boar) {	// adds frequency of boar service
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
			
			// sorts male pigs into jr and sr boars
			$jrboars = []; // less than 1 year old
			$srboars = []; // at least 1 year old
			$noage = [];
			foreach ($boars as $boar) {
				$iproperties = $boar->getAnimalProperties();
				foreach ($iproperties as $iproperty) {
					if($iproperty->property_id == 25){ // date farrowed
						if(!is_null($iproperty->value) && $iproperty->value != "Not specified"){
							$end_date = Carbon::parse($iproperty->value);
							$age = $now->diffInMonths($end_date);
							if($age < 12){
								array_push($jrboars, $boar);
							}
							else{
								array_push($srboars, $boar);
							}
						}
						else{
							array_push($noage, $boar);
						}
					}
				}
			}

			// SOW INVENTORY
			$breds = [];
			$pregnantsows = [];
			$lactatingsows = [];
			foreach ($groups as $group) {
				$gproperties = $group->getGroupingProperties();
				foreach ($gproperties as $gproperty) {
					if($gproperty->property_id == 48){ // date bred
						if(Carbon::parse($gproperty->value)->month == $now->month && Carbon::parse($gproperty->value)->year == $now->year){
							if(Carbon::parse($gproperty->value)->lte($now)){
								$bred = $group->getMother();
								if($bred->status == "breeder"){
									array_push($breds, $bred);
								}
							}
						}
						if($now->gte(Carbon::parse($gproperty->value))){
							if($group->getGroupingProperties()->where("property_id", 50)->first()->value == "Pregnant"){
								$pregnant = $group->getMother();
								if($pregnant->status == "breeder"){
									array_push($pregnantsows, $pregnant);
								}
							}
						}
					}
					if($gproperty->property_id == 25){ // date farrowed
						if($now->gte(Carbon::parse($gproperty->value)) && $now->lte(Carbon::parse($gproperty->value)->addDays(100))){ // some farms wean their pigs as late as 100 days
							$lactating = $group->getMother();
							if($lactating->status == "breeder"){
								array_push($lactatingsows, $lactating);
							}
						}
					}
				}
			}
			$drysows = count($sows) - (count($breds) + count($pregnantsows) + count($lactatingsows));
			foreach ($sows as $sow) { // adds frequency of sow usage
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
			// sorts female pigs into gilts and sows which were bred at least once
			$gilts = [];
			$bredsows = [];
			foreach ($sows as $sow) {
				$iproperties = $sow->getAnimalProperties();
				foreach ($iproperties as $iproperty) {
					if($iproperty->property_id == 88){ // frequency
						if($iproperty->value == 0){
							array_push($gilts, $sow);
						}
					}
				}
			}

			return view('pigs.breederinventory', compact('pigs', 'sows', 'boars', 'groups', 'frequency', 'breds', 'pregnantsows', 'lactatingsows', 'drysows', 'gilts', 'jrboars', 'srboars', 'now', 'noage'));
		}

		public function getSowUsagePage($id){ // function to display Sow Usage page
			$sow = Animal::find($id);

			$groups = Grouping::whereNotNull("mother_id")->where("mother_id", $sow->id)->get();

			return view('pigs.sowusage', compact('sow', 'groups'));
		}

		public function getBoarUsagePage($id){ // function to display Boar Usage page
			$boar = Animal::find($id);

			$groups = Grouping::whereNotNull("mother_id")->where("father_id", $boar->id)->get();

			return view('pigs.boarusage', compact('boar', 'groups'));
		}

		public function getGrowerInventoryPage(){ // function to display Grower Inventory page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "active")->get();

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

			$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			$index = 0;

			// default filter is the current year
			$now = Carbon::now();
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			$filter = $now->year;

			// gets all the last day of each month
			$dates = [];
			foreach ($months as $month) {
				$date = new Carbon('last day of '.$month.' '.$filter);
				array_push($dates, $date);
			}

			// gets count of female growers per age per month
			$monthlysows = [];
			foreach ($dates as $date) {
				$sows0 = [];
				$sows1 = [];
				$sows2 = [];
				$sows3 = [];
				$sows4 = [];
				$sows5 = [];
				$sows6 = [];
				$sowsg6 = [];
				foreach ($sows as $sow) {
					$sowproperties = $sow->getAnimalProperties();
					foreach ($sowproperties as $sowproperty) {
						if($sowproperty->property_id == 25){ //date farrowed
							if(!is_null($sowproperty->value) && $sowproperty->value != "Not specified" && $date->gt(Carbon::parse($sowproperty->value))){
								$bday = $sowproperty->value;
								$age = Carbon::parse($date)->diffInMonths(Carbon::parse($bday));

								if($age == 0){
									array_push($sows0, $sow);
								}
								elseif($age == 1){
									array_push($sows1, $sow);
								}
								elseif($age == 2){
									array_push($sows2, $sow);	
								}
								elseif($age == 3){
									array_push($sows3, $sow);
								}
								elseif($age == 4){
									array_push($sows4, $sow);
								}
								elseif($age == 5){
									array_push($sows5, $sow);
								}
								elseif($age == 6){
									array_push($sows6, $sow);
								}
								elseif($age > 6){
									array_push($sowsg6, $sow);
								}
							}
						}
					}
				}
				array_push($monthlysows, [count($sows0), count($sows1), count($sows2), count($sows3), count($sows4), count($sows5), count($sows6), count($sowsg6)]);
			}
			$monthlysows = array_values($monthlysows);

			// gets count of male growers per age per month
			$monthlyboars = [];
			foreach ($dates as $date) {
				$boars0 = [];
				$boars1 = [];
				$boars2 = [];
				$boars3 = [];
				$boars4 = [];
				$boars5 = [];
				$boars6 = [];
				$boarsg6 = [];
				foreach ($boars as $boar) {
					$boarproperties = $boar->getAnimalProperties();
					foreach ($boarproperties as $boarproperty) {
						if($boarproperty->property_id == 25){ //date farrowedf
							if(!is_null($boarproperty->value) && $boarproperty->value != "Not specified" && $date->gt(Carbon::parse($boarproperty->value))){
								$bday = $boarproperty->value;
								$age = Carbon::parse($date)->diffInMonths(Carbon::parse($bday));

								if($age == 0){
									array_push($boars0, $boar);
								}
								elseif($age == 1){
									array_push($boars1, $boar);
								}
								elseif($age == 2){
									array_push($boars2, $boar);	
								}
								elseif($age == 3){
									array_push($boars3, $boar);
								}
								elseif($age == 4){
									array_push($boars4, $boar);
								}
								elseif($age == 5){
									array_push($boars5, $boar);
								}
								elseif($age == 6){
									array_push($boars6, $boar);
								}
								elseif($age > 6){
									array_push($boarsg6, $boar);
								}
							}
						}
					}
				}
				array_push($monthlyboars, [count($boars0), count($boars1), count($boars2), count($boars3), count($boars4), count($boars5), count($boars6), count($boarsg6)]);
			}
			$monthlyboars = array_values($monthlyboars);

			return view('pigs.growerinventory', compact('pigs', 'sows', 'boars', 'months', 'index', 'years', 'filter', 'monthlysows', 'monthlyboars', 'now'));
		}

		public function filterGrowerInventory(Request $request){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "active")->get();

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

			$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			$index = 0;

			$now = Carbon::now();

			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			$filter = $request->year_grower_inventory;

			// gets all the last day of each month
			$dates = [];
			foreach ($months as $month) {
				$date = new Carbon('last day of '.$month.' '.$filter);
				array_push($dates, $date);
			}

			// gets count of female growers per age per month
			$monthlysows = [];
			foreach ($dates as $date) {
				$sows0 = [];
				$sows1 = [];
				$sows2 = [];
				$sows3 = [];
				$sows4 = [];
				$sows5 = [];
				$sows6 = [];
				$sowsg6 = [];
				foreach ($sows as $sow) {
					$sowproperties = $sow->getAnimalProperties();
					foreach ($sowproperties as $sowproperty) {
						if($sowproperty->property_id == 25){
							if(!is_null($sowproperty->value) && $sowproperty->value != "Not specified" && $date->gt(Carbon::parse($sowproperty->value))){
								$bday = $sowproperty->value;
								$age = Carbon::parse($date)->diffInMonths(Carbon::parse($bday));

								if($age == 0){
									array_push($sows0, $sow);
								}
								elseif($age == 1){
									array_push($sows1, $sow);
								}
								elseif($age == 2){
									array_push($sows2, $sow);	
								}
								elseif($age == 3){
									array_push($sows3, $sow);
								}
								elseif($age == 4){
									array_push($sows4, $sow);
								}
								elseif($age == 5){
									array_push($sows5, $sow);
								}
								elseif($age == 6){
									array_push($sows6, $sow);
								}
								elseif($age > 6){
									array_push($sowsg6, $sow);
								}
							}
						}
					}
				}
				array_push($monthlysows, [count($sows0), count($sows1), count($sows2), count($sows3), count($sows4), count($sows5), count($sows6), count($sowsg6)]);
			}
			$monthlysows = array_values($monthlysows);

			// gets count of male growers per age per month
			$monthlyboars = [];
			foreach ($dates as $date) {
				$boars0 = [];
				$boars1 = [];
				$boars2 = [];
				$boars3 = [];
				$boars4 = [];
				$boars5 = [];
				$boars6 = [];
				$boarsg6 = [];
				foreach ($boars as $boar) {
					$boarproperties = $boar->getAnimalProperties();
					foreach ($boarproperties as $boarproperty) {
						if($boarproperty->property_id == 25){
							if(!is_null($boarproperty->value) && $boarproperty->value != "Not specified" && $date->gt(Carbon::parse($boarproperty->value))){
								$bday = $boarproperty->value;
								$age = Carbon::parse($date)->diffInMonths(Carbon::parse($bday));

								if($age == 0){
									array_push($boars0, $boar);
								}
								elseif($age == 1){
									array_push($boars1, $boar);
								}
								elseif($age == 2){
									array_push($boars2, $boar);	
								}
								elseif($age == 3){
									array_push($boars3, $boar);
								}
								elseif($age == 4){
									array_push($boars4, $boar);
								}
								elseif($age == 5){
									array_push($boars5, $boar);
								}
								elseif($age == 6){
									array_push($boars6, $boar);
								}
								elseif($age > 6){
									array_push($boarsg6, $boar);
								}
							}
						}
					}
				}
				array_push($monthlyboars, [count($boars0), count($boars1), count($boars2), count($boars3), count($boars4), count($boars5), count($boars6), count($boarsg6)]);
			}
			$monthlyboars = array_values($monthlyboars);


			return view('pigs.growerinventory', compact('pigs', 'sows', 'boars', 'months', 'index', 'years', 'filter', 'monthlysows', 'monthlyboars', 'now'));
		}

		public function getMortalityAndSalesReportPage(){ // function to display Mortality and Sales Report page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
			$now = Carbon::now();

			// sorts pigs by status
			$dead_growers = [];
			$currentdeadgrowers = [];
			$dead_breeders = [];
			$currentdeadbreeders = [];
			$sold_growers = [];
			$currentsoldgrowers = [];
			$sold_breeders = [];
			$currentsoldbreeders = [];
			$removed = [];
			$currentremoved = [];
			foreach ($pigs as $pig) {
				if($pig->status == "dead grower"){
					array_push($dead_growers, $pig);
					$date_died = Carbon::parse($pig->getAnimalProperties()->where("property_id", 55)->first()->value);
					if($date_died->month == $now->month && $date_died->year == $now->year){
						if($date_died->lte($now)){
							array_push($currentdeadgrowers, $pig);
						}
					}
				}
				elseif($pig->status == "dead breeder"){
					array_push($dead_breeders, $pig);
					$date_died = Carbon::parse($pig->getAnimalProperties()->where("property_id", 55)->first()->value);
					if($date_died->month == $now->month && $date_died->year == $now->year){
						if($date_died->lte($now)){
							array_push($currentdeadbreeders, $pig);
						}
					}
				}
				elseif($pig->status == "sold grower"){
					array_push($sold_growers, $pig);
					$date_sold = Carbon::parse($pig->getAnimalProperties()->where("property_id", 56)->first()->value);
					if($date_sold->month == $now->month && $date_sold->year == $now->year){
						if($date_sold->lte($now)){
							array_push($currentsoldgrowers, $pig);
						}
					}
				}
				elseif($pig->status == "sold breeder"){
					array_push($sold_breeders, $pig);
					$date_sold = Carbon::parse($pig->getAnimalProperties()->where("property_id", 56)->first()->value);
					if($date_sold->month == $now->month && $date_sold->year == $now->year){
						if($date_sold->lte($now)){
							array_push($currentsoldbreeders, $pig);
						}
					}
				}
				elseif($pig->status == "removed"){
					array_push($removed, $pig);
					$date_removed = Carbon::parse($pig->getAnimalProperties()->where("property_id", 72)->first()->value);
					if($date_removed->month == $now->month && $date_removed->year == $now->year){
						if($date_removed->lte($now)){
							array_push($currentremoved, $pig);
						}
					}
				}
			}

			$ages_dead = [];
			$ages_currentsoldbreeder = [];
			$ages_currentsoldgrower = [];
			$weights_currentsoldbreeder = [];
			$weights_currentsoldgrower = [];
			//mortality
			foreach ($currentdeadgrowers as $currentdeadgrower) { // gets ages of dead growers
				$properties = $currentdeadgrower->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 25){ // date farrowed
						if($property->value != "Not specified"){
							$bday_currentdeadgrower = $property->value;
							$deadgrowerpropperties = $currentdeadgrower->getAnimalProperties();
							foreach ($deadgrowerpropperties as $deadgrowerpropperty) {
								if($deadgrowerpropperty->property_id == 55){ // date died
									$date_died_grower = $deadgrowerpropperty->value;
								}
							}
							$age_currentdeadgrower = Carbon::parse($date_died_grower)->diffInMonths(Carbon::parse($bday_currentdeadgrower));
							array_push($ages_dead, $age_currentdeadgrower);
						}
					}
				}
			}
			foreach ($currentdeadbreeders as $currentdeadbreeder) { // gets ages of dead breeders
				$deadproperties = $currentdeadbreeder->getAnimalProperties();
				foreach ($deadproperties as $deadproperty) {
					if($deadproperty->property_id == 25){ // date farrowed
						if($deadproperty->value != "Not specified"){
							$bday_currentdeadbreeder = $deadproperty->value;
							$deadbreederpropperties = $currentdeadbreeder->getAnimalProperties();
							foreach ($deadbreederpropperties as $deadbreederpropperty) {
								if($deadbreederpropperty->property_id == 55){ // date died
									$date_died_breeder = $deadbreederpropperty->value;
								}
							}
							$age_currentdeadbreeder = Carbon::parse($date_died_breeder)->diffInMonths(Carbon::parse($bday_currentdeadbreeder));
							array_push($ages_dead, $age_currentdeadbreeder);
						}
					}
				}
			}
			// sales
			foreach ($currentsoldgrowers as $currentsoldgrower) {  // gets ages of sold growers
				$growerproperties = $currentsoldgrower->getAnimalProperties();
				foreach ($growerproperties as $growerproperty) {
					if($growerproperty->property_id == 25){ // date farrowed
						if($growerproperty->value != "Not specified"){
							$bday_currentsoldgrower = $growerproperty->value;
							$soldgrowerpropperties = $currentsoldgrower->getAnimalProperties();
							foreach ($soldgrowerpropperties as $soldgrowerpropperty) {
								if($soldgrowerpropperty->property_id == 56){ // date sold
									$date_sold = $soldgrowerpropperty->value;
								}
							}
							$age_currentsoldgrower = Carbon::parse($date_sold)->diffInMonths(Carbon::parse($bday_currentsoldgrower));
							array_push($ages_currentsoldgrower, $age_currentsoldgrower);
						}
					}
				}
			}
			foreach ($currentsoldbreeders as $currentsoldbreeder) { // gets ages of sold breeders
				$breederproperties = $currentsoldbreeder->getAnimalProperties();
				foreach ($breederproperties as $breederproperty) {
					if($breederproperty->property_id == 25){ // date farrowed
						if($breederproperty->value != "Not specified"){
							$bday_currentsoldbreeder = $breederproperty->value;
							$soldbreederpropperties = $currentsoldbreeder->getAnimalProperties();
							foreach ($soldbreederpropperties as $soldbreederpropperty) {
								if($soldbreederpropperty->property_id == 56){ // date sold
									$date_sold = $soldbreederpropperty->value;
								}
							}
							$age_currentsoldbreeder = Carbon::parse($date_sold)->diffInMonths(Carbon::parse($bday_currentsoldbreeder));
							array_push($ages_currentsoldbreeder, $age_currentsoldbreeder);
						}
					}
				}
			}
			foreach ($currentsoldgrowers as $currentsoldgrower) { // gets average weights of sold growers
				$grower_properties = $currentsoldgrower->getAnimalProperties();
				foreach ($grower_properties as $grower_property) {
					if($grower_property->property_id == 57){
						if($grower_property->value != "Not specified"){
							$weight_currentsoldgrower = $grower_property->value;
							array_push($weights_currentsoldgrower, $weight_currentsoldgrower);
						}
					}
				}
			}
			foreach ($currentsoldbreeders as $currentsoldbreeder) { // gets average weights of sold breeders
				$breeder_properties = $currentsoldbreeder->getAnimalProperties();
				foreach ($breeder_properties as $breeder_property) {
					if($breeder_property->property_id == 57){
						if($breeder_property->value != "Not specified"){
							$weight_currentsoldbreeder = $breeder_property->value;
							array_push($weights_currentsoldbreeder, $weight_currentsoldbreeder);
						}
					}
				}
			}
			
			$months = ["December", "November", "October", "September", "August", "July", "June", "May", "April", "March", "Febraury", "January"];
			// $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			// gets the unique years of death/sales/removed
			$years = [];
			$tempyears = [];
		  foreach ($pigs as $pig) {
		  	$pigproperties = $pig->getAnimalProperties();
		  	foreach ($pigproperties as $pigproperty) {
		  		if($pigproperty->property_id == 55){ //death
		  			if(!is_null($pigproperty->value)){
		  				$date = Carbon::parse($pigproperty->value);
		  				array_push($tempyears, $date->year);
		  			}
		  		}
		  		if($pigproperty->property_id == 56){ //sales
		  			if(!is_null($pigproperty->value)){
		  				$date = Carbon::parse($pigproperty->value);
		  				array_push($tempyears, $date->year);
		  			}
		  		}
		  		if($pigproperty->property_id == 72){ //removed
		  			if(!is_null($pigproperty->value)){
		  				$date = Carbon::parse($pigproperty->value);
		  				array_push($tempyears, $date->year);
		  			}
		  		}
		  	}
		  }
		  $years = array_reverse(array_sort(array_unique($tempyears)));
		  

			return view('pigs.mortalityandsalesreport', compact('dead_breeders', 'currentdeadgrowers', 'dead_growers', 'currentdeadbreeders', 'sold_breeders', 'currentsoldbreeders', 'sold_growers', 'currentsoldgrowers', 'removed', 'currentremoved', 'ages_dead', 'ages_currentsoldbreeder', 'ages_currentsoldgrower', 'weights_currentsoldbreeder', 'weights_currentsoldgrower', 'now', 'years', 'months'));
		}

		static function getMonthlyMortality($year, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where(function ($query) {
										$query->where("status", "dead breeder")
													->orWhere("status", "dead grower");
													})->get();

			$monthlymortality = [];
			foreach ($pigs as $pig) {
				$properties = $pig->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 55){ //date died
						if(!is_null($property->value)){
							$date = Carbon::parse($property->value);
							if($date->year == $year && $date->format('F') == $month){
									array_push($monthlymortality, $pig);
							}
						}
					}
				}
			}

			return $monthlymortality;
		}

		static function getMonthlySales($year, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where(function ($query) {
										$query->where("status", "sold breeder")
													->orWhere("status", "sold grower");
													})->get();

			$monthlysales = [];
			foreach ($pigs as $pig) {
				$properties = $pig->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 56){ //date sold
						if(!is_null($property->value)){
							$date = Carbon::parse($property->value);
							if($date->year == $year && $date->format('F') == $month){
									array_push($monthlysales, $pig);
							}
						}
					}
				}
			}

			return $monthlysales;
		}

		static function getMonthlyRemoved($year, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "removed")->get();

			$monthlyremoved = [];
			foreach ($pigs as $pig) {
				$properties = $pig->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 72){ //removed
						if(!is_null($property->value)){
							$date = Carbon::parse($property->value);
							if($date->year == $year && $date->format('F') == $month){
									array_push($monthlyremoved, $pig);
							}
						}
					}
				}
			}

			return $monthlyremoved;
		}

		static function getMonthlyAverageAge($year, $month, $property_id){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where(function ($query) {
										$query->where("status", "sold breeder")
													->orWhere("status", "sold grower")
													->orWhere("status", "dead breeder")
													->orWhere("status", "dead grower");
													})->get();

			$ages = [];
			foreach ($pigs as $pig) {
				$properties = $pig->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == $property_id){
						if(!is_null($property->value)){
							$date = Carbon::parse($property->value);
							if($date->year == $year && $date->format('F') == $month){
								$bdayprop = $pig->getAnimalProperties()->where("property_id", 25)->first(); //date farrowed
								if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
									$bday = Carbon::parse($bdayprop->value);
									$age = $date->diffInMonths($bday);
									array_push($ages, $age);
								}
							}
						}
					}
				}
			}

			return $ages;
		}

		static function getMonthlyAverageWeightSold($year, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where(function ($query) {
										$query->where("status", "sold breeder")
													->orWhere("status", "sold grower");
													})->get();

			$weights = [];
			foreach ($pigs as $pig) {
				$properties = $pig->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 56){ //date sold
						if(!is_null($property->value)){
							$date = Carbon::parse($property->value);
							if($date->year == $year && $date->format('F') == $month){
								$weightprop = $pig->getAnimalProperties()->where("property_id", 57)->first(); //weight sold
								if(!is_null($weightprop) && $weightprop->value != "Not specified"){
									array_push($weights, $weightprop->value);
								}								
							}
						}
					}
				}
			}

			return $weights;
		}

		public function getFarmProfilePage(){ // function to display Farm Profile page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$user = Auth::User();

			return view('pigs.farmprofile', compact('farm', 'breed', 'user'));
		}

		public function getGrowerRecordsPage(){ // function to display Grower Records page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "active")->get();

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

			return view('pigs.growerrecords', compact('pigs', 'sows', 'boars'));
		}

		public function getBreederRecordsPage(){ // function to display Breeder Records page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();

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

			// computes ponderal index = weight at 180 days divided by body length converted to meters cube
			$ponderalIndexValue = 0;
			if(!is_null($pigs)){
				foreach ($pigs as $pig) {
					$properties = $pig->getAnimalProperties();
					foreach ($properties as $property) {
						if($property->property_id == 40){
							if(!is_null($property) && $property->value != ""){
								$bodylength = $property->value;
								$bodyweight180dprop = $pig->getAnimalProperties()->where("property_id", 47)->first();
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
					$ponderalprop = $pig->getAnimalProperties()->where("property_id", 43)->first();
					if(is_null($ponderalprop)){
						$ponderalindex = new AnimalProperty;
						$ponderalindex->animal_id = $pig->id;
						$ponderalindex->property_id = 43;
						$ponderalindex->value = $ponderalIndexValue;
						$ponderalindex->save();
					}
					else{
						$ponderalprop->value = $ponderalIndexValue;
						$ponderalprop->save();
					}
				}
			}

			return view('pigs.breederrecords', compact('pigs', 'sows', 'boars'));
		}

		public function getAddPigPage(){ // function to display Add Pig page
			return view('pigs.addpig');
		}

		public function getViewSowPage($id){ // function to display View Sow page
			$sow = Animal::find($id);
			$properties = $sow->getAnimalProperties();

			// computes current age
			$now = Carbon::now();
			if(!is_null($properties->where("property_id", 25)->first())){
				if($properties->where("property_id", 25)->first()->value == "Not specified"){
					$age = "";
				}
				else{
					$end_date = Carbon::parse($properties->where("property_id", 25)->first()->value);
					$age = $now->diffInMonths($end_date);
				}
			}
			else{
				$age = "";
			}

			// computes age at weaning
			if(!is_null($properties->where("property_id", 25)->first()) && !is_null($properties->where("property_id", 61)->first())){
				if($properties->where("property_id", 25)->first()->value == "Not specified" || $properties->where("property_id", 61)->first()->value == "Not specified"){
					$ageAtWeaning = "";
				}
				else{
					$start_weaned = Carbon::parse($properties->where("property_id", 25)->first()->value);
					$end_weaned = Carbon::parse($properties->where("property_id", 61)->first()->value);
					$ageAtWeaning = $end_weaned->diffInMonths($start_weaned);
				}
			}
			else{
				$ageAtWeaning = "";
			}

			// computes age at first mating (only those with data of 1st parity)
			$frequency = $sow->getAnimalProperties()->where("property_id", 88)->first();
			$dates_bred = [];
			if(!is_null($frequency)){
				if($frequency->value > 1){
					$groups = Grouping::where("mother_id", $sow->id)->get();
					foreach ($groups as $group) {
						$groupingproperties = $group->getGroupingProperties();
						foreach ($groupingproperties as $groupingproperty) {
							if($groupingproperty->property_id == 76){
								if($groupingproperty->value == 1){
									$date_bred = $group->getGroupingProperties()->where("property_id", 48)->first()->value;
									if(!is_null($sow->getAnimalProperties()->where("property_id", 25)->first())){
										$bday = $sow->getAnimalProperties()->where("property_id", 25)->first()->value;
										$ageAtFirstMating = Carbon::parse($date_bred)->diffInMonths(Carbon::parse($bday));
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
						if($familymemberproperty->property_id == 27){
							if($familymemberproperty->value == 'M'){
								array_push($males, $familymember->getChild());
							}
							elseif($familymemberproperty->value == 'F'){
								array_push($females, $familymember->getChild());
							}
						}
					}
				}
			}

			return view('pigs.viewsow', compact('sow', 'properties', 'age', 'ageAtWeaning', 'ageAtFirstMating', 'males', 'females', 'groups'));
		}

		public function getViewBoarPage($id){ // function to display View Boar page
			$boar = Animal::find($id);
			$properties = $boar->getAnimalProperties();

			// computes current age
			$now = Carbon::now();
			if(!is_null($properties->where("property_id", 25)->first())){
				if($properties->where("property_id", 25)->first()->value == "Not specified"){
					$age = "";
				}
				else{
					$end_date = Carbon::parse($properties->where("property_id", 25)->first()->value);
					$age = $now->diffInMonths($end_date);
				}
			}
			else{
				$age = "";
			}

			// computes age at weaning
			if(!is_null($properties->where("property_id", 25)->first()) && !is_null($properties->where("property_id", 61)->first())){
				if($properties->where("property_id", 25)->first()->value == "Not specified" || $properties->where("property_id", 61)->first()->value == "Not specified"){
					$ageAtWeaning = "";
				}
				else{
					$start_weaned = Carbon::parse($properties->where("property_id", 25)->first()->value);
					$end_weaned = Carbon::parse($properties->where("property_id", 61)->first()->value);
					$ageAtWeaning = $end_weaned->diffInMonths($start_weaned);
				}
			}
			else{
				$ageAtWeaning = "";
			}

			// computes age at first mating (only those with data of 1st parity)
			$frequency = $boar->getAnimalProperties()->where("property_id", 88)->first();
			$dates_bred = [];
			if(!is_null($frequency)){
				if($frequency->value > 1){
					$groups = Grouping::where("father_id", $boar->id)->get();
					foreach ($groups as $group) {
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
						if(!is_null($boar->getAnimalProperties()->where("property_id", 25)->first())){
							$bday = $boar->getAnimalProperties()->where("property_id", 25)->first()->value;
							$ageAtFirstMating = Carbon::parse($date_bredboar)->diffInMonths(Carbon::parse($bday));
						}
						else{
							$ageAtFirstMating = "";
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
			$family = $boar->getGrouping();
			if(!is_null($family)){
				$familymembers = $family->getGroupingMembers();
				$males = [];
				$females = [];
				foreach ($familymembers as $familymember) {
					$familymemberproperties = $familymember->getAnimalProperties();
					foreach ($familymemberproperties as $familymemberproperty) {
						if($familymemberproperty->property_id == 27){
							if($familymemberproperty->value == 'M'){
								array_push($males, $familymember->getChild());
							}
							elseif($familymemberproperty->value == 'F'){
								array_push($females, $familymember->getChild());
							}
						}
					}
				}
			}

			return view('pigs.viewboar', compact('boar', 'properties', 'age', 'ageAtWeaning', 'ageAtFirstMating', 'males', 'females', 'groups'));
		}

		public function getGrossMorphologyPage($id){ // function to display Add Gross Morphology page
			$animal = Animal::find($id);
			$properties = $animal->getAnimalProperties();

			return view('pigs.grossmorphology', compact('animal', 'properties'));
		}

		public function getEditGrossMorphologyPage($id){ // function to display Edit Gross Morphology page
			$animal = Animal::find($id);
			$properties = $animal->getAnimalProperties();

			return view('pigs.editgrossmorphology', compact('animal', 'properties'));
		}

		public function getMorphometricCharsPage($id){ // function to display Add Morphometric Characteristics page
			$animal = Animal::find($id);
			$properties = $animal->getAnimalProperties();

			return view('pigs.morphometriccharacteristics', compact('animal', 'properties'));
		}

		public function getEditMorphometricCharsPage($id){ // function to display Edit Morphometric Characteristics page
			$animal = Animal::find($id);
			$properties = $animal->getAnimalProperties();

			return view('pigs.editmorphometriccharacteristics', compact('animal', 'properties'));
		}

		public function getWeightRecordsPage($id){ // function to display Add Weight Records page
			$animal = Animal::find($id);
			$properties = $animal->getAnimalProperties();

			return view('pigs.weightrecords', compact('animal', 'properties'));
		}

		public function getEditWeightRecordsPage($id){ // function to display Edit Weight Records page
			$animal = Animal::find($id);
			$properties = $animal->getAnimalProperties();

			return view('pigs.editweightrecords', compact('animal', 'properties'));
		}

		public function fetchBreedersAjax($breederid){ // function to add pigs as breeders onclick
			$pig = Animal::where("registryid", $breederid)->first();

			$pig->status = "breeder";
			$pig->save();
		}

		public function makeCandidateBreederAjax($growerid, $status){
			$pig = Animal::where("registryid", $growerid)->first();

			$statusprop = $pig->getAnimalProperties()->where("property_id", 50)->first();

			if(is_null($statusprop)){
				$pigstatus = new AnimalProperty;
				$pigstatus->animal_id = $pig->id;
				$pigstatus->property_id = 50;
				$pigstatus->value = $status;
				$pigstatus->save();

				return $statusprop;
			}
			else{
				$statusprop->value = $status;
				$statusprop->save();
			}

		}

		public function getViewADGPage($id){
			$pig = Animal::find($id);
			$properties = $pig->getAnimalProperties();

			/*
			adg = (final weight - initial weight)/number of days
				where
					final weight = latest weight record
					initial weight = birth weight (birth)
												 = weaning weight (weaning)
					number of days = number of days of latest weight record (birth)
												 = number of days of latest weight record - weaning age (weaning)

			property id
				45d - 45
				60d - 46
				90d - 69
				150d - 90
				180d - 47
			*/
			$birth_weight_prop = $properties->where("property_id", 53)->first();
			$weaning_weight_prop = $properties->where("property_id", 54)->first();
			$weight_45d_prop = $properties->where("property_id", 45)->first();
			$weight_60d_prop = $properties->where("property_id", 46)->first();
			$weight_90d_prop = $properties->where("property_id", 69)->first();
			$weight_150d_prop = $properties->where("property_id", 90)->first();
			$weight_180d_prop = $properties->where("property_id", 47)->first();
			
			$latest_weight = 0;
			$number_of_days = 0;
			if(!is_null($weight_180d_prop)){
				if($weight_180d_prop->value != ""){
					$latest_weight = $weight_180d_prop->value;
					$number_of_days = 180;
				}
				else{
					if(!is_null($weight_150d_prop)){
						if($weight_150d_prop->value != ""){
							$latest_weight = $weight_150d_prop->value;
							$number_of_days = 150;
						}
						else{
							if(!is_null($weight_90d_prop)){
								if($weight_90d_prop->value != ""){
									$latest_weight = $weight_90d_prop->value;
									$number_of_days = 90;
								}
								else{
									if(!is_null($weight_60d_prop)){
										if($weight_60d_prop->value != ""){
											$latest_weight = $weight_60d_prop->value;
											$number_of_days = 60;
										}
										else{
											if(!is_null($weight_45d_prop)){
												if($weight_45d_prop->value != ""){
													$latest_weight = $weight_45d_prop->value;
													$number_of_days = 45;
												}
											}
											else{
												$latest_weight = "";
												$number_of_days = "";
											}
										}
									}
									else{
										if(!is_null($weight_45d_prop)){
											if($weight_45d_prop->value != ""){
												$latest_weight = $weight_45d_prop->value;
												$number_of_days = 45;
											}
										}
										else{
											$latest_weight = "";
											$number_of_days = "";
										}
									}
								}
							}
							else{
								if(!is_null($weight_60d_prop)){
									if($weight_60d_prop->value != ""){
										$latest_weight = $weight_60d_prop->value;
										$number_of_days = 60;
									}
								}
								else{
									if(!is_null($weight_45d_prop)){
										if($weight_45d_prop->value != ""){
											$latest_weight = $weight_45d_prop->value;
											$number_of_days = 45;
										}
									}
									else{
										$latest_weight = "";
										$number_of_days = "";
									}
								}
							}
						}
					}
					else{
						if(!is_null($weight_90d_prop)){
							if($weight_90d_prop->value != ""){
								$latest_weight = $weight_90d_prop->value;
								$number_of_days = 90;
							}
						}
						else{
							if(!is_null($weight_60d_prop)){
								if($weight_60d_prop->value != ""){
									$latest_weight = $weight_60d_prop->value;
									$number_of_days = 60;
								}
							}
							else{
								if(!is_null($weight_45d_prop)){
									if($weight_45d_prop->value != ""){
										$latest_weight = $weight_45d_prop->value;
										$number_of_days = 45;
									}
								}
								else{
									$latest_weight = "";
									$number_of_days = "";
								}
							}
						}
					}
				}
			}
			else{
				if(!is_null($weight_150d_prop)){
					if($weight_150d_prop->value != ""){
						$latest_weight = $weight_150d_prop->value;
						$number_of_days = 150;
					}
				}
				else{
					if(!is_null($weight_90d_prop)){
						if($weight_90d_prop->value != ""){
							$latest_weight = $weight_90d_prop->value;
							$number_of_days = 90;
						}
					}
					else{
						if(!is_null($weight_60d_prop)){
							if($weight_60d_prop->value != ""){
								$latest_weight = $weight_60d_prop->value;
								$number_of_days = 60;
							}
						}
						else{
							if(!is_null($weight_45d_prop)){
								if($weight_45d_prop->value != ""){
									$latest_weight = $weight_45d_prop->value;
									$number_of_days = 45;
								}
							}
							else{
								$latest_weight = "";
								$number_of_days = "";
							}
						}
					}
				}
			}

			$adg_birth = 0;
			if($latest_weight != "" && $number_of_days != ""){
				if(!is_null($birth_weight_prop) && $birth_weight_prop->value != ""){
					$adg_birth = ($latest_weight-$birth_weight_prop->value)/$number_of_days;
				}
				else{
					$adg_birth = "";
				}
			}
			else{
				if(!is_null($weaning_weight_prop) && $weaning_weight_prop->value != ""){
					$date_weaned = Carbon::parse($properties->where("property_id", 61)->first()->value);
					$bday = Carbon::parse($properties->where("property_id", 25)->first()->value);
					$number_of_days_now = $date_weaned->diffInDays($bday);
					$latest_weight_now = $weaning_weight_prop->value;
					$adg_birth = ($latest_weight_now-$birth_weight_prop->value)/$number_of_days_now;
				}
				else{
					$adg_birth = "";
				}
			}
			
			$adg_weaning = 0;
			if($latest_weight != "" && $number_of_days != ""){
				if(!is_null($weaning_weight_prop) && $weaning_weight_prop->value != ""){
					$date_weaned = Carbon::parse($properties->where("property_id", 61)->first()->value);
					$bday = Carbon::parse($properties->where("property_id", 25)->first()->value);
					$age_weaned = $date_weaned->diffInDays($bday);
					if($number_of_days != $age_weaned){
						$adg_weaning = ($latest_weight-$weaning_weight_prop->value)/($number_of_days-$age_weaned);
					}
					else{
						$adg_weaning = 0;
					}
				}
				else{
					$adg_weaning = "";
				}
			}
			else{
				if(!is_null($weaning_weight_prop) && $weaning_weight_prop->value != ""){
					$adg_weaning = 0;
				}
				else{
					$adg_weaning = "";
				}
			}

			return view('pigs.adg', compact('pig', 'properties', 'adg_birth', 'adg_weaning'));
		}
		
		public function changeStatusFromBred($id, Request $request){
			$group = Grouping::find($id);

			$status = $group->getGroupingProperties()->where("property_id", 50)->first();
			$status->value = $request->mating_status;
			$status->save();

			return Redirect::back()->with('message','Operation Successful!');
		}

		public function changeStatusFromPregnant($id, Request $request){
			$group = Grouping::find($id);

			$status = $group->getGroupingProperties()->where("property_id", 50)->first();
			$status->value = $request->mating_status;
			$status->save();

			return Redirect::back()->with('message','Operation Successful!');
		}

		public function addDateAborted(Request $request){
			$group = Grouping::find($request->group_id);

			$dateabortedprop = $group->getGroupingProperties()->where("property_id", 89)->first();
			if(is_null($dateabortedprop)){
				$date_aborted = new GroupingProperty;
				$date_aborted->grouping_id = $group->id;
				$date_aborted->property_id = 89;
				$date_aborted->value = $request->date_aborted;
				$date_aborted->datecollected = new Carbon();
				$date_aborted->save();
			}
			else{
				$dateabortedprop->value = $request->date_aborted;
				$dateabortedprop->save();
			}

			return Redirect::back()->with('message','Operation Successful!');
		}

		public function addBreedingRecord(Request $request){ // function to add new breeding record
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$sow = Animal::where("registryid", $request->sow_id)->first();
			$boar = Animal::where("registryid", $request->boar_id)->first();

			$pair = new Grouping;
			$pair->registryid = $sow->registryid;
			$pair->father_id = $boar->id;
			$pair->mother_id = $sow->id;
			$pair->breed_id = $breed->id;
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

			$status = new GroupingProperty;
			$status->grouping_id = $pair->id;
			$status->property_id = 50;
			$status->value = "Bred";
			$status->datecollected = new Carbon();
			$status->save();

			return Redirect::back()->with('message','Operation Successful!');

		}

		public function fetchWeighingOptionAjax($familyidvalue, $option){
			$group = Grouping::find($familyidvalue);

			$weighingoption_prop = $group->getGroupingProperties()->where("property_id", 94)->first();

			if(is_null($weighingoption_prop)){
				$weighing_option = new GroupingProperty;
				$weighing_option->grouping_id = $familyidvalue;
				$weighing_option->property_id = 94;
				$weighing_option->value = $option;
				$weighing_option->datecollected = new Carbon();
				$weighing_option->save();

				return $weighingoption_prop;
			}
			else{
				$weighingoption_prop->value = $option;
				$weighingoption_prop->save();
			}
		}
	
		public function addSowLitterRecord(Request $request){ // function to add sow litter record and offsprings
			$grouping = Grouping::find($request->grouping_id);
			$members = $grouping->getGroupingMembers();

			// adds new offspring
			$birthdayValue = new Carbon($request->date_farrowed);
			if(!is_null($request->offspring_earnotch) && !is_null($request->sex) && !is_null($request->birth_weight)){
				$offspring = new Animal;
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

			// adds date farrowed as a group property
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

			// changes status from Pregnant to Farrowed
			$status = GroupingProperty::where("property_id", 50)->where("grouping_id", $grouping->id)->first();
			$status->value = "Farrowed";
			$status->save();

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

			if(is_null($request->abnormalities)){
				$abnormalityValue = "None";
			}
			else{
				$abnormalityValue = $request->abnormalities;
			}

			$abnormalityprop = $grouping->getGroupingProperties()->where("property_id", 92)->first();
			if(is_null($abnormalityprop)){
				$abnormality = new GroupingProperty;
				$abnormality->grouping_id = $grouping->id;
				$abnormality->property_id = 92;
				$abnormality->value = $abnormalityValue;
				$abnormality->datecollected = new Carbon();
				$abnormality->save();
			}
			else{
				$abnormalityprop->value = $abnormalityValue;
				$abnormalityprop->save();
			}

			// adding parity
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

			// function call to update parity of mother
			static::addParityMother($grouping->id);

			$grouping->members = 1;
			$grouping->save();

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function addSowlitterRecordIndividualWeighing(Request $request){
			$grouping = Grouping::find($request->grouping_id);
			$members = $grouping->getGroupingMembers();

			// adds new offspring
			$birthdayValue = new Carbon($request->date_farrowed);
			if(!is_null($request->offspring_earnotch) && !is_null($request->sex) && !is_null($request->birth_weight)){
				$offspring = new Animal;
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

			// adds date farrowed as a group property
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

			// changes status from Pregnant to Farrowed
			$status = GroupingProperty::where("property_id", 50)->where("grouping_id", $grouping->id)->first();
			$status->value = "Farrowed";
			$status->save();

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

			if(is_null($request->abnormalities)){
				$abnormalityValue = "None";
			}
			else{
				$abnormalityValue = $request->abnormalities;
			}

			$abnormalityprop = $grouping->getGroupingProperties()->where("property_id", 92)->first();
			if(is_null($abnormalityprop)){
				$abnormality = new GroupingProperty;
				$abnormality->grouping_id = $grouping->id;
				$abnormality->property_id = 92;
				$abnormality->value = $abnormalityValue;
				$abnormality->datecollected = new Carbon();
				$abnormality->save();
			}
			else{
				$abnormalityprop->value = $abnormalityValue;
				$abnormalityprop->save();
			}

			// adding parity
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

			// function call to update parity of mother
			static::addParityMother($grouping->id);

			$grouping->members = 1;
			$grouping->save();

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function addSowlitterRecordGroupWeighing(Request $request){
			$grouping = Grouping::find($request->grouping_id);
			$members = $grouping->getGroupingMembers();

			// adds new offspring
			$birthdayValue = new Carbon($request->date_farrowed);
			$litterbirthweightprop = $grouping->getGroupingProperties()->where("property_id", 93)->first();
			if(is_null($litterbirthweightprop)){
				$litter_birth_weight = new GroupingProperty;
				$litter_birth_weight->grouping_id = $grouping->id;
				$litter_birth_weight->property_id = 93;
				$litter_birth_weight->value = $request->litter_birth_weight;
				$litter_birth_weight->datecollected = new Carbon();
				$litter_birth_weight->save();
			}
			else{
				$litterbirthweightprop->value = $request->litter_birth_weight;
				$litterbirthweightprop->save();
			}

			$lsbaprop = $grouping->getGroupingProperties()->where("property_id", 95)->first();
			if(is_null($lsbaprop)){
				$lsba = new GroupingProperty;
				$lsba->grouping_id = $grouping->id;
				$lsba->property_id = 95;
				$lsba->value = $request->lsba;
				$lsba->datecollected = new Carbon();
				$lsba->save();
			}
			else{
				$lsbaprop->value = $request->lsba;
				$lsbaprop->save();
			}

			if(!is_null($request->offspring_earnotch) && !is_null($request->sex)){
				$offspring = new Animal;
				$farm = $this->user->getFarm();
				$breed = $farm->getBreed();
				$offspring->animaltype_id = 3;
				$offspring->farm_id = $farm->id;
				$offspring->breed_id = $breed->id;
				$offspring->status = "temporary";
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

				$litterbirthweightValue = $request->litter_birth_weight;
				$lsbaValue = $request->lsba;

				$birthweight = new AnimalProperty;
				$birthweight->animal_id = $offspring->id;
				$birthweight->property_id = 53;
				$birthweight->value = $litterbirthweightValue/$lsbaValue;
				$birthweight->save();

				$groupingmember = new GroupingMember;
				$groupingmember->grouping_id = $grouping->id;
				$groupingmember->animal_id = $offspring->id;
				$groupingmember->save();
			}

			// adds date farrowed as a group property
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

			// changes status from Pregnant to Farrowed
			$status = GroupingProperty::where("property_id", 50)->where("grouping_id", $grouping->id)->first();
			$status->value = "Farrowed";
			$status->save();

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

			if(is_null($request->abnormalities)){
				$abnormalityValue = "None";
			}
			else{
				$abnormalityValue = $request->abnormalities;
			}

			$abnormalityprop = $grouping->getGroupingProperties()->where("property_id", 92)->first();
			if(is_null($abnormalityprop)){
				$abnormality = new GroupingProperty;
				$abnormality->grouping_id = $grouping->id;
				$abnormality->property_id = 92;
				$abnormality->value = $abnormalityValue;
				$abnormality->datecollected = new Carbon();
				$abnormality->save();
			}
			else{
				$abnormalityprop->value = $abnormalityValue;
				$abnormalityprop->save();
			}

			// adding parity
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

			// function call to update parity of mother
			static::addParityMother($grouping->id);

			$grouping->members = 1;
			$grouping->save();

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function editTemporaryRegistryId(Request $request){
			$offspring = Animal::find($request->old_earnotch);

			$offspringproperties = $offspring->getAnimalProperties();
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$birthdate = Carbon::parse($offspringproperties->where("property_id", 25)->first()->value);
			$sex = $offspringproperties->where("property_id", 27)->first()->value;

			$offspring->registryid = $farm->code.$breed->breed."-".$birthdate->year.$sex.$request->new_earnotch;
			$offspring->status = "active";
			$offspring->save();

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function addWeaningWeights(Request $request){ // function to add weaning weights per offspring
			$grouping = Grouping::find($request->family_id);
			$offspring = Animal::where("registryid", $request->offspring_id)->first();

			$dateweanedprop = $grouping->getGroupingProperties()->where("property_id", 61)->first();
			if(is_null($dateweanedprop)){
				$date_weaned_group = new GroupingProperty;
				$date_weaned_group->grouping_id = $grouping->id;
				$date_weaned_group->property_id = 61;
				$date_weaned_group->value = $request->date_weaned;
				$date_weaned_group->datecollected = new Carbon();
				$date_weaned_group->save();

				$date_weaned_individual = new AnimalProperty;
				$date_weaned_individual->animal_id = $offspring->id;
				$date_weaned_individual->property_id = 61;
				$date_weaned_individual->value = $request->date_weaned;
				$date_weaned_individual->save();

				$weaningweight = new AnimalProperty;
				$weaningweight->animal_id = $offspring->id;
				$weaningweight->property_id = 54;
				$weaningweight->value = $request->weaning_weight;
				$weaningweight->save();
			}
			else{
				$dateweanedprop->value = $request->date_weaned;
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

		public function fetchNewPigRecord(Request $request){ // function to add new pig
			$birthdayValue = new Carbon($request->date_farrowed);
			$newpig = new Animal;
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$newpig->animaltype_id = 3;
			$newpig->farm_id = $farm->id;
			$newpig->breed_id = $breed->id;
			$newpig->status = $request->status_setter;
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

			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();

			if(!is_null($request->mother) && !is_null($request->father)){
				$grouping = new Grouping;

				foreach ($pigs as $pig) { // searches database for pig with same earnotch
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

				// if mother and/or father are not in the database, it will just be the new pig's property
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
				// if parents are found, this will create a new breeding record available for viewing in the Breeding Records page
				if($foundmother == 1 || $foundfather == 1){
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

		public function fetchGrossMorphology(Request $request){ // function to add gross morphology data
			$animalid = $request->animal_id;

			// creates new properties
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

		public function fetchMorphometricCharacteristics(Request $request){ // function to add morphometric characteristics
			$animalid = $request->animal_id;

			// creates new properties
			$dcmorpho = new AnimalProperty;
			$earlength = new AnimalProperty;
			$headlength = new AnimalProperty;
			$bodylength = new AnimalProperty;
			$snoutlength = new AnimalProperty;
			$heartgirth = new AnimalProperty;
			$pelvicwidth = new AnimalProperty;
			$taillength = new AnimalProperty;
			$heightatwithers = new AnimalProperty;
			$normalteats = new AnimalProperty;

			if(is_null($request->date_collected_morpho)){
				$dateCollectedMorphoValue = "";
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
		 
			$dcmorpho->save();
			$earlength->save();
			$headlength->save();
			$snoutlength->save();
			$bodylength->save();
			$pelvicwidth->save();
			$heartgirth->save();
			$taillength->save();
			$heightatwithers->save();
			
			$animal->morphometric = 1;
			$animal->save();

			return Redirect::back()->with('message','Animal record successfully saved');
		}

		public function fetchWeightRecords(Request $request){ // function to add weight records
			$animalid = $request->animal_id;
			$animal = Animal::find($animalid);

			// used when date collected was not provided
			$bday = $animal->getAnimalProperties()->where("property_id", 25)->first();

			// creates new properties
			$bw45d = new AnimalProperty;
			$dc45d = new AnimalProperty;
			$bw60d = new AnimalProperty;
			$dc60d = new AnimalProperty;
			$bw90d = new AnimalProperty;
			$dc90d = new AnimalProperty;
			$bw150d = new AnimalProperty;
			$dc150d = new AnimalProperty;
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

			if(is_null($request->body_weight_at_150_days)){
				$bw150dValue = "";
			}
			else{
				$bw150dValue = $request->body_weight_at_150_days;
			}

			$bw150d->animal_id = $animalid;
			$bw150d->property_id = 90;
			$bw150d->value = $bw150dValue;

			if(is_null($request->date_collected_150_days)){
				if(!is_null($bday)){
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
			$dc150d->property_id = 91;
			$dc150d->value = $dc150dValue;

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
			$bw150d->save();
			$dc150d->save();
			$bw180d->save();
			$dc180d->save();

			$animal = Animal::find($animalid);
			$animal->weightrecord = 1;
			$animal->save();

			return Redirect::back()->with('message','Animal record successfully saved');
		}

		public function editGrossMorphology(Request $request){ // function to edit gross morphology
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

		public function editMorphometricCharacteristics(Request $request){ // function to edit morphometric characteristics
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

		public function editWeightRecords(Request $request){ // function to edit weight records
			$animal = Animal::find($request->animal_id);
			$properties = $animal->getAnimalProperties();

			$bw45d = $properties->where("property_id", 45)->first();
			if(is_null($bw45d)){
				if(is_null($request->body_weight_at_45_days)){
					$bw45dValue = "";
				}
				else{
					$bw45dValue = $request->body_weight_at_45_days;
				}
				$bw45d_new = new AnimalProperty;
				$bw45d_new->animal_id = $animal->id;
				$bw45d_new->property_id = 45;
				$bw45d_new->value = $bw45dValue;
				$bw45d_new->save();
			}
			else{
				if(is_null($request->body_weight_at_45_days)){
					$bw45dValue = "";
				}
				else{
					$bw45dValue = $request->body_weight_at_45_days;
				}
				$bw45d->value = $bw45dValue;
			}

			$bw60d = $properties->where("property_id", 46)->first();
			if(is_null($bw60d)){
				if(is_null($request->body_weight_at_60_days)){
					$bw60dValue = "";
				}
				else{
					$bw60dValue = $request->body_weight_at_60_days;
				}
				$bw60d_new = new AnimalProperty;
				$bw60d_new->animal_id = $animal->id;
				$bw60d_new->property_id = 46;
				$bw60d_new->value = $bw60dValue;
				$bw60d_new->save();
			}
			else{
				if(is_null($request->body_weight_at_60_days)){
					$bw60dValue = "";
				}
				else{
					$bw60dValue = $request->body_weight_at_60_days;
				}
				$bw60d->value = $bw60dValue;
			}

			$bw90d = $properties->where("property_id", 69)->first();
			if(is_null($bw90d)){
				if(is_null($request->body_weight_at_90_days)){
					$bw90dValue = "";
				}
				else{
					$bw90dValue = $request->body_weight_at_90_days;
				}
				$bw90d_new = new AnimalProperty;
				$bw90d_new->animal_id = $animal->id;
				$bw90d_new->property_id = 69;
				$bw90d_new->value = $bw90dValue;
				$bw90d_new->save();
			}
			else{
				if(is_null($request->body_weight_at_90_days)){
					$bw90dValue = "";
				}
				else{
					$bw90dValue = $request->body_weight_at_90_days;
				}
				$bw90d->value = $bw90dValue;
			}

			$bw150d = $properties->where("property_id", 90)->first();
			if(is_null($bw150d)){
				if(is_null($request->body_weight_at_150_days)){
					$bw150dValue = "";
				}
				else{
					$bw150dValue = $request->body_weight_at_150_days;
				}
				$bw150d_new = new AnimalProperty;
				$bw150d_new->animal_id = $animal->id;
				$bw150d_new->property_id = 90;
				$bw150d_new->value = $bw150dValue;
				$bw150d_new->save();
			}
			else{
				if(is_null($request->body_weight_at_150_days)){
					$bw150dValue = "";
				}
				else{
					$bw150dValue = $request->body_weight_at_150_days;
				}
				$bw150d->value = $bw150dValue;
			}

			$bw180d = $properties->where("property_id", 47)->first();
			if(is_null($bw180d)){
				if(is_null($request->body_weight_at_180_days)){
					$bw180dValue = "";
				}
				else{
					$bw180dValue = $request->body_weight_at_180_days;
				}
				$bw180d_new = new AnimalProperty;
				$bw180d_new->animal_id = $animal->id;
				$bw180d_new->property_id = 47;
				$bw180d_new->value = $bw180dValue;
				$bw180d_new->save();
			}
			else{
				if(is_null($request->body_weight_at_180_days)){
					$bw180dValue = "";
				}
				else{
					$bw180dValue = $request->body_weight_at_180_days;
				}
				$bw180d->value = $bw180dValue;
			}

			$bday = $properties->where("property_id", 25)->first();

			$dc45d = $properties->where("property_id", 58)->first();
			if(is_null($dc45d)){
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
				$dc45d_new = new AnimalProperty;
				$dc45d_new->animal_id = $animal->id;
				$dc45d_new->property_id = 58;
				$dc45d_new->value = $dc45dValue;
				$dc45d_new->save();
			}
			else{
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
				$dc45d->value = $dc45dValue;
			}

			$dc60d = $properties->where("property_id", 59)->first();
			if(is_null($dc60d)){
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
				$dc60d_new = new AnimalProperty;
				$dc60d_new->animal_id = $animal->id;
				$dc60d_new->property_id = 59;
				$dc60d_new->value = $dc60dValue;
				$dc60d_new->save();
			}
			else{
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
				$dc60d->value = $dc60dValue;
			}

			$dc90d = $properties->where("property_id", 70)->first();
			if(is_null($dc90d)){
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
				$dc90d_new = new AnimalProperty;
				$dc90d_new->animal_id = $animal->id;
				$dc90d_new->property_id = 70;
				$dc90d_new->value = $dc90dValue;
				$dc90d_new->save();
			}
			else{
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
				$dc90d->value = $dc90dValue;
			}

			$dc150d = $properties->where("property_id", 91)->first();
			if(is_null($dc150d)){
				if(is_null($request->date_collected_150_days)){
					if(!is_null($bday)){
						$dc150dValue = Carbon::parse($bday->value)->addDays(150)->toDateString();
					}
					else{
						$dc150dValue = "";
					}
				}
				else{
					$dc150dValue = $request->date_collected_150_days;
				}
				$dc150d_new = new AnimalProperty;
				$dc150d_new->animal_id = $animal->id;
				$dc150d_new->property_id = 91;
				$dc150d_new->value = $dc150dValue;
				$dc150d_new->save();
			}
			else{
				if(is_null($request->date_collected_150_days)){
					if(!is_null($bday)){
						$dc150dValue = Carbon::parse($bday->value)->addDays(150)->toDateString();
					}
					else{
						$dc150dValue = "";
					}
				}
				else{
					$dc150dValue = $request->date_collected_150_days;
				}
				$dc150d->value = $dc150dValue;
			}

			$dc180d = $properties->where("property_id", 60)->first();
			if(is_null($dc180d)){
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
				$dc180d_new = new AnimalProperty;
				$dc180d_new->animal_id = $animal->id;
				$dc180d_new->property_id = 60;
				$dc180d_new->value = $dc180dValue;
				$dc180d_new->save();
			}
			else{
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
				$dc180d->value = $dc180dValue;
			}

			$bw45d->save();
			$bw60d->save();
			$bw90d->save();
			$bw150d->save();
			$bw180d->save();
			$dc45d->save();
			$dc60d->save();
			$dc90d->save();
			$dc150d->save();
			$dc180d->save();

			return Redirect::back()->with('message','Animal record successfully saved');
		}

		public function addMortalityRecord(Request $request){ // function to add mortality record
			$dead = Animal::where("registryid", $request->registrationid_dead)->first();

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

			$date_died = new AnimalProperty;
			$date_died->animal_id = $dead->id;
			$date_died->property_id = 55;
			$date_died->value = $dateDiedValue;
			$date_died->save();

			if(is_null($request->cause_death)){
				$causeDeathValue = "Not specified";
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

		public function addSalesRecord(Request $request){ // function to add sales record
			$sold = Animal::where("registryid", $request->registrationid_sold)->first();

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

			$date_sold = new AnimalProperty;
			$date_sold->animal_id = $sold->id;
			$date_sold->property_id = 56;
			$date_sold->value = $dateSoldValue;
			$date_sold->save();

			if(is_null($request->weight_sold)){
				$weightSoldValue = "Weight unavailable";
			}
			else{
				$weightSoldValue = $request->weight_sold;
			}

			$weight_sold = new AnimalProperty;
			$weight_sold->animal_id = $sold->id;
			$weight_sold->property_id = 57;
			$weight_sold->value = $weightSoldValue;
			$weight_sold->save();

			if(is_null($request->price)){
				$priceValue = "Not specified";
			}
			else{
				$priceValue = $request->price;
			}

			$price_sold = new AnimalProperty;
			$price_sold->animal_id = $sold->id;
			$price_sold->property_id = 96;
			$price_sold->value = $priceValue;
			$price_sold->save();

			return Redirect::back()->with('message','Operation Successful!');
		}

		public function addRemovedAnimalRecord(Request $request){ // function to add removed (culled/donated) animal records
			$removed =  Animal::where("registryid", $request->registrationid_removed)->first();

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

		public function addFarmProfile(Request $request){ // function to add farm profile
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
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$families = AnimalProperty::where('property_id', 5)->get();
			$replacements = Animal::where('status', 'replacement')->get();
			$group = new Grouping;
			$animal = Animal::where('id', $id)->first();
			$group->registryid = $animal->registryid;
			$group->father_id = $animal->id;
			$group->breed_id = $breed->id;
			$group->save();

			$breedermember = new GroupingMember;
			$breedermember->grouping_id = $group->id;
			$breedermember->animal_id = $animal->id;
			$breedermember->save();
			$animal->status = "breeder";
			$animal->save();
			return Redirect::back()->with('message','Operation Successful !');
		}

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
