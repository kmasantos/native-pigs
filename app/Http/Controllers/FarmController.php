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
use Excel;
use Illuminate\Support\Facades\Log;

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
					$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "active")->get();
					$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
					$now = Carbon::now('Asia/Manila');

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

					// sorts female breeders into sows and gilts
					$sows = [];
					$gilts = [];
					foreach ($femalebreeders as $female) {
						$frequency = $female->getAnimalProperties()->where("property_id", 61)->first();
						if(!is_null($frequency)){
							if($frequency->value == 0){
								array_push($gilts, $female);
							}
							elseif($frequency->value > 0){
								array_push($sows, $female);
							}
						}
						else{
							array_push($gilts, $female);
						}
					}

					$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

					// default filter is the current year
					$current_year = $now->year;
					$filter = $current_year;

					// static::addFrequency();
					$user->lastseen = Carbon::now('Asia/Manila');
					$user->save();

					
					return view('pigs.dashboard', compact('user', 'farm', 'pigs', 'breeders', 'femalegrowers', 'malegrowers', 'femalebreeders', 'malebreeders', 'now', 'sows', 'gilts', 'months', 'filter'));
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
			$animal = collect([]);
			$user = Auth::User();
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$registrationid = "";
			$sex = "";
			$birthday = "";
			$birthweight = 0;
			$group = collect([]);
			$groupingmembers = [];
			$femalelitters = [];
			$malelitters = [];
			$parity = 0;
			$father_registryid = "";
			$father_birthday = "";
			$father_birthweight = 0;
			$father_group = collect([]);
			$father_malelitters = [];
			$father_femalelitters = [];
			$father_groupingmembers = [];
			$father_parity = 0;
			$father_grandfather_registryid = "";
			$father_grandfather_birthday = "";
			$father_grandfather_birthweight = 0;
			$father_grandfather_group = collect([]);
			$father_grandfather_malelitters = [];
			$father_grandfather_femalelitters = [];
			$father_grandfather_groupingmembers = [];
			$father_grandfather_parity = 0;
			$father_grandfather_greatgrandfather_registryid = "";
			$father_grandfather_greatgrandfather_birthday = "";
			$father_grandfather_greatgrandfather_birthweight = 0;
			$father_grandfather_greatgrandmother_registryid = "";
			$father_grandfather_greatgrandmother_birthday = "";
			$father_grandfather_greatgrandmother_birthweight = 0;
			$father_grandmother_registryid = "";
			$father_grandmother_birthday = "";
			$father_grandmother_birthweight = 0;
			$father_grandmother_group = collect([]);
			$father_grandmother_malelitters = [];
			$father_grandmother_femalelitters = [];
			$father_grandmother_groupingmembers = [];
			$father_grandmother_parity = 0;
			$father_grandmother_greatgrandfather_registryid = "";
			$father_grandmother_greatgrandfather_birthday = "";
			$father_grandmother_greatgrandfather_birthweight = 0;
			$father_grandmother_greatgrandmother_registryid = "";
			$father_grandmother_greatgrandmother_birthday = "";
			$father_grandmother_greatgrandmother_birthweight = 0;
			$mother_registryid = "";
			$mother_birthday = "";
			$mother_birthweight = 0;
			$mother_group = collect([]);
			$mother_malelitters = [];
			$mother_femalelitters = [];
			$mother_groupingmembers = [];
			$mother_parity = 0;
			$mother_grandfather_registryid = "";
			$mother_grandfather_birthday = "";
			$mother_grandfather_birthweight = 0;
			$mother_grandfather_group = collect([]);
			$mother_grandfather_malelitters = [];
			$mother_grandfather_femalelitters = [];
			$mother_grandfather_groupingmembers = [];
			$mother_grandfather_parity = 0;
			$mother_grandfather_greatgrandfather_registryid = "";
			$mother_grandfather_greatgrandfather_birthday = "";
			$mother_grandfather_greatgrandfather_birthweight = 0;
			$mother_grandfather_greatgrandmother_registryid = "";
			$mother_grandfather_greatgrandmother_birthday = "";
			$mother_grandfather_greatgrandmother_birthweight = 0;
			$mother_grandmother_registryid = "";
			$mother_grandmother_birthday = "";
			$mother_grandmother_birthweight = 0;
			$mother_grandmother_group = collect([]);
			$mother_grandmother_malelitters = [];
			$mother_grandmother_femalelitters = [];
			$mother_grandmother_groupingmembers = [];
			$mother_grandmother_parity = 0;
			$mother_grandmother_greatgrandfather_registryid = "";
			$mother_grandmother_greatgrandfather_birthday = "";
			$mother_grandmother_greatgrandfather_birthweight = 0;
			$mother_grandmother_greatgrandmother_registryid = "";
			$mother_grandmother_greatgrandmother_birthday = "";
			$mother_grandmother_greatgrandmother_birthweight = 0;
			$found_pigs = [];

			return view('pigs.pedigree', compact('animal', 'registrationid', 'user', 'breed', 'sex', 'birthday', 'birthweight', 'group', 'malelitters', 'femalelitters', 'groupingmembers', 'parity', 'father_registryid', 'father_birthday', 'father_birthweight', 'father_group', 'father_malelitters', 'father_femalelitters', 'father_groupingmembers', 'father_parity', 'father_grandfather_registryid', 'father_grandfather_birthday', 'father_grandfather_birthweight', 'father_grandfather_group', 'father_grandfather_malelitters', 'father_grandfather_femalelitters', 'father_grandfather_groupingmembers', 'father_grandfather_parity', 'father_grandfather_greatgrandfather_registryid', 'father_grandfather_greatgrandfather_birthday', 'father_grandfather_greatgrandfather_birthweight', 'father_grandfather_greatgrandmother_registryid', 'father_grandfather_greatgrandmother_birthday', 'father_grandfather_greatgrandmother_birthweight', 'father_grandmother_registryid', 'father_grandmother_birthday', 'father_grandmother_birthweight', 'father_grandmother_group', 'father_grandmother_malelitters', 'father_grandmother_femalelitters', 'father_grandmother_groupingmembers', 'father_grandmother_parity', 'father_grandmother_greatgrandfather_registryid', 'father_grandmother_greatgrandfather_birthday', 'father_grandmother_greatgrandfather_birthweight', 'father_grandmother_greatgrandmother_registryid', 'father_grandmother_greatgrandmother_birthday', 'father_grandmother_greatgrandmother_birthweight', 'mother_registryid', 'mother_birthday', 'mother_birthweight', 'mother_group', 'mother_malelitters', 'mother_femalelitters', 'mother_groupingmembers', 'mother_parity', 'mother_grandfather_registryid', 'mother_grandfather_birthday', 'mother_grandfather_birthweight', 'mother_grandfather_group', 'mother_grandfather_malelitters', 'mother_grandfather_femalelitters', 'mother_grandfather_groupingmembers', 'mother_grandfather_parity', 'mother_grandfather_greatgrandfather_registryid', 'mother_grandfather_greatgrandfather_birthday', 'mother_grandfather_greatgrandfather_birthweight', 'mother_grandfather_greatgrandmother_registryid', 'mother_grandfather_greatgrandmother_birthday', 'mother_grandfather_greatgrandmother_birthweight', 'mother_grandmother_registryid', 'mother_grandmother_birthday', 'mother_grandmother_birthweight', 'mother_grandmother_group', 'mother_grandmother_malelitters', 'mother_grandmother_femalelitters', 'mother_grandmother_groupingmembers', 'mother_grandmother_parity', 'mother_grandmother_greatgrandfather_registryid', 'mother_grandmother_greatgrandfather_birthday', 'mother_grandmother_greatgrandfather_birthweight', 'mother_grandmother_greatgrandmother_registryid', 'mother_grandmother_greatgrandmother_birthday', 'mother_grandmother_greatgrandmother_birthweight', 'found_pigs'));
		}

		public static function findPig(Request $request){
			$temp_earnotch = $request->earnotch;
			$user = Auth::User();
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$earnotch = "temp";
			$registrationid = "temp";
			$animalid = 0;
			$earnotch_length = strlen($temp_earnotch);

			$found_pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where('registryid', 'LIKE', '%'.$temp_earnotch.'%')->get();

			$animal = collect([]);
			$sex = null;
			$birthday = null;
			$birthweight = 0;
			$group = collect([]);
			$groupingmembers = [];
			$femalelitters = [];
			$malelitters = [];
			$parity = 0;
			$father_registryid = null;
			$father_birthday = null;
			$father_birthweight = 0;
			$father_group = collect([]);
			$father_malelitters = [];
			$father_femalelitters = [];
			$father_groupingmembers = [];
			$father_parity = 0;
			$father_grandfather_registryid = null;
			$father_grandfather_birthday = null;
			$father_grandfather_birthweight = 0;
			$father_grandfather_group = collect([]);
			$father_grandfather_malelitters = [];
			$father_grandfather_femalelitters = [];
			$father_grandfather_groupingmembers = [];
			$father_grandfather_parity = 0;
			$father_grandfather_greatgrandfather_registryid = null;
			$father_grandfather_greatgrandfather_birthday = null;
			$father_grandfather_greatgrandfather_birthweight = 0;
			$father_grandfather_greatgrandmother_registryid = null;
			$father_grandfather_greatgrandmother_birthday = null;
			$father_grandfather_greatgrandmother_birthweight = 0;
			$father_grandmother_registryid = null;
			$father_grandmother_birthday = null;
			$father_grandmother_birthweight = 0;
			$father_grandmother_group = collect([]);
			$father_grandmother_malelitters = [];
			$father_grandmother_femalelitters = [];
			$father_grandmother_groupingmembers = [];
			$father_grandmother_parity = 0;
			$father_grandmother_greatgrandfather_registryid = null;
			$father_grandmother_greatgrandfather_birthday = null;
			$father_grandmother_greatgrandfather_birthweight = 0;
			$father_grandmother_greatgrandmother_registryid = null;
			$father_grandmother_greatgrandmother_birthday = null;
			$father_grandmother_greatgrandmother_birthweight = 0;
			$mother_registryid = null;
			$mother_birthday = null;
			$mother_birthweight = 0;
			$mother_group = collect([]);
			$mother_malelitters = [];
			$mother_femalelitters = [];
			$mother_groupingmembers = [];
			$mother_parity = 0;
			$mother_grandfather_registryid = null;
			$mother_grandfather_birthday = null;
			$mother_grandfather_birthweight = 0;
			$mother_grandfather_group = collect([]);
			$mother_grandfather_malelitters = [];
			$mother_grandfather_femalelitters = [];
			$mother_grandfather_groupingmembers = [];
			$mother_grandfather_parity = 0;
			$mother_grandfather_greatgrandfather_registryid = null;
			$mother_grandfather_greatgrandfather_birthday = null;
			$mother_grandfather_greatgrandfather_birthweight = 0;
			$mother_grandfather_greatgrandmother_registryid = null;
			$mother_grandfather_greatgrandmother_birthday = null;
			$mother_grandfather_greatgrandmother_birthweight = 0;
			$mother_grandmother_registryid = null;
			$mother_grandmother_birthday = null;
			$mother_grandmother_birthweight = 0;
			$mother_grandmother_group = collect([]);
			$mother_grandmother_malelitters = [];
			$mother_grandmother_femalelitters = [];
			$mother_grandmother_groupingmembers = [];
			$mother_grandmother_parity = 0;
			$mother_grandmother_greatgrandfather_registryid = null;
			$mother_grandmother_greatgrandfather_birthday = null;
			$mother_grandmother_greatgrandfather_birthweight = 0;
			$mother_grandmother_greatgrandmother_registryid = null;
			$mother_grandmother_greatgrandmother_birthday = null;
			$mother_grandmother_greatgrandmother_birthweight = 0;
				

			return view('pigs.pedigree', compact('animal', 'registrationid', 'user', 'breed', 'sex', 'birthday', 'birthweight', 'group', 'malelitters', 'femalelitters', 'groupingmembers', 'parity', 'father_registryid', 'father_birthday', 'father_birthweight', 'father_group', 'father_malelitters', 'father_femalelitters', 'father_groupingmembers', 'father_parity', 'father_grandfather_registryid', 'father_grandfather_birthday', 'father_grandfather_birthweight', 'father_grandfather_group', 'father_grandfather_malelitters', 'father_grandfather_femalelitters', 'father_grandfather_groupingmembers', 'father_grandfather_parity', 'father_grandfather_greatgrandfather_registryid', 'father_grandfather_greatgrandfather_birthday', 'father_grandfather_greatgrandfather_birthweight', 'father_grandfather_greatgrandmother_registryid', 'father_grandfather_greatgrandmother_birthday', 'father_grandfather_greatgrandmother_birthweight', 'father_grandmother_registryid', 'father_grandmother_birthday', 'father_grandmother_birthweight', 'father_grandmother_group', 'father_grandmother_malelitters', 'father_grandmother_femalelitters', 'father_grandmother_groupingmembers', 'father_grandmother_parity', 'father_grandmother_greatgrandfather_registryid', 'father_grandmother_greatgrandfather_birthday', 'father_grandmother_greatgrandfather_birthweight', 'father_grandmother_greatgrandmother_registryid', 'father_grandmother_greatgrandmother_birthday', 'father_grandmother_greatgrandmother_birthweight', 'mother_registryid', 'mother_birthday', 'mother_birthweight', 'mother_group', 'mother_malelitters', 'mother_femalelitters', 'mother_groupingmembers', 'mother_parity', 'mother_grandfather_registryid', 'mother_grandfather_birthday', 'mother_grandfather_birthweight', 'mother_grandfather_group', 'mother_grandfather_malelitters', 'mother_grandfather_femalelitters', 'mother_grandfather_groupingmembers', 'mother_grandfather_parity', 'mother_grandfather_greatgrandfather_registryid', 'mother_grandfather_greatgrandfather_birthday', 'mother_grandfather_greatgrandfather_birthweight', 'mother_grandfather_greatgrandmother_registryid', 'mother_grandfather_greatgrandmother_birthday', 'mother_grandfather_greatgrandmother_birthweight', 'mother_grandmother_registryid', 'mother_grandmother_birthday', 'mother_grandmother_birthweight', 'mother_grandmother_group', 'mother_grandmother_malelitters', 'mother_grandmother_femalelitters', 'mother_grandmother_groupingmembers', 'mother_grandmother_parity', 'mother_grandmother_greatgrandfather_registryid', 'mother_grandmother_greatgrandfather_birthday', 'mother_grandmother_greatgrandfather_birthweight', 'mother_grandmother_greatgrandmother_registryid', 'mother_grandmother_greatgrandmother_birthday', 'mother_grandmother_greatgrandmother_birthweight', 'found_pigs'));
		}

		public function selectPig(Request $request){
			$user = Auth::User();
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$id = (int)$request->select_pig;
			$animal = Animal::find($id);
			$found_pigs = [];
			array_push($found_pigs, $animal);
			$registrationid = $animal->registryid;

			if(!is_null($animal)){
				if(substr($registrationid, -7, 1) == 'F'){
					$sex = "Female";
				}
				elseif(substr($registrationid, -7, 1) == 'M'){
					$sex = "Male";
				}

				$bday = $animal->getAnimalProperties()->where("property_id", 3)->first();
				$bw = $animal->getAnimalProperties()->where("property_id", 5)->first();
				if(!is_null($bday) && $bday->value != "Not specified"){
					$birthday = Carbon::parse($bday->value)->format('Y-m-d');
				}
				else{
					$birthday = null;
				}
				if(!is_null($bw) && $bw->value != ""){
					$birthweight = $bw->value;
				}
				else{
					$birthweight = 0;
				}

				$group = $animal->getGrouping();
				
				if(!is_null($group)){
					$father = $group->getFather();
					$mother = $group->getMother();
					$groupingmembers = $group->getGroupingMembers();
					$parity = $group->getGroupingProperties()->where("property_id", 48)->first()->value;
					$femalelitters = [];
					$malelitters = [];

					foreach ($groupingmembers as $groupingmember) {
						if(substr($groupingmember->getChild()->registryid, -7, 1) == 'F'){
							array_push($femalelitters, $groupingmember);
						}
						elseif(substr($groupingmember->getChild()->registryid, -7, 1) == 'M'){
							array_push($malelitters, $groupingmember);
						}
					}

					$father_registryid = $father->registryid;
					$father_bday = $father->getAnimalProperties()->where("property_id", 3)->first();
					$father_bw = $father->getAnimalProperties()->where("property_id", 5)->first();
					if(!is_null($father_bday) && $father_bday->value != "Not specified"){
						$father_birthday = Carbon::parse($father_bday->value)->format('Y-m-d');
					}
					else{
						$father_birthday = null;
					}
					if(!is_null($father_bw) && $father_bw->value != ""){
						$father_birthweight = $father_bw->value;
					}
					else{
						$father_birthweight = 0;
					}

					$father_group = $father->getGrouping();

					if(!is_null($father_group)){
						$father_grandfather = $father_group->getFather();
						$father_grandmother = $father_group->getMother();
						$father_groupingmembers = $father_group->getGroupingMembers();
						$father_parity = $father_group->getGroupingProperties()->where("property_id", 48)->first()->value;
						$father_femalelitters = [];
						$father_malelitters = [];

						foreach ($father_groupingmembers as $father_groupingmember) {
							if(substr($father_groupingmember->getChild()->registryid, -7, 1) == 'F'){
								array_push($father_femalelitters, $father_groupingmember);
							}
							elseif(substr($father_groupingmember->getChild()->registryid, -7, 1) == 'M'){
								array_push($father_malelitters, $father_groupingmember);
							}
						}

						$father_grandfather_registryid = $father_grandfather->registryid;
						$father_grandfather_bday = $father_grandfather->getAnimalProperties()->where("property_id", 3)->first();
						$father_grandfather_bw = $father_grandfather->getAnimalProperties()->where("property_id", 5)->first();
						if(!is_null($father_grandfather_bday) && $father_grandfather_bday->value != "Not specified"){
							$father_grandfather_birthday = Carbon::parse($father_grandfather_bday->value)->format('Y-m-d');
						}
						else{
							$father_grandfather_birthday = null;
						}
						if(!is_null($father_grandfather_bw) && $father_grandfather_bw->value != ""){
							$father_grandfather_birthweight = $father_grandfather_bw->value;
						}
						else{
							$father_grandfather_birthweight = 0;
						}

						$father_grandfather_group = $father_grandfather->getGrouping();

						if(!is_null($father_grandfather_group)){
							$father_grandfather_greatgrandfather = $father_grandfather_group->getFather();
							$father_grandfather_greatgrandmother = $father_grandfather_group->getMother();
							$father_grandfather_groupingmembers = $father_grandfather_group->getGroupingMembers();
							$father_grandfather_parity = $father_grandfather_group->getGroupingProperties()->where("property_id", 48)->first()->value;
							$father_grandfather_femalelitters = [];
							$father_grandfather_malelitters = [];

							foreach ($father_grandfather_groupingmembers as $father_grandfather_groupingmember) {
								if(substr($father_grandfather_groupingmember->getChild()->registryid, -7, 1) == 'F'){
									array_push($father_grandfather_femalelitters, $father_grandfather_groupingmember);
								}
								elseif(substr($father_grandfather_groupingmember->getChild()->registryid, -7, 1) == 'M'){
									array_push($father_grandfather_malelitters, $father_grandfather_groupingmember);
								}
							}

							$father_grandfather_greatgrandfather_registryid = $father_grandfather_greatgrandfather->registryid;
							$father_grandfather_greatgrandfather_bday = $father_grandfather_greatgrandfather->getAnimalProperties()->where("property_id", 3)->first();
							$father_grandfather_greatgrandfather_bw = $father_grandfather_greatgrandfather->getAnimalProperties()->where("property_id", 5)->first();
							if(!is_null($father_grandfather_greatgrandfather_bday) && $father_grandfather_greatgrandfather_bday->value != "Not specified"){
								$father_grandfather_greatgrandfather_birthday = Carbon::parse($father_grandfather_greatgrandfather_bday->value)->format('Y-m-d');
							}
							else{
								$father_grandfather_greatgrandfather_birthday = null;
							}
							if(!is_null($father_grandfather_greatgrandfather_bw) && $father_grandfather_greatgrandfather_bw->value != ""){
								$father_grandfather_greatgrandfather_birthweight = $father_grandfather_greatgrandfather_bw->value;
							}
							else{
								$father_grandfather_greatgrandfather_birthweight = 0;
							}

							$father_grandfather_greatgrandmother_registryid = $father_grandfather_greatgrandmother->registryid;
							$father_grandfather_greatgrandmother_bday = $father_grandfather_greatgrandmother->getAnimalProperties()->where("property_id", 3)->first();
							$father_grandfather_greatgrandmother_bw = $father_grandfather_greatgrandmother->getAnimalProperties()->where("property_id", 5)->first();
							if(!is_null($father_grandfather_greatgrandmother_bday) && $father_grandfather_greatgrandmother_bday->value != "Not specified"){
								$father_grandfather_greatgrandmother_birthday = Carbon::parse($father_grandfather_greatgrandmother_bday->value)->format('Y-m-d');
							}
							else{
								$father_grandfather_greatgrandmother_birthday = null;
							}
							if(!is_null($father_grandfather_greatgrandmother_bw) && $father_grandfather_greatgrandmother_bw->value != ""){
								$father_grandfather_greatgrandmother_birthweight = $father_grandfather_greatgrandmother_bw->value;
							}
							else{
								$father_grandfather_greatgrandmother_birthweight = 0;
							}
						}
						else{
							$father_grandfather_group = collect([]);
							$father_grandfather_malelitters = [];
							$father_grandfather_femalelitters = [];
							$father_grandfather_groupingmembers = [];
							$father_grandfather_parity = 0;
							$father_grandfather_greatgrandfather_registryid = null;
							$father_grandfather_greatgrandfather_birthday = null;
							$father_grandfather_greatgrandfather_birthweight = 0;
							$father_grandfather_greatgrandmother_registryid = null;
							$father_grandfather_greatgrandmother_birthday = null;
							$father_grandfather_greatgrandmother_birthweight = 0;
						}

						$father_grandmother_registryid = $father_grandmother->registryid;
						$father_grandmother_bday = $father_grandmother->getAnimalProperties()->where("property_id", 3)->first();
						$father_grandmother_bw = $father_grandmother->getAnimalProperties()->where("property_id", 5)->first();
						if(!is_null($father_grandmother_bday) && $father_grandmother_bday->value != "Not specified"){
							$father_grandmother_birthday = Carbon::parse($father_grandmother_bday->value)->format('Y-m-d');
						}
						else{
							$father_grandmother_birthday = null;
						}
						if(!is_null($father_grandmother_bw) && $father_grandmother_bw->value != ""){
							$father_grandmother_birthweight = $father_grandmother_bw->value;
						}
						else{
							$father_grandmother_birthweight = 0;
						}

						$father_grandmother_group = $father_grandmother->getGrouping();

						if(!is_null($father_grandmother_group)){
							$father_grandmother_greatgrandfather = $father_grandmother_group->getFather();
							$father_grandmother_greatgrandmother = $father_grandmother_group->getMother();
							$father_grandmother_groupingmembers = $father_grandmother_group->getGroupingMembers();
							$father_grandmother_parity = $father_grandmother_group->getGroupingProperties()->where("property_id", 48)->first()->value;
							$father_grandmother_femalelitters = [];
							$father_grandmother_malelitters = [];

							foreach ($father_grandmother_groupingmembers as $father_grandmother_groupingmember) {
								if(substr($father_grandmother_groupingmember->getChild()->registryid, -7, 1) == 'F'){
									array_push($father_grandmother_femalelitters, $father_grandmother_groupingmember);
								}
								elseif(substr($father_grandmother_groupingmember->getChild()->registryid, -7, 1) == 'M'){
									array_push($father_grandmother_malelitters, $father_grandmother_groupingmember);
								}
							}

							$father_grandmother_greatgrandfather_registryid = $father_grandmother_greatgrandfather->registryid;
							$father_grandmother_greatgrandfather_bday = $father_grandmother_greatgrandfather->getAnimalProperties()->where("property_id", 3)->first();
							$father_grandmother_greatgrandfather_bw = $father_grandmother_greatgrandfather->getAnimalProperties()->where("property_id", 5)->first();
							if(!is_null($father_grandmother_greatgrandfather_bday) && $father_grandmother_greatgrandfather_bday->value != "Not specified"){
								$father_grandmother_greatgrandfather_birthday = Carbon::parse($father_grandmother_greatgrandfather_bday->value)->format('Y-m-d');
							}
							else{
								$father_grandmother_greatgrandfather_birthday = null;
							}
							if(!is_null($father_grandmother_greatgrandfather_bw) && $father_grandmother_greatgrandfather_bw->value != ""){
								$father_grandmother_greatgrandfather_birthweight = $father_grandmother_greatgrandfather_bw->value;
							}
							else{
								$father_grandmother_greatgrandfather_birthweight = 0;
							}

							$father_grandmother_greatgrandmother_registryid = $father_grandmother_greatgrandmother->registryid;
							$father_grandmother_greatgrandmother_bday = $father_grandmother_greatgrandmother->getAnimalProperties()->where("property_id", 3)->first();
							$father_grandmother_greatgrandmother_bw = $father_grandmother_greatgrandmother->getAnimalProperties()->where("property_id", 5)->first();
							if(!is_null($father_grandmother_greatgrandmother_bday) && $father_grandmother_greatgrandmother_bday->value != "Not specified"){
								$father_grandmother_greatgrandmother_birthday = Carbon::parse($father_grandmother_greatgrandmother_bday->value)->format('Y-m-d');
							}
							else{
								$father_grandmother_greatgrandmother_birthday = null;
							}
							if(!is_null($father_grandmother_greatgrandmother_bw) && $father_grandmother_greatgrandmother_bw->value != ""){
								$father_grandmother_greatgrandmother_birthweight = $father_grandmother_greatgrandmother_bw->value;
							}
							else{
								$father_grandmother_greatgrandmother_birthweight = 0;
							}
						}
						else{
							$father_grandmother_group = collect([]);
							$father_grandmother_malelitters = [];
							$father_grandmother_femalelitters = [];
							$father_grandmother_groupingmembers = [];
							$father_grandmother_parity = 0;
							$father_grandmother_greatgrandfather_registryid = null;
							$father_grandmother_greatgrandfather_birthday = null;
							$father_grandmother_greatgrandfather_birthweight = 0;
							$father_grandmother_greatgrandmother_registryid = null;
							$father_grandmother_greatgrandmother_birthday = null;
							$father_grandmother_greatgrandmother_birthweight = 0;
						}
					}
					else{
						$father_group = collect([]);
						$father_malelitters = [];
						$father_femalelitters = [];
						$father_groupingmembers = [];
						$father_parity = 0;
						$father_grandfather_registryid = null;
						$father_grandfather_birthday = null;
						$father_grandfather_birthweight = 0;
						$father_grandmother_registryid = null;
						$father_grandmother_birthday = null;
						$father_grandmother_birthweight = 0;
						$father_grandfather_group = collect([]);
						$father_grandfather_malelitters = [];
						$father_grandfather_femalelitters = [];
						$father_grandfather_groupingmembers = [];
						$father_grandfather_parity = 0;
						$father_grandfather_greatgrandfather_registryid = null;
						$father_grandfather_greatgrandfather_birthday = null;
						$father_grandfather_greatgrandfather_birthweight = 0;
						$father_grandfather_greatgrandmother_registryid = null;
						$father_grandfather_greatgrandmother_birthday = null;
						$father_grandfather_greatgrandmother_birthweight = 0;
						$father_grandmother_group = collect([]);
						$father_grandmother_malelitters = [];
						$father_grandmother_femalelitters = [];
						$father_grandmother_groupingmembers = [];
						$father_grandmother_parity = 0;
						$father_grandmother_greatgrandfather_registryid = null;
						$father_grandmother_greatgrandfather_birthday = null;
						$father_grandmother_greatgrandfather_birthweight = 0;
						$father_grandmother_greatgrandmother_registryid = null;
						$father_grandmother_greatgrandmother_birthday = null;
						$father_grandmother_greatgrandmother_birthweight = 0;
					}

					$mother_registryid = $mother->registryid;
					$mother_bday = $mother->getAnimalProperties()->where("property_id", 3)->first();
					$mother_bw = $mother->getAnimalProperties()->where("property_id", 5)->first();
					if(!is_null($mother_bday) && $mother_bday->value != "Not specified"){
						$mother_birthday = Carbon::parse($mother_bday->value)->format('Y-m-d');
					}
					else{
						$mother_birthday = null;
					}
					if(!is_null($mother_bw) && $mother_bw->value != ""){
						$mother_birthweight = $mother_bw->value;
					}
					else{
						$mother_birthweight = 0;
					}

					$mother_group = $mother->getGrouping();

					if(!is_null($mother_group)){
						$mother_grandfather = $mother_group->getFather();
						$mother_grandmother = $mother_group->getMother();
						$mother_groupingmembers = $mother_group->getGroupingMembers();
						$mother_parity = $mother_group->getGroupingProperties()->where("property_id", 48)->first()->value;
						$mother_femalelitters = [];
						$mother_malelitters = [];

						foreach ($mother_groupingmembers as $mother_groupingmember) {
							if(substr($mother_groupingmember->getChild()->registryid, -7, 1) == 'F'){
								array_push($mother_femalelitters, $mother_groupingmember);
							}
							elseif(substr($mother_groupingmember->getChild()->registryid, -7, 1) == 'M'){
								array_push($mother_malelitters, $mother_groupingmember);
							}
						}

						$mother_grandfather_registryid = $mother_grandfather->registryid;
						$mother_grandfather_bday = $mother_grandfather->getAnimalProperties()->where("property_id", 3)->first();
						$mother_grandfather_bw = $mother_grandfather->getAnimalProperties()->where("property_id", 5)->first();
						if(!is_null($mother_grandfather_bday) && $mother_grandfather_bday->value != "Not specified"){
							$mother_grandfather_birthday = Carbon::parse($mother_grandfather_bday->value)->format('Y-m-d');
						}
						else{
							$mother_grandfather_birthday = null;
						}
						if(!is_null($mother_grandfather_bw) && $mother_grandfather_bw->value != ""){
							$mother_grandfather_birthweight = $mother_grandfather_bw->value;
						}
						else{
							$mother_grandfather_birthweight = 0;
						}

						$mother_grandfather_group = $mother_grandfather->getGrouping();
						if(!is_null($mother_grandfather_group)){
							$mother_grandfather_greatgrandfather = $mother_grandfather_group->getFather();
							$mother_grandfather_greatgrandmother = $mother_grandfather_group->getMother();
							$mother_grandfather_groupingmembers = $mother_grandfather_group->getGroupingMembers();
							$mother_grandfather_parity = $mother_grandfather_group->getGroupingProperties()->where("property_id", 48)->first()->value;
							$mother_grandfather_femalelitters = [];
							$mother_grandfather_malelitters = [];

							foreach ($mother_grandfather_groupingmembers as $mother_grandfather_groupingmember) {
								if(substr($mother_grandfather_groupingmember->getChild()->registryid, -7, 1) == 'F'){
									array_push($mother_grandfather_femalelitters, $mother_grandfather_groupingmember);
								}
								elseif(substr($mother_grandfather_groupingmember->getChild()->registryid, -7, 1) == 'M'){
									array_push($mother_grandfather_malelitters, $mother_grandfather_groupingmember);
								}
							}

							$mother_grandfather_greatgrandfather_registryid = $mother_grandfather_greatgrandfather->registryid;
							$mother_grandfather_greatgrandfather_bday = $mother_grandfather_greatgrandfather->getAnimalProperties()->where("property_id", 3)->first();
							$mother_grandfather_greatgrandfather_bw = $mother_grandfather_greatgrandfather->getAnimalProperties()->where("property_id", 5)->first();
							if(!is_null($mother_grandfather_greatgrandfather_bday) && $mother_grandfather_greatgrandfather_bday->value != "Not specified"){
								$mother_grandfather_greatgrandfather_birthday = Carbon::parse($mother_grandfather_greatgrandfather_bday->value)->format('Y-m-d');
							}
							else{
								$mother_grandfather_greatgrandfather_birthday = null;
							}
							if(!is_null($mother_grandfather_greatgrandfather_bw) && $mother_grandfather_greatgrandfather_bw->value != ""){
								$mother_grandfather_greatgrandfather_birthweight = $mother_grandfather_greatgrandfather_bw->value;
							}
							else{
								$mother_grandfather_greatgrandfather_birthweight = 0;
							}

							$mother_grandfather_greatgrandmother_registryid = $mother_grandfather_greatgrandmother->registryid;
							$mother_grandfather_greatgrandmother_bday = $mother_grandfather_greatgrandmother->getAnimalProperties()->where("property_id", 3)->first();
							$mother_grandfather_greatgrandmother_bw = $mother_grandfather_greatgrandmother->getAnimalProperties()->where("property_id", 5)->first();
							if(!is_null($mother_grandfather_greatgrandmother_bday) && $mother_grandfather_greatgrandmother_bday->value != "Not specified"){
								$mother_grandfather_greatgrandmother_birthday = Carbon::parse($mother_grandfather_greatgrandmother_bday->value)->format('Y-m-d');
							}
							else{
								$mother_grandfather_greatgrandmother_birthday = null;
							}
							if(!is_null($mother_grandfather_greatgrandmother_bw) && $mother_grandfather_greatgrandmother_bw->value != ""){
								$mother_grandfather_greatgrandmother_birthweight = $mother_grandfather_greatgrandmother_bw->value;
							}
							else{
								$mother_grandfather_greatgrandmother_birthweight = 0;
							}
						}
						else{
							$mother_grandfather_group = collect([]);
							$mother_grandfather_malelitters = [];
							$mother_grandfather_femalelitters = [];
							$mother_grandfather_groupingmembers = [];
							$mother_grandfather_parity = 0;
							$mother_grandfather_greatgrandfather_registryid = null;
							$mother_grandfather_greatgrandfather_birthday = null;
							$mother_grandfather_greatgrandfather_birthweight = 0;
							$mother_grandfather_greatgrandmother_registryid = null;
							$mother_grandfather_greatgrandmother_birthday = null;
							$mother_grandfather_greatgrandmother_birthweight = 0;
						}

						$mother_grandmother_registryid = $mother_grandmother->registryid;
						$mother_grandmother_bday = $mother_grandmother->getAnimalProperties()->where("property_id", 3)->first();
						$mother_grandmother_bw = $mother_grandmother->getAnimalProperties()->where("property_id", 5)->first();
						if(!is_null($mother_grandmother_bday) && $mother_grandmother_bday->value != "Not specified"){
							$mother_grandmother_birthday = Carbon::parse($mother_grandmother_bday->value)->format('Y-m-d');
						}
						else{
							$mother_grandmother_birthday = null;
						}
						if(!is_null($mother_grandmother_bw) && $mother_grandmother_bw->value != ""){
							$mother_grandmother_birthweight = $mother_grandmother_bw->value;
						}
						else{
							$mother_grandmother_birthweight = 0;
						}

						$mother_grandmother_group = $mother_grandmother->getGrouping();

						if(!is_null($mother_grandmother_group)){
							$mother_grandmother_greatgrandfather = $mother_grandmother_group->getFather();
							$mother_grandmother_greatgrandmother = $mother_grandmother_group->getMother();
							$mother_grandmother_groupingmembers = $mother_grandmother_group->getGroupingMembers();
							$mother_grandmother_parity = $mother_grandmother_group->getGroupingProperties()->where("property_id", 48)->first()->value;
							$mother_grandmother_femalelitters = [];
							$mother_grandmother_malelitters = [];

							foreach ($mother_grandmother_groupingmembers as $mother_grandmother_groupingmember) {
								if(substr($mother_grandmother_groupingmember->getChild()->registryid, -7, 1) == 'F'){
									array_push($mother_grandmother_femalelitters, $mother_grandmother_groupingmember);
								}
								elseif(substr($mother_grandmother_groupingmember->getChild()->registryid, -7, 1) == 'M'){
									array_push($mother_grandmother_malelitters, $mother_grandmother_groupingmember);
								}
							}

							$mother_grandmother_greatgrandfather_registryid = $mother_grandmother_greatgrandfather->registryid;
							$mother_grandmother_greatgrandfather_bday = $mother_grandmother_greatgrandfather->getAnimalProperties()->where("property_id", 3)->first();
							$mother_grandmother_greatgrandfather_bw = $mother_grandmother_greatgrandfather->getAnimalProperties()->where("property_id", 5)->first();
							if(!is_null($mother_grandmother_greatgrandfather_bday) && $mother_grandmother_greatgrandfather_bday->value != "Not specified"){
								$mother_grandmother_greatgrandfather_birthday = Carbon::parse($mother_grandmother_greatgrandfather_bday->value)->format('Y-m-d');
							}
							else{
								$mother_grandmother_greatgrandfather_birthday = null;
							}
							if(!is_null($mother_grandmother_greatgrandfather_bw) && $mother_grandmother_greatgrandfather_bw->value != ""){
								$mother_grandmother_greatgrandfather_birthweight = $mother_grandmother_greatgrandfather_bw->value;
							}
							else{
								$mother_grandmother_greatgrandfather_birthweight = 0;
							}

							$mother_grandmother_greatgrandmother_registryid = $mother_grandmother_greatgrandmother->registryid;
							$mother_grandmother_greatgrandmother_bday = $mother_grandmother_greatgrandmother->getAnimalProperties()->where("property_id", 3)->first();
							$mother_grandmother_greatgrandmother_bw = $mother_grandmother_greatgrandmother->getAnimalProperties()->where("property_id", 5)->first();
							if(!is_null($mother_grandmother_greatgrandmother_bday) && $mother_grandmother_greatgrandmother_bday->value != "Not specified"){
								$mother_grandmother_greatgrandmother_birthday = Carbon::parse($mother_grandmother_greatgrandmother_bday->value)->format('Y-m-d');
							}
							else{
								$mother_grandmother_greatgrandmother_birthday = null;
							}
							if(!is_null($father_grandmother_greatgrandmother_bw) && $father_grandmother_greatgrandmother_bw->value != ""){
								$mother_grandmother_greatgrandmother_birthweight = $father_grandmother_greatgrandmother_bw->value;
							}
							else{
								$mother_grandmother_greatgrandmother_birthweight = 0;
							}
						}
						else{
							$mother_grandmother_group = collect([]);
							$mother_grandmother_malelitters = [];
							$mother_grandmother_femalelitters = [];
							$mother_grandmother_groupingmembers = [];
							$mother_grandmother_parity = 0;
							$mother_grandmother_greatgrandfather_registryid = null;
							$mother_grandmother_greatgrandfather_birthday = null;
							$mother_grandmother_greatgrandfather_birthweight = 0;
							$mother_grandmother_greatgrandmother_registryid = null;
							$mother_grandmother_greatgrandmother_birthday = null;
							$mother_grandmother_greatgrandmother_birthweight = 0;
						}
					}
					else{
						$mother_group = collect([]);
						$mother_malelitters = [];
						$mother_femalelitters = [];
						$mother_groupingmembers = [];
						$mother_parity = 0;
						$mother_grandfather_registryid = null;
						$mother_grandfather_birthday = null;
						$mother_grandfather_birthweight = 0;
						$mother_grandmother_registryid = null;
						$mother_grandmother_birthday = null;
						$mother_grandmother_birthweight = 0;
						$mother_grandfather_group = collect([]);
						$mother_grandfather_malelitters = [];
						$mother_grandfather_femalelitters = [];
						$mother_grandfather_groupingmembers = [];
						$mother_grandfather_parity = 0;
						$mother_grandfather_greatgrandfather_registryid = null;
						$mother_grandfather_greatgrandfather_birthday = null;
						$mother_grandfather_greatgrandfather_birthweight = 0;
						$mother_grandfather_greatgrandmother_registryid = null;
						$mother_grandfather_greatgrandmother_birthday = null;
						$mother_grandfather_greatgrandmother_birthweight = 0;
						$mother_grandmother_group = collect([]);
						$mother_grandmother_malelitters = [];
						$mother_grandmother_femalelitters = [];
						$mother_grandmother_groupingmembers = [];
						$mother_grandmother_parity = 0;
						$mother_grandmother_greatgrandfather_registryid = null;
						$mother_grandmother_greatgrandfather_birthday = null;
						$mother_grandmother_greatgrandfather_birthweight = 0;
						$mother_grandmother_greatgrandmother_registryid = null;
						$mother_grandmother_greatgrandmother_birthday = null;
						$mother_grandmother_greatgrandmother_birthweight = 0;
					}
				}
				else{
					$group = collect([]);
					$parity = 0;
					$groupingmembers = [];
					$femalelitters = [];
					$malelitters = [];
					$father_registryid = null;
					$father_birthday = null;
					$father_birthweight = 0;
					$father_group = collect([]);
					$father_malelitters = [];
					$father_femalelitters = [];
					$father_groupingmembers = [];
					$father_parity = 0;
					$father_grandfather_registryid = null;
					$father_grandfather_birthday = null;
					$father_grandfather_birthweight = 0;
					$father_grandmother_registryid = null;
					$father_grandmother_birthday = null;
					$father_grandmother_birthweight = 0;
					$father_grandfather_group = collect([]);
					$father_grandfather_malelitters = [];
					$father_grandfather_femalelitters = [];
					$father_grandfather_groupingmembers = [];
					$father_grandfather_parity = 0;
					$father_grandfather_greatgrandfather_registryid = null;
					$father_grandfather_greatgrandfather_birthday = null;
					$father_grandfather_greatgrandfather_birthweight = 0;
					$father_grandfather_greatgrandmother_registryid = null;
					$father_grandfather_greatgrandmother_birthday = null;
					$father_grandfather_greatgrandmother_birthweight = 0;
					$father_grandmother_group = collect([]);
					$father_grandmother_malelitters = [];
					$father_grandmother_femalelitters = [];
					$father_grandmother_groupingmembers = [];
					$father_grandmother_parity = 0;
					$father_grandmother_greatgrandfather_registryid = null;
					$father_grandmother_greatgrandfather_birthday = null;
					$father_grandmother_greatgrandfather_birthweight = 0;
					$father_grandmother_greatgrandmother_registryid = null;
					$father_grandmother_greatgrandmother_birthday = null;
					$father_grandmother_greatgrandmother_birthweight = 0;
					$mother_registryid = null;
					$mother_birthday = null;
					$mother_birthweight = 0;
					$mother_group = collect([]);
					$mother_malelitters = [];
					$mother_femalelitters = [];
					$mother_groupingmembers = [];
					$mother_parity = 0;
					$mother_grandfather_registryid = null;
					$mother_grandfather_birthday = null;
					$mother_grandfather_birthweight = 0;
					$mother_grandmother_registryid = null;
					$mother_grandmother_birthday = null;
					$mother_grandmother_birthweight = 0;
					$mother_grandfather_group = collect([]);
					$mother_grandfather_malelitters = [];
					$mother_grandfather_femalelitters = [];
					$mother_grandfather_groupingmembers = [];
					$mother_grandfather_parity = 0;
					$mother_grandfather_greatgrandfather_registryid = null;
					$mother_grandfather_greatgrandfather_birthday = null;
					$mother_grandfather_greatgrandfather_birthweight = 0;
					$mother_grandfather_greatgrandmother_registryid = null;
					$mother_grandfather_greatgrandmother_birthday = null;
					$mother_grandfather_greatgrandmother_birthweight = 0;
					$mother_grandmother_group = collect([]);
					$mother_grandmother_malelitters = [];
					$mother_grandmother_femalelitters = [];
					$mother_grandmother_groupingmembers = [];
					$mother_grandmother_parity = 0;
					$mother_grandmother_greatgrandfather_registryid = null;
					$mother_grandmother_greatgrandfather_birthday = null;
					$mother_grandmother_greatgrandfather_birthweight = 0;
					$mother_grandmother_greatgrandmother_registryid = null;
					$mother_grandmother_greatgrandmother_birthday = null;
					$mother_grandmother_greatgrandmother_birthweight = 0;
				}
			}
			else{
				$animal = collect([]);
				$registrationid = null;
				$sex = null;
				$birthday = null;
				$birthweight = 0;
				$group = collect([]);
				$groupingmembers = [];
				$femalelitters = [];
				$malelitters = [];
				$parity = 0;
				$father_registryid = null;
				$father_birthday = null;
				$father_birthweight = 0;
				$father_group = collect([]);
				$father_malelitters = [];
				$father_femalelitters = [];
				$father_groupingmembers = [];
				$father_parity = 0;
				$father_grandfather_registryid = null;
				$father_grandfather_birthday = null;
				$father_grandfather_birthweight = 0;
				$father_grandfather_group = collect([]);
				$father_grandfather_malelitters = [];
				$father_grandfather_femalelitters = [];
				$father_grandfather_groupingmembers = [];
				$father_grandfather_parity = 0;
				$father_grandfather_greatgrandfather_registryid = null;
				$father_grandfather_greatgrandfather_birthday = null;
				$father_grandfather_greatgrandfather_birthweight = 0;
				$father_grandfather_greatgrandmother_registryid = null;
				$father_grandfather_greatgrandmother_birthday = null;
				$father_grandfather_greatgrandmother_birthweight = 0;
				$father_grandmother_registryid = null;
				$father_grandmother_birthday = null;
				$father_grandmother_birthweight = 0;
				$father_grandmother_group = collect([]);
				$father_grandmother_malelitters = [];
				$father_grandmother_femalelitters = [];
				$father_grandmother_groupingmembers = [];
				$father_grandmother_parity = 0;
				$father_grandmother_greatgrandfather_registryid = null;
				$father_grandmother_greatgrandfather_birthday = null;
				$father_grandmother_greatgrandfather_birthweight = 0;
				$father_grandmother_greatgrandmother_registryid = null;
				$father_grandmother_greatgrandmother_birthday = null;
				$father_grandmother_greatgrandmother_birthweight = 0;
				$mother_registryid = null;
				$mother_birthday = null;
				$mother_birthweight = 0;
				$mother_group = collect([]);
				$mother_malelitters = [];
				$mother_femalelitters = [];
				$mother_groupingmembers = [];
				$mother_parity = 0;
				$mother_grandfather_registryid = null;
				$mother_grandfather_birthday = null;
				$mother_grandfather_birthweight = 0;
				$mother_grandfather_group = collect([]);
				$mother_grandfather_malelitters = [];
				$mother_grandfather_femalelitters = [];
				$mother_grandfather_groupingmembers = [];
				$mother_grandfather_parity = 0;
				$mother_grandfather_greatgrandfather_registryid = null;
				$mother_grandfather_greatgrandfather_birthday = null;
				$mother_grandfather_greatgrandfather_birthweight = 0;
				$mother_grandfather_greatgrandmother_registryid = null;
				$mother_grandfather_greatgrandmother_birthday = null;
				$mother_grandfather_greatgrandmother_birthweight = 0;
				$mother_grandmother_registryid = null;
				$mother_grandmother_birthday = null;
				$mother_grandmother_birthweight = 0;
				$mother_grandmother_group = collect([]);
				$mother_grandmother_malelitters = [];
				$mother_grandmother_femalelitters = [];
				$mother_grandmother_groupingmembers = [];
				$mother_grandmother_parity = 0;
				$mother_grandmother_greatgrandfather_registryid = null;
				$mother_grandmother_greatgrandfather_birthday = null;
				$mother_grandmother_greatgrandfather_birthweight = 0;
				$mother_grandmother_greatgrandmother_registryid = null;
				$mother_grandmother_greatgrandmother_birthday = null;
				$mother_grandmother_greatgrandmother_birthweight = 0;
			}


			return view('pigs.pedigree', compact('animal', 'registrationid', 'user', 'breed', 'sex', 'birthday', 'birthweight', 'group', 'malelitters', 'femalelitters', 'groupingmembers', 'parity', 'father_registryid', 'father_birthday', 'father_birthweight', 'father_group', 'father_malelitters', 'father_femalelitters', 'father_groupingmembers', 'father_parity', 'father_grandfather_registryid', 'father_grandfather_birthday', 'father_grandfather_birthweight', 'father_grandfather_group', 'father_grandfather_malelitters', 'father_grandfather_femalelitters', 'father_grandfather_groupingmembers', 'father_grandfather_parity', 'father_grandfather_greatgrandfather_registryid', 'father_grandfather_greatgrandfather_birthday', 'father_grandfather_greatgrandfather_birthweight', 'father_grandfather_greatgrandmother_registryid', 'father_grandfather_greatgrandmother_birthday', 'father_grandfather_greatgrandmother_birthweight', 'father_grandmother_registryid', 'father_grandmother_birthday', 'father_grandmother_birthweight', 'father_grandmother_group', 'father_grandmother_malelitters', 'father_grandmother_femalelitters', 'father_grandmother_groupingmembers', 'father_grandmother_parity', 'father_grandmother_greatgrandfather_registryid', 'father_grandmother_greatgrandfather_birthday', 'father_grandmother_greatgrandfather_birthweight', 'father_grandmother_greatgrandmother_registryid', 'father_grandmother_greatgrandmother_birthday', 'father_grandmother_greatgrandmother_birthweight', 'mother_registryid', 'mother_birthday', 'mother_birthweight', 'mother_group', 'mother_malelitters', 'mother_femalelitters', 'mother_groupingmembers', 'mother_parity', 'mother_grandfather_registryid', 'mother_grandfather_birthday', 'mother_grandfather_birthweight', 'mother_grandfather_group', 'mother_grandfather_malelitters', 'mother_grandfather_femalelitters', 'mother_grandfather_groupingmembers', 'mother_grandfather_parity', 'mother_grandfather_greatgrandfather_registryid', 'mother_grandfather_greatgrandfather_birthday', 'mother_grandfather_greatgrandfather_birthweight', 'mother_grandfather_greatgrandmother_registryid', 'mother_grandfather_greatgrandmother_birthday', 'mother_grandfather_greatgrandmother_birthweight', 'mother_grandmother_registryid', 'mother_grandmother_birthday', 'mother_grandmother_birthweight', 'mother_grandmother_group', 'mother_grandmother_malelitters', 'mother_grandmother_femalelitters', 'mother_grandmother_groupingmembers', 'mother_grandmother_parity', 'mother_grandmother_greatgrandfather_registryid', 'mother_grandmother_greatgrandfather_birthday', 'mother_grandmother_greatgrandfather_birthweight', 'mother_grandmother_greatgrandmother_registryid', 'mother_grandmother_greatgrandmother_birthday', 'mother_grandmother_greatgrandmother_birthweight', 'found_pigs'));
		}

		public function fetchDateFarrowedAjax($familyidvalue, $datefarrowedvalue){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$grouping = Grouping::find($familyidvalue);
			$datefarrowedgroupprop = $grouping->getGroupingProperties()->where("property_id", 3)->first();

			$formatted_date = Carbon::parse($datefarrowedvalue)->format('Y-m-d');

			$datefarrowedgroupprop->value = $formatted_date;
			$datefarrowedgroupprop->save();

			$offsprings = $grouping->getGroupingMembers();

			foreach ($offsprings as $offspring) {
				$datefarrowedindprop = $offspring->getAnimalProperties()->where("property_id", 3)->first();

				$datefarrowedindprop->value = $formatted_date;
				$datefarrowedindprop->save();

				$earnotchprop = $offspring->getAnimalProperties()->where("property_id", 1)->first();
				$sexprop = $offspring->getAnimalProperties()->where("property_id", 2)->first();
				$registryidprop = $offspring->getAnimalProperties()->where("property_id", 4)->first();

				$year = Carbon::parse($datefarrowedvalue)->format('Y');
				$registryid = $farm->code.$breed->breed."-".$year.$sexprop->value.$earnotchprop->value;

				$registryidprop->value = $registryid;
				$registryidprop->save();
				
				$actual_offspring = $offspring->getChild();
				$actual_offspring->registryid = $registryid;
				$actual_offspring->save();
			}
		}

		public function fetchDateWeanedAjax($familyidvalue, $dateweanedvalue){
			$grouping = Grouping::find($familyidvalue);
			$dateweanedgroupprop = $grouping->getGroupingProperties()->where("property_id", 6)->first();

			$formatted_date = Carbon::parse($dateweanedvalue)->format('Y-m-d');

			$dateweanedgroupprop->value = $formatted_date;
			$dateweanedgroupprop->save();

			$offsprings = $grouping->getGroupingMembers();

			foreach ($offsprings as $offspring) {
				$dateweanedindprop = $offspring->getAnimalProperties()->where("property_id", 6)->first();

				$dateweanedindprop->value = $formatted_date;
				$dateweanedindprop->save();
			}
		}

		public function fetchParityAjax($familyidvalue, $parityvalue){ // function to save parity onchange
			$grouping = Grouping::find($familyidvalue);
			$paritypropgroup = $grouping->getGroupingProperties()->where("property_id", 48)->first();

			$paritypropgroup->value = $parityvalue;
			$paritypropgroup->save();
		}

		public function fetchStillbornAjax($familyidvalue, $stillbornvalue){ // function to save number stillborn onchange
			$grouping = Grouping::find($familyidvalue);
			$stillbornprop = $grouping->getGroupingProperties()->where("property_id", 45)->first();

			$stillbornprop->value = $stillbornvalue;
			$stillbornprop->save();
		}

		public function fetchMummifiedAjax($familyidvalue, $mummifiedvalue){ // function to save number mummified onchange
			$grouping = Grouping::find($familyidvalue);
			$mummifiedprop = $grouping->getGroupingProperties()->where("property_id", 46)->first();

			$mummifiedprop->value = $mummifiedvalue;
			$mummifiedprop->save();
		}

		static function addParityMother($id){
			$grouping = Grouping::find($id);
			Log::debug("grouping ".json_encode($grouping)." for ".$id);
			$mother = $grouping->getMother();

			$parityprop = $mother->getAnimalProperties()->where("property_id", 48)->first();
			$paritypropgroup = $grouping->getGroupingProperties()->where("property_id", 48)->first();
			$status = $grouping->getGroupingProperties()->where("property_id", 60)->first();
			$families = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
							->whereNotNull("mother_id")
							->where("groupings.breed_id", $mother->id)
							->where("animals.farm_id", $mother->id)
							->get();

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

		public function sowLitterRecordDownloadPDF($id){
			$family = Grouping::find($id);
			$properties = $family->getGroupingProperties();
			$offsprings = $family->getGroupingMembers();

			// counts offsprings per sex
			$countMales = 0;
			$countFemales = 0;
			foreach ($offsprings as $offspring) {
				$propscount = $offspring->getAnimalProperties();
				foreach ($propscount as $propcount) {
					if($propcount->property_id == 2){ //sex
						if($propcount->value == 'M'){
							$countMales = $countMales + 1;
						}
						if($propcount->value == 'F'){
							$countFemales = $countFemales + 1;
						}
					}
				}
			}

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
			$stillbornprop = $properties->where("property_id", 45)->first();
			$mummifiedprop = $properties->where("property_id", 46)->first();
			$preweaningmortprop = $properties->where("property_id", 59)->first();
			$dead = [];
			if(!is_null($dateweanedprop) && $dateweanedprop->value != "Not specified"){
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
			elseif(is_null($dateweanedprop)){
				if(!is_null($properties->where("property_id", 3)->first())){
					if(count($offsprings) == 0 && ($stillbornprop->value >= 0 || $mummifiedprop->value >= 0)){
						$dateweaned = new GroupingProperty;
						$dateweaned->grouping_id = $family->id;
						$dateweaned->property_id = 6;
						$dateweaned->value = "Not specified";
						$dateweaned->save();
					}
					elseif(count($offsprings) > 0){
						foreach ($offsprings as $offspring) {
							if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower"){
								array_push($dead, "1");
							}
							else{
								array_push($dead, "0");
							}
						}

						if(!in_array("0", $dead, false)){
							$dateweaned = new GroupingProperty;
							$dateweaned->grouping_id = $family->id;
							$dateweaned->property_id = 6;
							$dateweaned->value = "Not specified";
							$dateweaned->save();
						}
					}
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

			if(!is_null($datefarrowedprop) && (!is_null($dateweanedprop) && $dateweanedprop->value != "Not specified") ){
				$datefarrowed = Carbon::parse($datefarrowedprop->value);
				$dateweaned = Carbon::parse($dateweanedprop->value);
				$lactationperiod = $dateweaned->diffInDays($datefarrowed);
			}
			else{
				$lactationperiod = "";
			}

			$now = Carbon::now('Asia/Manila');

			$pdf = PDF::loadView('pigs.sowlitterpdf', compact('family', 'offsprings', 'properties', 'countMales', 'countFemales', 'aveBirthWeight', 'weaned', 'aveWeaningWeight', 'gestationperiod', 'lactationperiod', 'now'));

			return $pdf->download('sowlitterrecord_'.$id.'_'.$now.'.pdf');
		}

		public function sowLitterRecordDownloadCSV($id){
			$family = Grouping::find($id);
			$properties = $family->getGroupingProperties();
			$offsprings = $family->getGroupingMembers();

			$now = Carbon::now('Asia/Manila');

			return Excel::create('sowlitterrecord_'.$id.'_'.$now, function($excel) use ($family, $offsprings, $properties, $now) {
				$excel->setTitle('Sow and Litter Record of '.$family->getMother()->registryid.' and '.$family->getFather()->registryid);
				$excel->sheet('SowAndLitterRecord', function($sheet) use ($family, $offsprings, $properties, $now) {
					$sheet->setOrientation('landscape');
					$sheet->row(1, array(
						'Sow Used', $family->getMother()->registryid, 'Date Bred', Carbon::parse($properties->where("property_id", 42)->first()->value)->format('F j, Y')
					));
					if(!is_null($properties->where("property_id", 3)->first()) && $properties->where("property_id", 3)->first()->value != "Not specified"){
						$sheet->row(2, array(
							'Boar Used', $family->getFather()->registryid, 'Date Farrowed', Carbon::parse($properties->where("property_id", 3)->first()->value)->format('F j, Y')
						));
					}
					else{
						$sheet->row(2, array(
							'Boar Used', $family->getFather()->registryid, 'Date Farrowed', 'No data available yet'
						));
					}
					if(!is_null($properties->where("property_id", 48)->first()) && (!is_null($properties->where("property_id", 6)->first()) && $properties->where("property_id", 6)->first()->value != "Not specified")){
						$sheet->row(3, array(
							'Parity', $properties->where("property_id", 48)->first()->value, 'Date Weaned', Carbon::parse($properties->where("property_id", 6)->first()->value)->format('F j, Y')
						));
					}
					elseif(!is_null($properties->where("property_id", 48)->first()) && is_null($properties->where("property_id", 6)->first())){
						$sheet->row(3, array(
							'Parity', $properties->where("property_id", 48)->first()->value, 'Date Weaned', 'No data available yet'
						));
					}
					elseif(is_null($properties->where("property_id", 48)->first()) && (!is_null($properties->where("property_id", 6)->first()) && $properties->where("property_id", 6)->first()->value != "Not specified")){
						$sheet->row(3, array(
							'Parity', 'Not specified', 'Date Weaned', Carbon::parse($properties->where("property_id", 6)->first()->value)->format('F j, Y')
						));
					}
					elseif(is_null($properties->where("property_id", 48)->first()) && is_null($properties->where("property_id", 6)->first())){
						$sheet->row(3, array(
							'Parity', 'Not specified', 'Date Weaned', 'No data available yet'
						));
					}
					if(is_null($properties->where("property_id", 45)->first()) && is_null($properties->where("property_id", 46)->first())){
						$sheet->row(4, array(
							'Number Stillborn', 'No data available yet', 'Number mummified', 'No data available yet'
						));
					}
					elseif(!is_null($properties->where("property_id", 45)->first()) && !is_null($properties->where("property_id", 46)->first())){
						$sheet->row(4, array(
							'Number Stillborn', $properties->where("property_id", 45)->first()->value, 'Number mummified', $properties->where("property_id", 46)->first()->value
						));
					}
					if(is_null($properties->where("property_id", 49)->first()) && is_null($properties->where("property_id", 50)->first())){
						$sheet->row(5, array(
							'Total Littersize Born', 'No data available yet', 'Total Littersize Born Alive', 'No data available yet'
						));
					}
					elseif(!is_null($properties->where("property_id", 49)->first()) && !is_null($properties->where("property_id", 50)->first())){
						$sheet->row(5, array(
							'Total Littersize Born', $properties->where("property_id", 49)->first()->value, 'Total Littersize Born Alive', $properties->where("property_id", 50)->first()->value
						));
					}
					if(is_null($properties->where("property_id", 51)->first()) && is_null($properties->where("property_id", 52)->first())){
						$sheet->row(6, array(
							'Number of Males Born', 'No data available yet', 'Number of Females Born', 'No data available yet'
						));
					}
					elseif(!is_null($properties->where("property_id", 51)->first()) && !is_null($properties->where("property_id", 52)->first())){
						$sheet->row(6, array(
							'Number of Males Born', $properties->where("property_id", 51)->first()->value, 'Number of Females Born', $properties->where("property_id", 52)->first()->value
						));
					}
					if(is_null($properties->where("property_id", 53)->first()) && is_null($properties->where("property_id", 56)->first())){
						$sheet->row(7, array(
							'Sex Ratio (Male to Female)', 'No data available yet', 'Average Birth Weight', 'No data available yet'
						));
					}
					elseif(!is_null($properties->where("property_id", 53)->first()) && !is_null($properties->where("property_id", 56)->first())){
						$sheet->row(7, array(
							'Sex Ratio (Male to Female)', $properties->where("property_id", 53)->first()->value, 'Average Birth Weight', round($properties->where("property_id", 56)->first()->value, 3)
						));
					}
					if(is_null($properties->where("property_id", 57)->first()) && is_null($properties->where("property_id", 58)->first())){
						$sheet->row(8, array(
							'Number Weaned', 'No data available yet', 'Average Weaning Weight', 'No data available yet'
						));
					}
					elseif(!is_null($properties->where("property_id", 57)->first()) && !is_null($properties->where("property_id", 58)->first())){
						$sheet->row(8, array(
							'Number Weaned', $properties->where("property_id", 57)->first()->value, 'Average Weaning Weight', round($properties->where("property_id", 58)->first()->value, 3)
						));
					}
					$sheet->row(9, array(' '));
					$sheet->row(10, array('Offspring Record'));
					$sheet->row(11, array(
						'Offspring ID', 'Sex', 'Birth Weight', 'Weaning Weight'
					));
					
					$i = 12;
					foreach ($offsprings as $offspring) {
						if(!is_null($offspring->getAnimalProperties()->where("property_id", 7)->first())){
							$sheet->row($i, array(
								$offspring->getChild()->registryid, $offspring->getAnimalProperties()->where("property_id", 2)->first()->value, $offspring->getAnimalProperties()->where("property_id", 5)->first()->value, $offspring->getAnimalProperties()->where("property_id", 7)->first()->value
							));
							$i++;
						}
						else{
							$sheet->row($i, array(
								$offspring->getChild()->registryid, $offspring->getAnimalProperties()->where("property_id", 2)->first()->value, $offspring->getAnimalProperties()->where("property_id", 5)->first()->value, 'No data available yet'
							));
							$i++;
						}
					}
				});
			})->download('csv');
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
					if($propcount->property_id == 2){ //sex
						if($propcount->value == 'M'){
							$countMales = $countMales + 1;
						}
						if($propcount->value == 'F'){
							$countFemales = $countFemales + 1;
						}
					}
				}
			}

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
			$stillbornprop = $properties->where("property_id", 45)->first();
			$mummifiedprop = $properties->where("property_id", 46)->first();
			$preweaningmortprop = $properties->where("property_id", 59)->first();
			$dead = [];
			if(!is_null($dateweanedprop) && $dateweanedprop->value != "Not specified"){
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
			elseif(is_null($dateweanedprop)){
				if(!is_null($properties->where("property_id", 3)->first())){
					if(count($offsprings) == 0 && ($stillbornprop->value >= 0 || $mummifiedprop->value >= 0)){
						$dateweaned = new GroupingProperty;
						$dateweaned->grouping_id = $family->id;
						$dateweaned->property_id = 6;
						$dateweaned->value = "Not specified";
						$dateweaned->save();
					}
					elseif(count($offsprings) > 0){
						foreach ($offsprings as $offspring) {
							if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower"){
								array_push($dead, "1");
							}
							else{
								array_push($dead, "0");
							}
						}

						if(!in_array("0", $dead, false)){
							$dateweaned = new GroupingProperty;
							$dateweaned->grouping_id = $family->id;
							$dateweaned->property_id = 6;
							$dateweaned->value = "Not specified";
							$dateweaned->save();
						}
					}
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
				$gestationperiod = $datefarrowed->diffInDays($datebred) . " [debug: datebred=$datebred datefarrowed=$datefarrowed]";
			}
			else{
				$gestationperiod = "";
			}

			if(!is_null($datefarrowedprop) && (!is_null($dateweanedprop) && $dateweanedprop->value != "Not specified")){
				$datefarrowed = Carbon::parse($datefarrowedprop->value);
				$dateweaned = Carbon::parse($dateweanedprop->value);
				$lactationperiod = $dateweaned->diffInDays($datefarrowed);
			}
			else{
				$lactationperiod = "";
			}

			$now = Carbon::now('Asia/Manila');

			return view('pigs.sowlitterrecord', compact('family', 'offsprings', 'properties', 'countMales', 'countFemales', 'aveBirthWeight', 'weaned', 'aveWeaningWeight', 'gestationperiod', 'lactationperiod', 'now'));
		}

		public function getBreedingRecordPage(){ // function to display Breeding Record page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$family = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->join('grouping_properties', 'groupings.id', 'grouping_properties.grouping_id')
								->where("grouping_properties.property_id", 42)
								->select('groupings.*', 'grouping_properties.*', 'groupings.id as id', 'grouping_properties.id as gp_id')
								->orderBy('grouping_properties.value', 'desc')
								->get();
			// dd($groups);


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

			/*$temp = [];
			foreach ($family as $fam) {
				foreach ($sows as $sow) {
					if($fam->mother_id == $sow->id){
						$values = [];
						array_push($values, $fam->registryid);
						array_push($values, $fam->getGroupingProperties()->where("property_id", 60)->first()->value); //status
						array_push($values, $fam->id);
						array_push($values, $fam->getGroupingProperties()->where("property_id", 42)->first()->value); //date bred
						if(!is_null($fam->getGroupingProperties()->where("property_id", 6)->first())){
							array_push($values, $fam->getGroupingProperties()->where("property_id", 6)->first()->value);
						}
						array_push($temp, $values);
					}
				}
			}

			$available_temp = [];
			$available = [];
			foreach ($temp as $value) {
				if($value[1] == "Farrowed"){
					if(array_map('count', $temp) == 5){
						array_push($available_temp, $value[0]);
					}
				}
				elseif($value[1] == "Recycled"){
					array_push($available_temp, $value[0]);
				}
				elseif($value[1] == "Aborted"){
					array_push($available_temp, $value[0]);
				}
			}

			foreach ($sows as $sow) {
				$parity = $sow->getAnimalProperties()->where("property_id", 48)->first();
				if(!is_null($parity)){
					if($parity->value == 0){
						array_push($available_temp, $sow->registryid);
					}
				}
				else{
					array_push($available_temp, $sow->registryid);
				}
			}

			$available = array_unique($available_temp);*/

			// automatically updates mother's parity
			foreach ($groups as $group) {
				static::addParityMother($group->id);
			}

			static::addFrequency();

			// TO FOLLOW: this will be used for filtering results
			$now = Carbon::now('Asia/Manila');
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			return view('pigs.breedingrecord', compact('pigs', 'sows', 'boars', 'femalegrowers', 'malegrowers', 'family', 'years', 'available', 'groups'));
		}

		public function getEditBreedingRecordPage($id){ //function to display edit breeding record page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$family = Grouping::find($id);
			
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
                                ->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$properties = GroupingProperty::where("grouping_id", $id)->get();

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

			$temp = [];
			foreach ($groups as $fam) {
				foreach ($sows as $sow) {
					if($fam->mother_id == $sow->id){
						$values = [];
						array_push($values, $fam->registryid);
						array_push($values, $fam->getGroupingProperties()->where("property_id", 60)->first()->value); //status
						array_push($values, $fam->id);
						array_push($values, $fam->getGroupingProperties()->where("property_id", 42)->first()->value); //date bred
						if(!is_null($fam->getGroupingProperties()->where("property_id", 6)->first())){
							array_push($values, $fam->getGroupingProperties()->where("property_id", 6)->first()->value);
						}
						array_push($temp, $values);
					}
				}
			}

			$available_temp = [];
			$available = [];
			foreach ($temp as $value) {
				if($value[1] == "Farrowed"){
					if(array_map('count', $temp) == 5){
						array_push($available_temp, $value[0]);
					}
				}
				elseif($value[1] == "Recycled"){
					array_push($available_temp, $value[0]);
				}
				elseif($value[1] == "Aborted"){
					array_push($available_temp, $value[0]);
				}
			}

			foreach ($sows as $sow) {
				$parity = $sow->getAnimalProperties()->where("property_id", 48)->first();
				if(!is_null($parity)){
					if($parity->value == 0){
						array_push($available_temp, $sow->registryid);
					}
				}
				else{
					array_push($available_temp, $sow->registryid);
				}
			}

			$available = array_unique($available_temp);

			$now = Carbon::now('Asia/Manila');

			return view('pigs.editbreedingrecord', compact('pigs', 'sows', 'boars', 'family', 'properties', 'now', 'available'));
		}

		public function editBreedingRecord(Request $request){ //function to update breeding record
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$sow = Animal::where("registryid", $request->sow_id)->first();
			$boar = Animal::where("registryid", $request->boar_id)->first();
			$family = Grouping::find($request->grouping_id);
			$properties = GroupingProperty::where("grouping_id", $family->id)->get();

			$family->registryid = $sow->registryid;
			$family->father_id = $boar->id;
			$family->mother_id = $sow->id;
			$family->save();

			if(is_null($request->date_bred)){
				$dateBredValue = new Carbon();
			}
			else{
				$dateBredValue = $request->date_bred;
			}

			$date_bred = $properties->where("property_id", 42)->first();
			$date_bred->value = $dateBredValue;
			$date_bred->save();

			$edfValue = Carbon::parse($dateBredValue)->addDays(114);

			$edf = $properties->where("property_id", 43)->first();
			$edf->value = $edfValue;
			$edf->save();

			$status = $properties->where("property_id", 60)->first();
			$status->value = $request->status;
			$status->save();

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function getMortalityAndSalesPage(){ // function to display Mortality and Sales page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			
			$deadpigs = Mortality::join('animals', 'animals.id', '=', 'mortalities.animal_id')
								->where("mortalities.animaltype_id", 3)
								->where("mortalities.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$soldpigs = Sale::join('animals', 'animals.id', '=', 'sales.animal_id')
							->where("sales.animaltype_id", 3)
							->where("sales.breed_id", $breed->id)
							->where("animals.farm_id", $farm->id)
							->get();

			$removedpigs = RemovedAnimal::join('animals', 'animals.id', '=', 'removed_animals.animal_id')
							->where("removed_animals.animaltype_id", 3)
							->where("animals.farm_id", $farm->id)
							->where("removed_animals.breed_id", $breed->id)
							->get();

			return view('pigs.mortalityandsales', compact('soldpigs', 'deadpigs', 'removedpigs', 'years'));
		}

		public static function getNumPigsBornWithoutYear($filter){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder")
													->orWhere("status", "removed breeder");
													})->get();

			$noyearofbirth = [];

			foreach ($pigs as $pig) {
				if(substr($pig->registryid, -8, 1) == '-'){
					array_push($noyearofbirth, $pig);
				}
			}

			$sows = [];
			$boars = [];
			foreach ($noyearofbirth as $pig) {
				if(substr($pig->registryid, -7, 1) == 'F'){
					array_push($sows, $pig);
				}
				if(substr($pig->registryid, -7, 1) == 'M'){
					array_push($boars, $pig);
				}
			}

			if($filter == "All"){
				return $noyearofbirth;
			}
			elseif($filter == "Sow"){
				return $sows;
			}
			elseif($filter == "Boar"){
				return $boars;
			}
		}

		public static function getNumPigsBornOnYear($year, $filter){ // function to get number of pigs born on specific year
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
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

		public static function getGrossMorphologyWithoutYearOfBirth($property_id, $filter, $value){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder")
													->orWhere("status", "removed breeder");
													})->get();

			$noyearofbirth = [];

			foreach ($pigs as $pig) {
				if(substr($pig->registryid, -8, 1) == '-'){
					array_push($noyearofbirth, $pig);
				}
			}

			$sows = [];
			$boars = [];
			foreach ($noyearofbirth as $pig) {
				if(substr($pig->registryid, -7, 1) == 'F'){
					array_push($sows, $pig);
				}
				if(substr($pig->registryid, -7, 1) == 'M'){
					array_push($boars, $pig);
				}
			}

			if($filter == "All"){ // data returned are for all pigs in the herd
				$grossmorpho = [];
				foreach ($noyearofbirth as $pig) { // traversing all pigs born on specified year
					$properties = $pig->getAnimalProperties();
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
				foreach ($sows as $sow) {
					$properties = $sow->getAnimalProperties();
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
				foreach ($boars as $boar) {
					$properties = $boar->getAnimalProperties();
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

		public static function getGrossMorphologyPerYearOfBirth($year, $property_id, $filter, $value){ // function to get summarized gross morphology report per year of birth
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
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

		public function grossMorphoAllDownloadPDF(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder");
													})->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

			$filter = "All";

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
					if($pigproperty->property_id == 3){ //date farrowed
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

			
			foreach ($alive as $pig) {
				$properties = $pig->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 11){ //hairtype
						if($property->value == "Curly"){
							array_push($curlyhairs, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighthairs, $property);
						}
					}
					if($property->property_id == 12){ //hairlength
						if($property->value == "Short"){
							array_push($shorthairs, $property);
						}
						elseif($property->value == "Long"){
							array_push($longhairs, $property);
						}
					}
					if($property->property_id == 13){ //coatcolor
						if($property->value == "Black"){
							array_push($blackcoats, $property);
						}
						elseif($property->value == "Others"){
							array_push($nonblackcoats, $property);
						}
					}
					if($property->property_id == 14){ //colorpattern
						if($property->value == "Plain"){
							array_push($plains, $property);
						}
						elseif($property->value == "Socks"){
							array_push($socks, $property);
						}
					}
					if($property->property_id == 15){ //headshape
						if($property->value == "Concave"){
							array_push($concaves, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straightheads, $property);
						}
					}
					if($property->property_id == 16){ //skintype
						if($property->value == "Smooth"){
							array_push($smooths, $property);
						}
						elseif($property->value == "Wrinkled"){
							array_push($wrinkleds, $property);
						}
					}
					if($property->property_id == 17){ //eartype
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
					if($property->property_id == 18){ //tailtype
						if($property->value == "Curly"){
							array_push($curlytails, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighttails, $property);
						}
					}
					if($property->property_id == 19){ //backline
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
			$nohairtypes = (count($alive)-(count($curlyhairs)+count($straighthairs)));
			$nohairlengths = (count($alive)-(count($shorthairs)+count($longhairs)));
			$nocoats = (count($alive)-(count($blackcoats)+count($nonblackcoats)));
			$nopatterns = (count($alive)-(count($plains)+count($socks)));
			$noheadshapes = (count($alive)-(count($concaves)+count($straightheads)));
			$noskintypes = (count($alive)-(count($smooths)+count($wrinkleds)));
			$noeartypes = (count($alive)-(count($droopingears)+count($semilops)+count($erectears)));
			$notailtypes = (count($alive)-(count($curlytails)+count($straighttails)));
			$nobacklines = (count($alive)-(count($swaybacks)+count($straightbacks)));

			$now = new Carbon();

			$pdf = PDF::loadView('pigs.grossmorphoallpdf', compact('pigs', 'filter', 'sows', 'boars', 'curlyhairs', 'straighthairs', 'shorthairs', 'longhairs', 'blackcoats', 'nonblackcoats', 'plains', 'socks', 'concaves', 'straightheads', 'smooths', 'wrinkleds', 'droopingears', 'semilops', 'erectears', 'curlytails', 'straighttails', 'swaybacks', 'straightbacks', 'nohairtypes', 'nohairlengths', 'nocoats', 'nopatterns', 'noheadshapes', 'noskintypes', 'noeartypes', 'notailtypes', 'nobacklines', 'years', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars', 'now'));
			return $pdf->download('grossmorphoreport_all_'.$now.'.pdf');
		}

		public function grossMorphoSowDownloadPDF(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder");
													})->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id->where("farm_id", $farm->id))->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

			$filter = "Sow";

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
					if($pigproperty->property_id == 3){ //date farrowed
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
			}
			foreach ($sowsalive as $sowalive) {
				$properties = $sowalive->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 11){ //hairtype
						if($property->value == "Curly"){
							array_push($curlyhairs, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighthairs, $property);
						}
					}
					if($property->property_id == 12){ //hairlength
						if($property->value == "Short"){
							array_push($shorthairs, $property);
						}
						elseif($property->value == "Long"){
							array_push($longhairs, $property);
						}
					}
					if($property->property_id == 13){ //coatcolor
						if($property->value == "Black"){
							array_push($blackcoats, $property);
						}
						elseif($property->value == "Others"){
							array_push($nonblackcoats, $property);
						}
					}
					if($property->property_id == 14){ //colorpattern
						if($property->value == "Plain"){
							array_push($plains, $property);
						}
						elseif($property->value == "Socks"){
							array_push($socks, $property);
						}
					}
					if($property->property_id == 15){ //headshape
						if($property->value == "Concave"){
							array_push($concaves, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straightheads, $property);
						}
					}
					if($property->property_id == 16){ //skintype
						if($property->value == "Smooth"){
							array_push($smooths, $property);
						}
						elseif($property->value == "Wrinkled"){
							array_push($wrinkleds, $property);
						}
					}
					if($property->property_id == 17){ //eartype
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
					if($property->property_id == 18){ //tailtype
						if($property->value == "Curly"){
							array_push($curlytails, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighttails, $property);
						}
					}
					if($property->property_id == 19){ //backline
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
			$nohairtypes = (count($sowsalive)-(count($curlyhairs)+count($straighthairs)));
			$nohairlengths = (count($sowsalive)-(count($shorthairs)+count($longhairs)));
			$nocoats = (count($sowsalive)-(count($blackcoats)+count($nonblackcoats)));
			$nopatterns = (count($sowsalive)-(count($plains)+count($socks)));
			$noheadshapes = (count($sowsalive)-(count($concaves)+count($straightheads)));
			$noskintypes = (count($sowsalive)-(count($smooths)+count($wrinkleds)));
			$noeartypes = (count($sowsalive)-(count($droopingears)+count($semilops)+count($erectears)));
			$notailtypes = (count($sowsalive)-(count($curlytails)+count($straighttails)));
			$nobacklines = (count($sowsalive)-(count($swaybacks)+count($straightbacks)));

			$now = new Carbon();

			$pdf = PDF::loadView('pigs.grossmorphosowpdf', compact('pigs', 'filter', 'sows', 'boars', 'curlyhairs', 'straighthairs', 'shorthairs', 'longhairs', 'blackcoats', 'nonblackcoats', 'plains', 'socks', 'concaves', 'straightheads', 'smooths', 'wrinkleds', 'droopingears', 'semilops', 'erectears', 'curlytails', 'straighttails', 'swaybacks', 'straightbacks', 'nohairtypes', 'nohairlengths', 'nocoats', 'nopatterns', 'noheadshapes', 'noskintypes', 'noeartypes', 'notailtypes', 'nobacklines', 'years', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars', 'now'));
			return $pdf->download('grossmorphoreport_sow_'.$now.'.pdf');
		}

		public function grossMorphoBoarDownloadPDF(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder");
													})->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

			$filter = "Boar";

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
					if($pigproperty->property_id == 3){ //date farrowed
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
			}
			foreach ($boarsalive as $boaralive){
				$properties = $boaralive->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 11){ //hairtype
						if($property->value == "Curly"){
							array_push($curlyhairs, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighthairs, $property);
						}
					}
					if($property->property_id == 12){ //hairlength
						if($property->value == "Short"){
							array_push($shorthairs, $property);
						}
						elseif($property->value == "Long"){
							array_push($longhairs, $property);
						}
					}
					if($property->property_id == 13){ //coatcolor
						if($property->value == "Black"){
							array_push($blackcoats, $property);
						}
						elseif($property->value == "Others"){
							array_push($nonblackcoats, $property);
						}
					}
					if($property->property_id == 14){ //colorpattern
						if($property->value == "Plain"){
							array_push($plains, $property);
						}
						elseif($property->value == "Socks"){
							array_push($socks, $property);
						}
					}
					if($property->property_id == 15){ //headshape
						if($property->value == "Concave"){
							array_push($concaves, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straightheads, $property);
						}
					}
					if($property->property_id == 16){ //skintype
						if($property->value == "Smooth"){
							array_push($smooths, $property);
						}
						elseif($property->value == "Wrinkled"){
							array_push($wrinkleds, $property);
						}
					}
					if($property->property_id == 17){ //eartype
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
					if($property->property_id == 18){ //tailtype
						if($property->value == "Curly"){
							array_push($curlytails, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighttails, $property);
						}
					}
					if($property->property_id == 19){ //backline
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
			$nohairtypes = (count($boarsalive)-(count($curlyhairs)+count($straighthairs)));
			$nohairlengths = (count($boarsalive)-(count($shorthairs)+count($longhairs)));
			$nocoats = (count($boarsalive)-(count($blackcoats)+count($nonblackcoats)));
			$nopatterns = (count($boarsalive)-(count($plains)+count($socks)));
			$noheadshapes = (count($boarsalive)-(count($concaves)+count($straightheads)));
			$noskintypes = (count($boarsalive)-(count($smooths)+count($wrinkleds)));
			$noeartypes = (count($boarsalive)-(count($droopingears)+count($semilops)+count($erectears)));
			$notailtypes = (count($boarsalive)-(count($curlytails)+count($straighttails)));
			$nobacklines = (count($boarsalive)-(count($swaybacks)+count($straightbacks)));
			
			$now = new Carbon();

			$pdf = PDF::loadView('pigs.grossmorphoboarpdf', compact('pigs', 'filter', 'sows', 'boars', 'curlyhairs', 'straighthairs', 'shorthairs', 'longhairs', 'blackcoats', 'nonblackcoats', 'plains', 'socks', 'concaves', 'straightheads', 'smooths', 'wrinkleds', 'droopingears', 'semilops', 'erectears', 'curlytails', 'straighttails', 'swaybacks', 'straightbacks', 'nohairtypes', 'nohairlengths', 'nocoats', 'nopatterns', 'noheadshapes', 'noskintypes', 'noeartypes', 'notailtypes', 'nobacklines', 'years', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars', 'now'));
			return $pdf->download('grossmorphoreport_boar_'.$now.'.pdf');
		}

		public function grossMorphoAllDownloadCSV(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder");
													})->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

			$filter = "All";

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

			
			foreach ($alive as $pig) {
				$properties = $pig->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 11){ //hairtype
						if($property->value == "Curly"){
							array_push($curlyhairs, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighthairs, $property);
						}
					}
					if($property->property_id == 12){ //hairlength
						if($property->value == "Short"){
							array_push($shorthairs, $property);
						}
						elseif($property->value == "Long"){
							array_push($longhairs, $property);
						}
					}
					if($property->property_id == 13){ //coatcolor
						if($property->value == "Black"){
							array_push($blackcoats, $property);
						}
						elseif($property->value == "Others"){
							array_push($nonblackcoats, $property);
						}
					}
					if($property->property_id == 14){ //colorpattern
						if($property->value == "Plain"){
							array_push($plains, $property);
						}
						elseif($property->value == "Socks"){
							array_push($socks, $property);
						}
					}
					if($property->property_id == 15){ //headshape
						if($property->value == "Concave"){
							array_push($concaves, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straightheads, $property);
						}
					}
					if($property->property_id == 16){ //skintype
						if($property->value == "Smooth"){
							array_push($smooths, $property);
						}
						elseif($property->value == "Wrinkled"){
							array_push($wrinkleds, $property);
						}
					}
					if($property->property_id == 17){ //eartype
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
					if($property->property_id == 18){ //tailtype
						if($property->value == "Curly"){
							array_push($curlytails, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighttails, $property);
						}
					}
					if($property->property_id == 19){ //backline
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
			$nohairtypes = (count($alive)-(count($curlyhairs)+count($straighthairs)));
			$nohairlengths = (count($alive)-(count($shorthairs)+count($longhairs)));
			$nocoats = (count($alive)-(count($blackcoats)+count($nonblackcoats)));
			$nopatterns = (count($alive)-(count($plains)+count($socks)));
			$noheadshapes = (count($alive)-(count($concaves)+count($straightheads)));
			$noskintypes = (count($alive)-(count($smooths)+count($wrinkleds)));
			$noeartypes = (count($alive)-(count($droopingears)+count($semilops)+count($erectears)));
			$notailtypes = (count($alive)-(count($curlytails)+count($straighttails)));
			$nobacklines = (count($alive)-(count($swaybacks)+count($straightbacks)));
			
			$now = Carbon::now('Asia/Manila');

			return Excel::create('grossmorpho_all_'.$now, function($excel) use ($curlyhairs, $straighthairs, $nohairtypes, $shorthairs, $longhairs, $nohairlengths, $blackcoats, $nonblackcoats, $nocoats, $plains, $socks, $nopatterns, $concaves, $straightheads, $noheadshapes, $smooths, $wrinkleds, $noskintypes, $droopingears, $semilops, $erectears, $noeartypes, $curlytails, $straighttails, $notailtypes, $swaybacks, $straightbacks, $nobacklines, $now) {
				$excel->sheet('herd', function($sheet) use ($curlyhairs, $straighthairs, $nohairtypes, $shorthairs, $longhairs, $nohairlengths, $blackcoats, $nonblackcoats, $nocoats, $plains, $socks, $nopatterns, $concaves, $straightheads, $noheadshapes, $smooths, $wrinkleds, $noskintypes, $droopingears, $semilops, $erectears, $noeartypes, $curlytails, $straighttails, $notailtypes, $swaybacks, $straightbacks, $nobacklines, $now) {
					$sheet->setOrientation('landscape');
					$sheet->row(1, array(
						' ', 'Hair Type', ' ', ' ', 'Hair Length', ' ', ' ', 'Coat Color', ' ', ' ', 'Color Pattern', ' ', ' ', 'Head Shape', ' ', ' ', 'Skin Type', ' ', ' ', 'Ear Type', ' ', ' ', ' ', 'Tail Type', ' ', ' ', 'Backline', ' '
					));
					$sheet->row(2, array(
						'Curly', 'Straight', 'No Record', 'Short', 'Long', 'No Record', 'Black', 'Others', 'No Record', 'Plain', 'White Socks', 'No Record', 'Concave', 'Straight', 'No Record', 'Smooth', 'Wrinkled', 'No Record', 'Drooping', 'Semi-lop', 'Erect', 'No Record', 'Curly', 'Straight', 'No Record', 'Swayback', 'Straight', 'No Record'
					));
					$sheet->row(3, array(
						count($curlyhairs), count($straighthairs), $nohairtypes, count($shorthairs), count($longhairs), $nohairlengths, count($blackcoats), count($nonblackcoats), $nocoats, count($plains), count($socks), $nopatterns, count($concaves), count($straightheads), $noheadshapes, count($smooths), count($wrinkleds), $noskintypes, count($droopingears), count($semilops), count($erectears), $noeartypes, count($curlytails), count($straighttails), $notailtypes, count($swaybacks), count($straightbacks), $nobacklines
					));
				});	
			})->download('csv');
		}

		public function grossMorphoSowDownloadCSV(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder");
													})->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

			$filter = "Sow";

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
			}
			foreach ($sowsalive as $sowalive) {
				$properties = $sowalive->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 11){ //hairtype
						if($property->value == "Curly"){
							array_push($curlyhairs, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighthairs, $property);
						}
					}
					if($property->property_id == 12){ //hairlength
						if($property->value == "Short"){
							array_push($shorthairs, $property);
						}
						elseif($property->value == "Long"){
							array_push($longhairs, $property);
						}
					}
					if($property->property_id == 13){ //coatcolor
						if($property->value == "Black"){
							array_push($blackcoats, $property);
						}
						elseif($property->value == "Others"){
							array_push($nonblackcoats, $property);
						}
					}
					if($property->property_id == 14){ //colorpattern
						if($property->value == "Plain"){
							array_push($plains, $property);
						}
						elseif($property->value == "Socks"){
							array_push($socks, $property);
						}
					}
					if($property->property_id == 15){ //headshape
						if($property->value == "Concave"){
							array_push($concaves, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straightheads, $property);
						}
					}
					if($property->property_id == 16){ //skintype
						if($property->value == "Smooth"){
							array_push($smooths, $property);
						}
						elseif($property->value == "Wrinkled"){
							array_push($wrinkleds, $property);
						}
					}
					if($property->property_id == 17){ //eartype
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
					if($property->property_id == 18){ //tailtype
						if($property->value == "Curly"){
							array_push($curlytails, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighttails, $property);
						}
					}
					if($property->property_id == 19){ //backline
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
			$nohairtypes = (count($sowsalive)-(count($curlyhairs)+count($straighthairs)));
			$nohairlengths = (count($sowsalive)-(count($shorthairs)+count($longhairs)));
			$nocoats = (count($sowsalive)-(count($blackcoats)+count($nonblackcoats)));
			$nopatterns = (count($sowsalive)-(count($plains)+count($socks)));
			$noheadshapes = (count($sowsalive)-(count($concaves)+count($straightheads)));
			$noskintypes = (count($sowsalive)-(count($smooths)+count($wrinkleds)));
			$noeartypes = (count($sowsalive)-(count($droopingears)+count($semilops)+count($erectears)));
			$notailtypes = (count($sowsalive)-(count($curlytails)+count($straighttails)));
			$nobacklines = (count($sowsalive)-(count($swaybacks)+count($straightbacks)));

			$now = new Carbon();

			return Excel::create('grossmorpho_sow_'.$now, function($excel) use ($curlyhairs, $straighthairs, $nohairtypes, $shorthairs, $longhairs, $nohairlengths, $blackcoats, $nonblackcoats, $nocoats, $plains, $socks, $nopatterns, $concaves, $straightheads, $noheadshapes, $smooths, $wrinkleds, $noskintypes, $droopingears, $semilops, $erectears, $noeartypes, $curlytails, $straighttails, $notailtypes, $swaybacks, $straightbacks, $nobacklines, $now) {
				$excel->sheet('herd', function($sheet) use ($curlyhairs, $straighthairs, $nohairtypes, $shorthairs, $longhairs, $nohairlengths, $blackcoats, $nonblackcoats, $nocoats, $plains, $socks, $nopatterns, $concaves, $straightheads, $noheadshapes, $smooths, $wrinkleds, $noskintypes, $droopingears, $semilops, $erectears, $noeartypes, $curlytails, $straighttails, $notailtypes, $swaybacks, $straightbacks, $nobacklines, $now) {
					$sheet->setOrientation('landscape');
					$sheet->row(1, array(
						' ', 'Hair Type', ' ', ' ', 'Hair Length', ' ', ' ', 'Coat Color', ' ', ' ', 'Color Pattern', ' ', ' ', 'Head Shape', ' ', ' ', 'Skin Type', ' ', ' ', 'Ear Type', ' ', ' ', ' ', 'Tail Type', ' ', ' ', 'Backline', ' '
					));
					$sheet->row(2, array(
						'Curly', 'Straight', 'No Record', 'Short', 'Long', 'No Record', 'Black', 'Others', 'No Record', 'Plain', 'White Socks', 'No Record', 'Concave', 'Straight', 'No Record', 'Smooth', 'Wrinkled', 'No Record', 'Drooping', 'Semi-lop', 'Erect', 'No Record', 'Curly', 'Straight', 'No Record', 'Swayback', 'Straight', 'No Record'
					));
					$sheet->row(3, array(
						count($curlyhairs), count($straighthairs), $nohairtypes, count($shorthairs), count($longhairs), $nohairlengths, count($blackcoats), count($nonblackcoats), $nocoats, count($plains), count($socks), $nopatterns, count($concaves), count($straightheads), $noheadshapes, count($smooths), count($wrinkleds), $noskintypes, count($droopingears), count($semilops), count($erectears), $noeartypes, count($curlytails), count($straighttails), $notailtypes, count($swaybacks), count($straightbacks), $nobacklines
					));
				});	
			})->download('csv');
		}

		public function grossMorphoBoarDownloadCSV(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder");
													})->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

			$filter = "Boar";

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
			}
			foreach ($boarsalive as $boaralive){
				$properties = $boaralive->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 11){ //hairtype
						if($property->value == "Curly"){
							array_push($curlyhairs, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighthairs, $property);
						}
					}
					if($property->property_id == 12){ //hairlength
						if($property->value == "Short"){
							array_push($shorthairs, $property);
						}
						elseif($property->value == "Long"){
							array_push($longhairs, $property);
						}
					}
					if($property->property_id == 13){ //coatcolor
						if($property->value == "Black"){
							array_push($blackcoats, $property);
						}
						elseif($property->value == "Others"){
							array_push($nonblackcoats, $property);
						}
					}
					if($property->property_id == 14){ //colorpattern
						if($property->value == "Plain"){
							array_push($plains, $property);
						}
						elseif($property->value == "Socks"){
							array_push($socks, $property);
						}
					}
					if($property->property_id == 15){ //headshape
						if($property->value == "Concave"){
							array_push($concaves, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straightheads, $property);
						}
					}
					if($property->property_id == 16){ //skintype
						if($property->value == "Smooth"){
							array_push($smooths, $property);
						}
						elseif($property->value == "Wrinkled"){
							array_push($wrinkleds, $property);
						}
					}
					if($property->property_id == 17){ //eartype
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
					if($property->property_id == 18){ //tailtype
						if($property->value == "Curly"){
							array_push($curlytails, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighttails, $property);
						}
					}
					if($property->property_id == 19){ //backline
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
			$nohairtypes = (count($boarsalive)-(count($curlyhairs)+count($straighthairs)));
			$nohairlengths = (count($boarsalive)-(count($shorthairs)+count($longhairs)));
			$nocoats = (count($boarsalive)-(count($blackcoats)+count($nonblackcoats)));
			$nopatterns = (count($boarsalive)-(count($plains)+count($socks)));
			$noheadshapes = (count($boarsalive)-(count($concaves)+count($straightheads)));
			$noskintypes = (count($boarsalive)-(count($smooths)+count($wrinkleds)));
			$noeartypes = (count($boarsalive)-(count($droopingears)+count($semilops)+count($erectears)));
			$notailtypes = (count($boarsalive)-(count($curlytails)+count($straighttails)));
			$nobacklines = (count($boarsalive)-(count($swaybacks)+count($straightbacks)));
			
			$now = new Carbon();

			return Excel::create('grossmorpho_boar_'.$now, function($excel) use ($curlyhairs, $straighthairs, $nohairtypes, $shorthairs, $longhairs, $nohairlengths, $blackcoats, $nonblackcoats, $nocoats, $plains, $socks, $nopatterns, $concaves, $straightheads, $noheadshapes, $smooths, $wrinkleds, $noskintypes, $droopingears, $semilops, $erectears, $noeartypes, $curlytails, $straighttails, $notailtypes, $swaybacks, $straightbacks, $nobacklines, $now) {
				$excel->sheet('herd', function($sheet) use ($curlyhairs, $straighthairs, $nohairtypes, $shorthairs, $longhairs, $nohairlengths, $blackcoats, $nonblackcoats, $nocoats, $plains, $socks, $nopatterns, $concaves, $straightheads, $noheadshapes, $smooths, $wrinkleds, $noskintypes, $droopingears, $semilops, $erectears, $noeartypes, $curlytails, $straighttails, $notailtypes, $swaybacks, $straightbacks, $nobacklines, $now) {
					$sheet->setOrientation('landscape');
					$sheet->row(1, array(
						' ', 'Hair Type', ' ', ' ', 'Hair Length', ' ', ' ', 'Coat Color', ' ', ' ', 'Color Pattern', ' ', ' ', 'Head Shape', ' ', ' ', 'Skin Type', ' ', ' ', 'Ear Type', ' ', ' ', ' ', 'Tail Type', ' ', ' ', 'Backline', ' '
					));
					$sheet->row(2, array(
						'Curly', 'Straight', 'No Record', 'Short', 'Long', 'No Record', 'Black', 'Others', 'No Record', 'Plain', 'White Socks', 'No Record', 'Concave', 'Straight', 'No Record', 'Smooth', 'Wrinkled', 'No Record', 'Drooping', 'Semi-lop', 'Erect', 'No Record', 'Curly', 'Straight', 'No Record', 'Swayback', 'Straight', 'No Record'
					));
					$sheet->row(3, array(
						count($curlyhairs), count($straighthairs), $nohairtypes, count($shorthairs), count($longhairs), $nohairlengths, count($blackcoats), count($nonblackcoats), $nocoats, count($plains), count($socks), $nopatterns, count($concaves), count($straightheads), $noheadshapes, count($smooths), count($wrinkleds), $noskintypes, count($droopingears), count($semilops), count($erectears), $noeartypes, count($curlytails), count($straighttails), $notailtypes, count($swaybacks), count($straightbacks), $nobacklines
					));
				});	
			})->download('csv');
		}

		public function getGrossMorphologyReportPage(){ // function to display Gross Morphology Report page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder")
													->orWhere("status", "removed breeder");
													})->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();
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
			foreach ($alive as $pig) {
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
					if($pigproperty->property_id == 3){ //date farrowed
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
			foreach ($alive as $pig) {
				$properties = $pig->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 11){ //hairtype
						if($property->value == "Curly"){
							array_push($curlyhairs, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighthairs, $property);
						}
					}
					if($property->property_id == 12){ //hairlength
						if($property->value == "Short"){
							array_push($shorthairs, $property);
						}
						elseif($property->value == "Long"){
							array_push($longhairs, $property);
						}
					}
					if($property->property_id == 13){ //coatcolor
						if($property->value == "Black"){
							array_push($blackcoats, $property);
						}
						elseif($property->value == "Others"){
							array_push($nonblackcoats, $property);
						}
					}
					if($property->property_id == 14){ //colorpattern
						if($property->value == "Plain"){
							array_push($plains, $property);
						}
						elseif($property->value == "Socks"){
							array_push($socks, $property);
						}
					}
					if($property->property_id == 15){ //headshape
						if($property->value == "Concave"){
							array_push($concaves, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straightheads, $property);
						}
					}
					if($property->property_id == 16){ //skintype
						if($property->value == "Smooth"){
							array_push($smooths, $property);
						}
						elseif($property->value == "Wrinkled"){
							array_push($wrinkleds, $property);
						}
					}
					if($property->property_id == 17){ //eartype
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
					if($property->property_id == 18){ //tailtype
						if($property->value == "Curly"){
							array_push($curlytails, $property);
						}
						elseif($property->value == "Straight"){
							array_push($straighttails, $property);
						}
					}
					if($property->property_id == 19){ //backline
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
			$nohairtypes = (count($alive)-(count($curlyhairs)+count($straighthairs)));
			$nohairlengths = (count($alive)-(count($shorthairs)+count($longhairs)));
			$nocoats = (count($alive)-(count($blackcoats)+count($nonblackcoats)));
			$nopatterns = (count($alive)-(count($plains)+count($socks)));
			$noheadshapes = (count($alive)-(count($concaves)+count($straightheads)));
			$noskintypes = (count($alive)-(count($smooths)+count($wrinkleds)));
			$noeartypes = (count($alive)-(count($droopingears)+count($semilops)+count($erectears)));
			$notailtypes = (count($alive)-(count($curlytails)+count($straighttails)));
			$nobacklines = (count($alive)-(count($swaybacks)+count($straightbacks)));

			$now = new Carbon();

			return view('pigs.grossmorphoreport', compact('pigs', 'filter', 'sows', 'boars', 'curlyhairs', 'straighthairs', 'shorthairs', 'longhairs', 'blackcoats', 'nonblackcoats', 'plains', 'socks', 'concaves', 'straightheads', 'smooths', 'wrinkleds', 'droopingears', 'semilops', 'erectears', 'curlytails', 'straighttails', 'swaybacks', 'straightbacks', 'nohairtypes', 'nohairlengths', 'nocoats', 'nopatterns', 'noheadshapes', 'noskintypes', 'noeartypes', 'notailtypes', 'nobacklines', 'years', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars', 'now'));
		}

		public function filterGrossMorphologyReport(Request $request){ // function to filter Gross Morphology Report onclick
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder");
													})->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

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
					if($pigproperty->property_id == 3){ //date farrowed
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
				}
				foreach ($sowsalive as $sowalive) {
					$properties = $sowalive->getAnimalProperties();
					foreach ($properties as $property) {
						if($property->property_id == 11){ //hairtype
							if($property->value == "Curly"){
								array_push($curlyhairs, $property);
							}
							elseif($property->value == "Straight"){
								array_push($straighthairs, $property);
							}
						}
						if($property->property_id == 12){ //hairlength
							if($property->value == "Short"){
								array_push($shorthairs, $property);
							}
							elseif($property->value == "Long"){
								array_push($longhairs, $property);
							}
						}
						if($property->property_id == 13){ //coatcolor
							if($property->value == "Black"){
								array_push($blackcoats, $property);
							}
							elseif($property->value == "Others"){
								array_push($nonblackcoats, $property);
							}
						}
						if($property->property_id == 14){ //colorpattern
							if($property->value == "Plain"){
								array_push($plains, $property);
							}
							elseif($property->value == "Socks"){
								array_push($socks, $property);
							}
						}
						if($property->property_id == 15){ //headshape
							if($property->value == "Concave"){
								array_push($concaves, $property);
							}
							elseif($property->value == "Straight"){
								array_push($straightheads, $property);
							}
						}
						if($property->property_id == 16){ //skintype
							if($property->value == "Smooth"){
								array_push($smooths, $property);
							}
							elseif($property->value == "Wrinkled"){
								array_push($wrinkleds, $property);
							}
						}
						if($property->property_id == 17){ //eartype
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
						if($property->property_id == 18){ //tailtype
							if($property->value == "Curly"){
								array_push($curlytails, $property);
							}
							elseif($property->value == "Straight"){
								array_push($straighttails, $property);
							}
						}
						if($property->property_id == 19){ //backline
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
				$nohairtypes = (count($sowsalive)-(count($curlyhairs)+count($straighthairs)));
				$nohairlengths = (count($sowsalive)-(count($shorthairs)+count($longhairs)));
				$nocoats = (count($sowsalive)-(count($blackcoats)+count($nonblackcoats)));
				$nopatterns = (count($sowsalive)-(count($plains)+count($socks)));
				$noheadshapes = (count($sowsalive)-(count($concaves)+count($straightheads)));
				$noskintypes = (count($sowsalive)-(count($smooths)+count($wrinkleds)));
				$noeartypes = (count($sowsalive)-(count($droopingears)+count($semilops)+count($erectears)));
				$notailtypes = (count($sowsalive)-(count($curlytails)+count($straighttails)));
				$nobacklines = (count($sowsalive)-(count($swaybacks)+count($straightbacks)));
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
				}
				foreach ($boarsalive as $boaralive){
					$properties = $boaralive->getAnimalProperties();
					foreach ($properties as $property) {
						if($property->property_id == 11){ //hairtype
							if($property->value == "Curly"){
								array_push($curlyhairs, $property);
							}
							elseif($property->value == "Straight"){
								array_push($straighthairs, $property);
							}
						}
						if($property->property_id == 12){ //hairlength
							if($property->value == "Short"){
								array_push($shorthairs, $property);
							}
							elseif($property->value == "Long"){
								array_push($longhairs, $property);
							}
						}
						if($property->property_id == 13){ //coatcolor
							if($property->value == "Black"){
								array_push($blackcoats, $property);
							}
							elseif($property->value == "Others"){
								array_push($nonblackcoats, $property);
							}
						}
						if($property->property_id == 14){ //colorpattern
							if($property->value == "Plain"){
								array_push($plains, $property);
							}
							elseif($property->value == "Socks"){
								array_push($socks, $property);
							}
						}
						if($property->property_id == 15){ //headshape
							if($property->value == "Concave"){
								array_push($concaves, $property);
							}
							elseif($property->value == "Straight"){
								array_push($straightheads, $property);
							}
						}
						if($property->property_id == 16){ //skintype
							if($property->value == "Smooth"){
								array_push($smooths, $property);
							}
							elseif($property->value == "Wrinkled"){
								array_push($wrinkleds, $property);
							}
						}
						if($property->property_id == 17){ //eartype
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
						if($property->property_id == 18){ //tailtype
							if($property->value == "Curly"){
								array_push($curlytails, $property);
							}
							elseif($property->value == "Straight"){
								array_push($straighttails, $property);
							}
						}
						if($property->property_id == 19){ //backline
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
				$nohairtypes = (count($boarsalive)-(count($curlyhairs)+count($straighthairs)));
				$nohairlengths = (count($boarsalive)-(count($shorthairs)+count($longhairs)));
				$nocoats = (count($boarsalive)-(count($blackcoats)+count($nonblackcoats)));
				$nopatterns = (count($boarsalive)-(count($plains)+count($socks)));
				$noheadshapes = (count($boarsalive)-(count($concaves)+count($straightheads)));
				$noskintypes = (count($boarsalive)-(count($smooths)+count($wrinkleds)));
				$noeartypes = (count($boarsalive)-(count($droopingears)+count($semilops)+count($erectears)));
				$notailtypes = (count($boarsalive)-(count($curlytails)+count($straighttails)));
				$nobacklines = (count($boarsalive)-(count($swaybacks)+count($straightbacks)));
			}
			elseif($filter == "All"){ // data displayed are for all pigs in the herd
				foreach ($alive as $pig) {
					$properties = $pig->getAnimalProperties();
					foreach ($properties as $property) {
						if($property->property_id == 11){ //hairtype
							if($property->value == "Curly"){
								array_push($curlyhairs, $property);
							}
							elseif($property->value == "Straight"){
								array_push($straighthairs, $property);
							}
						}
						if($property->property_id == 12){ //hairlength
							if($property->value == "Short"){
								array_push($shorthairs, $property);
							}
							elseif($property->value == "Long"){
								array_push($longhairs, $property);
							}
						}
						if($property->property_id == 13){ //coatcolor
							if($property->value == "Black"){
								array_push($blackcoats, $property);
							}
							elseif($property->value == "Others"){
								array_push($nonblackcoats, $property);
							}
						}
						if($property->property_id == 14){ //colorpattern
							if($property->value == "Plain"){
								array_push($plains, $property);
							}
							elseif($property->value == "Socks"){
								array_push($socks, $property);
							}
						}
						if($property->property_id == 15){ //headshape
							if($property->value == "Concave"){
								array_push($concaves, $property);
							}
							elseif($property->value == "Straight"){
								array_push($straightheads, $property);
							}
						}
						if($property->property_id == 16){ //skintype
							if($property->value == "Smooth"){
								array_push($smooths, $property);
							}
							elseif($property->value == "Wrinkled"){
								array_push($wrinkleds, $property);
							}
						}
						if($property->property_id == 17){ //eartype
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
						if($property->property_id == 18){ //tailtype
							if($property->value == "Curly"){
								array_push($curlytails, $property);
							}
							elseif($property->value == "Straight"){
								array_push($straighttails, $property);
							}
						}
						if($property->property_id == 19){ //backline
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
				$nohairtypes = (count($alive)-(count($curlyhairs)+count($straighthairs)));
				$nohairlengths = (count($alive)-(count($shorthairs)+count($longhairs)));
				$nocoats = (count($alive)-(count($blackcoats)+count($nonblackcoats)));
				$nopatterns = (count($alive)-(count($plains)+count($socks)));
				$noheadshapes = (count($alive)-(count($concaves)+count($straightheads)));
				$noskintypes = (count($alive)-(count($smooths)+count($wrinkleds)));
				$noeartypes = (count($alive)-(count($droopingears)+count($semilops)+count($erectears)));
				$notailtypes = (count($alive)-(count($curlytails)+count($straighttails)));
				$nobacklines = (count($alive)-(count($swaybacks)+count($straightbacks)));
			}

			$now = new Carbon();

			// return Redirect::back()->with('message','Operation Successful!');
			return view('pigs.grossmorphoreport', compact('pigs', 'filter', 'sows', 'boars', 'curlyhairs', 'straighthairs', 'shorthairs', 'longhairs', 'blackcoats', 'nonblackcoats', 'plains', 'socks', 'concaves', 'straightheads', 'smooths', 'wrinkleds', 'droopingears', 'semilops', 'erectears', 'curlytails', 'straighttails', 'swaybacks', 'straightbacks', 'nohairtypes', 'nohairlengths', 'nocoats', 'nopatterns', 'noheadshapes', 'noskintypes', 'noeartypes', 'notailtypes', 'nobacklines', 'years', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars', 'now'));
		}

		static function standardDeviation($arr, $samp = false){ // function to compute standard deviation
			$ave = array_sum($arr) / count($arr);
			$variance = 0.0;
			foreach ($arr as $i) {
				$variance += pow((float) $i - $ave, 2);
			}
			$variance /= ( $samp ? count($arr) - 1 : count($arr) );
			return (float) sqrt($variance);
		}

		public static function getMorphometricCharacteristicsWithoutYearOfBirth($property_id, $filter){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder")
													->orWhere("status", "removed breeder");
													})->get();

			$noyearofbirth = [];

			foreach ($pigs as $pig) {
				if(substr($pig->registryid, -8, 1) == '-'){
					array_push($noyearofbirth, $pig);
				}
			}

			$sows = [];
			$boars = [];
			foreach ($noyearofbirth as $pig) {
				if(substr($pig->registryid, -7, 1) == 'F'){
					array_push($sows, $pig);
				}
				if(substr($pig->registryid, -7, 1) == 'M'){
					array_push($boars, $pig);
				}
			}

			if($filter == "All"){ // data returned are for all pigs
				$morphochars = [];
				foreach ($noyearofbirth as $pig) {
					$properties = $pig->getAnimalProperties();
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
				foreach ($sows as $sow) {
					$properties = $sow->getAnimalProperties();
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
				foreach ($boars as $boars) {
					$properties = $boars->getAnimalProperties();
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

		public static function getMorphometricCharacteristicsPerYearOfBirth($year, $property_id, $filter){ // function to display Morphometric Characteristics Report per year of birth
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
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

		public function morphoCharsAllDownloadPDF(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->orWhere("status", "dead breeder")->orWhere("status", "sold breeder")->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

			$filter = "All";

			// sorts pigs per sex
			$sows = [];
			$boars = [];
			foreach ($alive as $pig) {
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
			foreach ($alive as $pig) {
				$pigproperties = $pig->getAnimalProperties();
				foreach ($pigproperties as $pigproperty) {
					if($pigproperty->property_id == 3){ //date farrowed
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
			$ages_collected_all = [];
			
			foreach ($pigs as $pig) {
				$dc = $pig->getAnimalProperties()->where("property_id", 21)->first();
				if(!is_null($dc) && $dc->value != ""){
					$date_collected = Carbon::parse($dc->value);
					$bday = $pig->getAnimalProperties()->where("property_id", 3)->first();
					if(!is_null($bday) && $bday->value != "Not specified"){
						$age = $date_collected->diffInMonths(Carbon::parse($bday->value));
						array_push($ages_collected_all, $age);
					}
				}
			}
			foreach ($alive as $pig) {
				$properties = $pig->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 21){ // date collected for morpho chars
						if($property->value != ""){
							$date_collected = $property->value;
							$bday = $pig->getAnimalProperties()->where("property_id", 3)->first();
							if(!is_null($bday) && $bday->value != "Not specified"){
								$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday->value));
								array_push($ages_collected, $age);
							}
						}
					}
					if($property->property_id == 22){ //earlength
						if($property->value != ""){
							$earlength = $property->value;
							array_push($earlengths, $earlength);
						}
					}
					if($property->property_id == 23){ //headlength
						if($property->value != ""){
							$headlength = $property->value;
							array_push($headlengths, $headlength);
						}
					}
					if($property->property_id == 24){ //snoutlength
						if($property->value != ""){
							$snoutlength = $property->value;
							array_push($snoutlengths, $snoutlength);
						}
					}
					if($property->property_id == 25){ //bodylength
						if($property->value != ""){
							$bodylength = $property->value;
							array_push($bodylengths, $bodylength);
						}
					}
					if($property->property_id == 26){ //heartgirth
						if($property->value != ""){
							$heartgirth = $property->value;
							array_push($heartgirths, $heartgirth);
						}
					}
					if($property->property_id == 27){ //pelvicwidth
						if($property->value != ""){
							$pelvicwidth = $property->value;
							array_push($pelvicwidths, $pelvicwidth);
						}
					}
					if($property->property_id == 28){ //taillength
						if($property->value != ""){
							$taillength = $property->value;
							array_push($taillengths, $taillength);
						}
					}
					if($property->property_id == 29){ //heightatwithers
						if($property->value != ""){
							$heightatwithers = $property->value;
							array_push($heightsatwithers, $heightatwithers);
						}
					}
					if($property->property_id == 30){ //numberofnormalteats
						if($property->value != ""){
							$numberofnormalteats = $property->value;
							array_push($normalteats, $numberofnormalteats);
						}
					}
					if($property->property_id == 31){ //ponderalindex
						if($property->value != ""){
							$ponderalindex = $property->value;
							array_push($ponderalindices, $ponderalindex);
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

			$now = new Carbon();

			$pdf = PDF::loadView('pigs.morphocharsallpdf', compact('pigs', 'filter', 'sows', 'boars', 'earlengths', 'headlengths', 'snoutlengths', 'bodylengths', 'heartgirths', 'pelvicwidths', 'ponderalindices', 'taillengths', 'heightsatwithers', 'normalteats', 'earlengths_sd', 'headlengths_sd', 'snoutlengths_sd', 'bodylengths_sd', 'heartgirths_sd', 'pelvicwidths_sd', 'ponderalindices_sd', 'taillengths_sd', 'heightsatwithers_sd', 'normalteats_sd', 'years', 'ages_collected', 'ages_collected_all', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars', 'now'));
			return $pdf->download('morphocharsreport_all_'.$now.'.pdf');
		}

		public function morphoCharsSowDownloadPDF(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->orWhere("status", "dead breeder")->orWhere("status", "sold breeder")->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

			$filter = "Sow";

			// sorts pigs per sex
			$sows = [];
			$boars = [];
			foreach ($alive as $pig) {
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
			foreach ($alive as $pig) {
				$pigproperties = $pig->getAnimalProperties();
				foreach ($pigproperties as $pigproperty) {
					if($pigproperty->property_id == 3){ //date farrowed
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
			$ages_collected_all = [];
			
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
				$dc = $sow->getAnimalProperties()->where("property_id", 21)->first();
				if(!is_null($dc) && $dc->value != ""){
					$date_collected = Carbon::parse($dc->value);
					$bday = $sow->getAnimalProperties()->where("property_id", 3)->first();
					if(!is_null($bday) && $bday->value != "Not specified"){
						$age = $date_collected->diffInMonths(Carbon::parse($bday->value));
						array_push($ages_collected_all, $age);
					}
				}
			}
			foreach ($sowsalive as $sowalive) {
				$properties = $sowalive->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 21){ // date collected for morpho chars
						if($property->value != ""){
							$date_collected = $property->value;
							$bday = $sowalive->getAnimalProperties()->where("property_id", 3)->first();
							if(!is_null($bday) && $bday->value != "Not specified"){
								$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday->value));
								array_push($ages_collected, $age);
							}
						}
					}
					if($property->property_id == 22){ //earlength
						if($property->value != ""){
							$earlength = $property->value;
							array_push($earlengths, $earlength);
						}
					}
					if($property->property_id == 23){ //headlength
						if($property->value != ""){
							$headlength = $property->value;
							array_push($headlengths, $headlength);
						}
					}
					if($property->property_id == 24){ //snoutlength
						if($property->value != ""){
							$snoutlength = $property->value;
							array_push($snoutlengths, $snoutlength);
						}
					}
					if($property->property_id == 25){ //bodylength
						if($property->value != ""){
							$bodylength = $property->value;
							array_push($bodylengths, $bodylength);
						}
					}
					if($property->property_id == 26){ //heartgirth
						if($property->value != ""){
							$heartgirth = $property->value;
							array_push($heartgirths, $heartgirth);
						}
					}
					if($property->property_id == 27){ //pelvicwidth
						if($property->value != ""){
							$pelvicwidth = $property->value;
							array_push($pelvicwidths, $pelvicwidth);
						}
					}
					if($property->property_id == 28){ //taillength
						if($property->value != ""){
							$taillength = $property->value;
							array_push($taillengths, $taillength);
						}
					}
					if($property->property_id == 29){ //heightatwithers
						if($property->value != ""){
							$heightatwithers = $property->value;
							array_push($heightsatwithers, $heightatwithers);
						}
					}
					if($property->property_id == 30){ //numberofnormalteats
						if($property->value != ""){
							$numberofnormalteats = $property->value;
							array_push($normalteats, $numberofnormalteats);
						}
					}
					if($property->property_id == 31){ //ponderalindex
						if($property->value != ""){
							$ponderalindex = $property->value;
							array_push($ponderalindices, $ponderalindex);
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
			

			$now = new Carbon();

			$pdf = PDF::loadView('pigs.morphocharssowpdf', compact('pigs', 'filter', 'sows', 'boars', 'earlengths', 'headlengths', 'snoutlengths', 'bodylengths', 'heartgirths', 'pelvicwidths', 'ponderalindices', 'taillengths', 'heightsatwithers', 'normalteats', 'earlengths_sd', 'headlengths_sd', 'snoutlengths_sd', 'bodylengths_sd', 'heartgirths_sd', 'pelvicwidths_sd', 'ponderalindices_sd', 'taillengths_sd', 'heightsatwithers_sd', 'normalteats_sd', 'years', 'ages_collected', 'ages_collected_all', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars', 'now'));
			return $pdf->download('morphocharsreport_sow_'.$now.'.pdf');
		}

		public function morphoCharsBoarDownloadPDF(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->orWhere("status", "dead breeder")->orWhere("status", "sold breeder")->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

			$filter = "Boar";

			// sorts pigs per sex
			$sows = [];
			$boars = [];
			foreach ($alive as $pig) {
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
			foreach ($alive as $pig) {
				$pigproperties = $pig->getAnimalProperties();
				foreach ($pigproperties as $pigproperty) {
					if($pigproperty->property_id == 3){ //date farrowed
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
			$ages_collected_all = [];
			
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
				$dc = $boar->getAnimalProperties()->where("property_id", 21)->first();
				if(!is_null($dc) && $dc->value != ""){
					$date_collected = Carbon::parse($dc->value);
					$bday = $boar->getAnimalProperties()->where("property_id", 3)->first();
					if(!is_null($bday) && $bday->value != "Not specified"){
						$age = $date_collected->diffInMonths(Carbon::parse($bday->value));
						array_push($ages_collected_all, $age);
					}
				}
			}
			foreach ($boarsalive as $boaralive) {
				$properties = $boaralive->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 21){ // date collected for morpho chars
						if($property->value != ""){
							$date_collected = $property->value;
							$bday = $boaralive->getAnimalProperties()->where("property_id", 3)->first();
							if(!is_null($bday) && $bday->value != "Not specified"){
								$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday->value));
								array_push($ages_collected, $age);
							}
						}
					}
					if($property->property_id == 22){ //earlength
						if($property->value != ""){
							$earlength = $property->value;
							array_push($earlengths, $earlength);
						}
					}
					if($property->property_id == 23){ //headlength
						if($property->value != ""){
							$headlength = $property->value;
							array_push($headlengths, $headlength);
						}
					}
					if($property->property_id == 24){ //snoutlength
						if($property->value != ""){
							$snoutlength = $property->value;
							array_push($snoutlengths, $snoutlength);
						}
					}
					if($property->property_id == 25){ //bodylength
						if($property->value != ""){
							$bodylength = $property->value;
							array_push($bodylengths, $bodylength);
						}
					}
					if($property->property_id == 26){ //heartgirth
						if($property->value != ""){
							$heartgirth = $property->value;
							array_push($heartgirths, $heartgirth);
						}
					}
					if($property->property_id == 27){ //pelvicwidth
						if($property->value != ""){
							$pelvicwidth = $property->value;
							array_push($pelvicwidths, $pelvicwidth);
						}
					}
					if($property->property_id == 28){ //taillength
						if($property->value != ""){
							$taillength = $property->value;
							array_push($taillengths, $taillength);
						}
					}
					if($property->property_id == 29){ //heightatwithers
						if($property->value != ""){
							$heightatwithers = $property->value;
							array_push($heightsatwithers, $heightatwithers);
						}
					}
					if($property->property_id == 30){ //numberofnormalteats
						if($property->value != ""){
							$numberofnormalteats = $property->value;
							array_push($normalteats, $numberofnormalteats);
						}
					}
					if($property->property_id == 31){ //ponderalindex
						if($property->value != ""){
							$ponderalindex = $property->value;
							array_push($ponderalindices, $ponderalindex);
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
			
			$now = new Carbon();

			$pdf = PDF::loadView('pigs.morphocharsboarpdf', compact('pigs', 'filter', 'sows', 'boars', 'earlengths', 'headlengths', 'snoutlengths', 'bodylengths', 'heartgirths', 'pelvicwidths', 'ponderalindices', 'taillengths', 'heightsatwithers', 'normalteats', 'earlengths_sd', 'headlengths_sd', 'snoutlengths_sd', 'bodylengths_sd', 'heartgirths_sd', 'pelvicwidths_sd', 'ponderalindices_sd', 'taillengths_sd', 'heightsatwithers_sd', 'normalteats_sd', 'years', 'ages_collected', 'ages_collected_all', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars', 'now'));
			return $pdf->download('morphocharsreport_boar_'.$now.'.pdf');
		}

		public function morphoCharsAllDownloadCSV(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->orWhere("status", "dead breeder")->orWhere("status", "sold breeder")->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

			$filter = "All";

			// sorts pigs per sex
			$sows = [];
			$boars = [];
			foreach ($alive as $pig) {
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
			foreach ($alive as $pig) {
				$pigproperties = $pig->getAnimalProperties();
				foreach ($pigproperties as $pigproperty) {
					if($pigproperty->property_id == 3){ //date farrowed
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
			$ages_collected_all = [];
			
			foreach ($pigs as $pig) {
				$dc = $pig->getAnimalProperties()->where("property_id", 21)->first();
				if(!is_null($dc) && $dc->value != ""){
					$date_collected = Carbon::parse($dc->value);
					$bday = $pig->getAnimalProperties()->where("property_id", 3)->first();
					if(!is_null($bday) && $bday->value != "Not specified"){
						$age = $date_collected->diffInMonths(Carbon::parse($bday->value));
						array_push($ages_collected_all, $age);
					}
				}
			}
			foreach ($alive as $pig) {
				$properties = $pig->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 21){ // date collected for morpho chars
						if($property->value != ""){
							$date_collected = $property->value;
							$bday = $pig->getAnimalProperties()->where("property_id", 3)->first();
							if(!is_null($bday) && $bday->value != "Not specified"){
								$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday->value));
								array_push($ages_collected, $age);
							}
						}
					}
					if($property->property_id == 22){ //earlength
						if($property->value != ""){
							$earlength = $property->value;
							array_push($earlengths, $earlength);
						}
					}
					if($property->property_id == 23){ //headlength
						if($property->value != ""){
							$headlength = $property->value;
							array_push($headlengths, $headlength);
						}
					}
					if($property->property_id == 24){ //snoutlength
						if($property->value != ""){
							$snoutlength = $property->value;
							array_push($snoutlengths, $snoutlength);
						}
					}
					if($property->property_id == 25){ //bodylength
						if($property->value != ""){
							$bodylength = $property->value;
							array_push($bodylengths, $bodylength);
						}
					}
					if($property->property_id == 26){ //heartgirth
						if($property->value != ""){
							$heartgirth = $property->value;
							array_push($heartgirths, $heartgirth);
						}
					}
					if($property->property_id == 27){ //pelvicwidth
						if($property->value != ""){
							$pelvicwidth = $property->value;
							array_push($pelvicwidths, $pelvicwidth);
						}
					}
					if($property->property_id == 28){ //taillength
						if($property->value != ""){
							$taillength = $property->value;
							array_push($taillengths, $taillength);
						}
					}
					if($property->property_id == 29){ //heightatwithers
						if($property->value != ""){
							$heightatwithers = $property->value;
							array_push($heightsatwithers, $heightatwithers);
						}
					}
					if($property->property_id == 30){ //numberofnormalteats
						if($property->value != ""){
							$numberofnormalteats = $property->value;
							array_push($normalteats, $numberofnormalteats);
						}
					}
					if($property->property_id == 31){ //ponderalindex
						if($property->value != ""){
							$ponderalindex = $property->value;
							array_push($ponderalindices, $ponderalindex);
						}
					}
				}
			}

			if($earlengths != []){
				$earlengths_sd = static::standardDeviation($earlengths, false);
			}
			else{
				$earlengths_sd = 0;
			}
			if($headlengths != []){
				$headlengths_sd = static::standardDeviation($headlengths, false);
			}
			else{
				$headlengths_sd = 0;
			}
			if($snoutlengths != []){
				$snoutlengths_sd = static::standardDeviation($snoutlengths, false);
			}
			else{
				$snoutlengths_sd = 0;
			}
			if($bodylengths != []){
				$bodylengths_sd = static::standardDeviation($bodylengths, false);
			}
			else{
				$bodylengths_sd = 0;
			}
			if($heartgirths != []){
				$heartgirths_sd = static::standardDeviation($heartgirths, false);
			}
			else{
				$heartgirths_sd = 0;
			}
			if($pelvicwidths != []){
				$pelvicwidths_sd = static::standardDeviation($pelvicwidths, false);
			}
			else{
				$pelvicwidths_sd = 0;
			}
			if($ponderalindices != []){
				$ponderalindices_sd = static::standardDeviation($ponderalindices, false);
			}
			else{
				$ponderalindices_sd = 0;
			}
			if($taillengths != []){
				$taillengths_sd = static::standardDeviation($taillengths, false);
			}
			else{
				$taillengths_sd = 0;
			}
			if($heightsatwithers != []){
				$heightsatwithers_sd = static::standardDeviation($heightsatwithers, false);
			}
			else{
				$heightsatwithers_sd = 0;
			}
			if($normalteats != []){
				$normalteats_sd = static::standardDeviation($normalteats, false);
			}
			else{
				$normalteats_sd = 0;
			}

			$now = new Carbon();

			return Excel::create('morphochars_all_'.$now, function($excel) use ($earlengths, $headlengths, $snoutlengths, $bodylengths, $heartgirths, $pelvicwidths, $ponderalindices, $taillengths, $heightsatwithers, $normalteats, $earlengths_sd, $headlengths_sd, $snoutlengths_sd, $bodylengths_sd, $heartgirths_sd, $pelvicwidths_sd, $ponderalindices_sd, $taillengths_sd, $heightsatwithers_sd, $normalteats_sd, $now) {
				$excel->sheet('herd', function($sheet) use ($earlengths, $headlengths, $snoutlengths, $bodylengths, $heartgirths, $pelvicwidths, $ponderalindices, $taillengths, $heightsatwithers, $normalteats, $earlengths_sd, $headlengths_sd, $snoutlengths_sd, $bodylengths_sd, $heartgirths_sd, $pelvicwidths_sd, $ponderalindices_sd, $taillengths_sd, $heightsatwithers_sd, $normalteats_sd, $now) {
					$sheet->setOrientation('landscape');
					$sheet->row(1, array(
						'Property', 'Pigs with data', 'Minimum', 'Maximum', 'Average', 'Standard Deviation'
					));
					if($earlengths != []){
						$sheet->row(2, array(
							'Ear Length, cm', count($earlengths), min($earlengths), max($earlengths), round(array_sum($earlengths)/count($earlengths), 2), round($earlengths_sd, 2)
						));
					}
					else{
						$sheet->row(2, array(
							'Ear Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($headlengths != []){
						$sheet->row(3, array(
							'Head Length, cm', count($headlengths), min($headlengths), max($headlengths), round(array_sum($headlengths)/count($headlengths), 2), round($headlengths_sd, 2)
						));
					}
					else{
						$sheet->row(3, array(
							'Head Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($snoutlengths != []){
						$sheet->row(4, array(
							'Snout Length, cm', count($snoutlengths), min($snoutlengths), max($snoutlengths), round(array_sum($snoutlengths)/count($snoutlengths), 2), round($snoutlengths_sd, 2)
						));
					}
					else{
						$sheet->row(4, array(
							'Snout Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($bodylengths != []){
						$sheet->row(5, array(
							'Body Length, cm', count($bodylengths), min($bodylengths), max($bodylengths), round(array_sum($bodylengths)/count($bodylengths), 2), round($bodylengths_sd, 2)
						));
					}
					else{
						$sheet->row(5, array(
							'Body Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($heartgirths != []){
						$sheet->row(6, array(
							'Heart Girth, cm', count($heartgirths), min($heartgirths), max($heartgirths), round(array_sum($heartgirths)/count($heartgirths), 2), round($heartgirths_sd, 2)
						));
					}
					else{
						$sheet->row(6, array(
							'Heart Girth, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($pelvicwidths != []){
						$sheet->row(7, array(
							'Pelvic Width, cm', count($pelvicwidths), min($pelvicwidths), max($pelvicwidths), round(array_sum($pelvicwidths)/count($pelvicwidths), 2), round($pelvicwidths_sd, 2)
						));
					}
					else{
						$sheet->row(7, array(
							'Pelvic Width, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($ponderalindices != []){
						$sheet->row(8, array(
							'Ponderal Index, kg/m3', count($ponderalindices), min($ponderalindices), max($ponderalindices), round(array_sum($ponderalindices)/count($ponderalindices), 2), round($ponderalindices_sd, 2)
						));
					}
					else{
						$sheet->row(8, array(
							'Ponderal Index, kg/m3', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($taillengths != []){
						$sheet->row(9, array(
							'Tail Length, cm', count($taillengths), min($taillengths), max($taillengths), round(array_sum($taillengths)/count($taillengths), 2), round($taillengths_sd, 2)
						));
					}
					else{
						$sheet->row(9, array(
							'Tail Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($heightsatwithers != []){
						$sheet->row(10, array(
							'Height at Withers, cm', count($heightsatwithers), min($heightsatwithers), max($heightsatwithers), round(array_sum($heightsatwithers)/count($heightsatwithers), 2), round($heightsatwithers_sd, 2)
						));
					}
					else{
						$sheet->row(10, array(
							'Height at Withers, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($normalteats != []){
						$sheet->row(11, array(
							'Number of Normal Teats', count($normalteats), min($normalteats), max($normalteats), round(array_sum($normalteats)/count($normalteats), 2), round($normalteats_sd, 2)
						));
					}
					else{
						$sheet->row(11, array(
							'Number of Normal Teats', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
				});	
			})->download('csv');
		}

		public function morphoCharsSowDownloadCSV(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->orWhere("status", "dead breeder")->orWhere("status", "sold breeder")->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

			$filter = "Sow";

			// sorts pigs per sex
			$sows = [];
			$boars = [];
			foreach ($alive as $pig) {
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
			foreach ($alive as $pig) {
				$pigproperties = $pig->getAnimalProperties();
				foreach ($pigproperties as $pigproperty) {
					if($pigproperty->property_id == 3){ //date farrowed
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
			$ages_collected_all = [];
			
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
				$dc = $sow->getAnimalProperties()->where("property_id", 21)->first();
				if(!is_null($dc) && $dc->value != ""){
					$date_collected = Carbon::parse($dc->value);
					$bday = $sow->getAnimalProperties()->where("property_id", 3)->first();
					if(!is_null($bday) && $bday->value != "Not specified"){
						$age = $date_collected->diffInMonths(Carbon::parse($bday->value));
						array_push($ages_collected_all, $age);
					}
				}
			}
			foreach ($sowsalive as $sowalive) {
				$properties = $sowalive->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 21){ // date collected for morpho chars
						if($property->value != ""){
							$date_collected = $property->value;
							$bday = $sowalive->getAnimalProperties()->where("property_id", 3)->first();
							if(!is_null($bday) && $bday->value != "Not specified"){
								$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday->value));
								array_push($ages_collected, $age);
							}
						}
					}
					if($property->property_id == 22){ //earlength
						if($property->value != ""){
							$earlength = $property->value;
							array_push($earlengths, $earlength);
						}
					}
					if($property->property_id == 23){ //headlength
						if($property->value != ""){
							$headlength = $property->value;
							array_push($headlengths, $headlength);
						}
					}
					if($property->property_id == 24){ //snoutlength
						if($property->value != ""){
							$snoutlength = $property->value;
							array_push($snoutlengths, $snoutlength);
						}
					}
					if($property->property_id == 25){ //bodylength
						if($property->value != ""){
							$bodylength = $property->value;
							array_push($bodylengths, $bodylength);
						}
					}
					if($property->property_id == 26){ //heartgirth
						if($property->value != ""){
							$heartgirth = $property->value;
							array_push($heartgirths, $heartgirth);
						}
					}
					if($property->property_id == 27){ //pelvicwidth
						if($property->value != ""){
							$pelvicwidth = $property->value;
							array_push($pelvicwidths, $pelvicwidth);
						}
					}
					if($property->property_id == 28){ //taillength
						if($property->value != ""){
							$taillength = $property->value;
							array_push($taillengths, $taillength);
						}
					}
					if($property->property_id == 29){ //heightatwithers
						if($property->value != ""){
							$heightatwithers = $property->value;
							array_push($heightsatwithers, $heightatwithers);
						}
					}
					if($property->property_id == 30){ //numberofnormalteats
						if($property->value != ""){
							$numberofnormalteats = $property->value;
							array_push($normalteats, $numberofnormalteats);
						}
					}
					if($property->property_id == 31){ //ponderalindex
						if($property->value != ""){
							$ponderalindex = $property->value;
							array_push($ponderalindices, $ponderalindex);
						}
					}
				}
			}

			if($earlengths != []){
				$earlengths_sd = static::standardDeviation($earlengths, false);
			}
			else{
				$earlengths_sd = 0;
			}
			if($headlengths != []){
				$headlengths_sd = static::standardDeviation($headlengths, false);
			}
			else{
				$headlengths_sd = 0;
			}
			if($snoutlengths != []){
				$snoutlengths_sd = static::standardDeviation($snoutlengths, false);
			}
			else{
				$snoutlengths_sd = 0;
			}
			if($bodylengths != []){
				$bodylengths_sd = static::standardDeviation($bodylengths, false);
			}
			else{
				$bodylengths_sd = 0;
			}
			if($heartgirths != []){
				$heartgirths_sd = static::standardDeviation($heartgirths, false);
			}
			else{
				$heartgirths_sd = 0;
			}
			if($pelvicwidths != []){
				$pelvicwidths_sd = static::standardDeviation($pelvicwidths, false);
			}
			else{
				$pelvicwidths_sd = 0;
			}
			if($ponderalindices != []){
				$ponderalindices_sd = static::standardDeviation($ponderalindices, false);
			}
			else{
				$ponderalindices_sd = 0;
			}
			if($taillengths != []){
				$taillengths_sd = static::standardDeviation($taillengths, false);
			}
			else{
				$taillengths_sd = 0;
			}
			if($heightsatwithers != []){
				$heightsatwithers_sd = static::standardDeviation($heightsatwithers, false);
			}
			else{
				$heightsatwithers_sd = 0;
			}
			if($normalteats != []){
				$normalteats_sd = static::standardDeviation($normalteats, false);
			}
			else{
				$normalteats_sd = 0;
			}
			

			$now = new Carbon();


			return Excel::create('morphochars_sow_'.$now, function($excel) use ($earlengths, $headlengths, $snoutlengths, $bodylengths, $heartgirths, $pelvicwidths, $ponderalindices, $taillengths, $heightsatwithers, $normalteats, $earlengths_sd, $headlengths_sd, $snoutlengths_sd, $bodylengths_sd, $heartgirths_sd, $pelvicwidths_sd, $ponderalindices_sd, $taillengths_sd, $heightsatwithers_sd, $normalteats_sd, $now) {
				$excel->sheet('herd', function($sheet) use ($earlengths, $headlengths, $snoutlengths, $bodylengths, $heartgirths, $pelvicwidths, $ponderalindices, $taillengths, $heightsatwithers, $normalteats, $earlengths_sd, $headlengths_sd, $snoutlengths_sd, $bodylengths_sd, $heartgirths_sd, $pelvicwidths_sd, $ponderalindices_sd, $taillengths_sd, $heightsatwithers_sd, $normalteats_sd, $now) {
					$sheet->setOrientation('landscape');
					$sheet->row(1, array(
						'Property', 'Pigs with data', 'Minimum', 'Maximum', 'Average', 'Standard Deviation'
					));
					if($earlengths != []){
						$sheet->row(2, array(
							'Ear Length, cm', count($earlengths), min($earlengths), max($earlengths), round(array_sum($earlengths)/count($earlengths), 2), round($earlengths_sd, 2)
						));
					}
					else{
						$sheet->row(2, array(
							'Ear Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($headlengths != []){
						$sheet->row(3, array(
							'Head Length, cm', count($headlengths), min($headlengths), max($headlengths), round(array_sum($headlengths)/count($headlengths), 2), round($headlengths_sd, 2)
						));
					}
					else{
						$sheet->row(3, array(
							'Head Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($snoutlengths != []){
						$sheet->row(4, array(
							'Snout Length, cm', count($snoutlengths), min($snoutlengths), max($snoutlengths), round(array_sum($snoutlengths)/count($snoutlengths), 2), round($snoutlengths_sd, 2)
						));
					}
					else{
						$sheet->row(4, array(
							'Snout Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($bodylengths != []){
						$sheet->row(5, array(
							'Body Length, cm', count($bodylengths), min($bodylengths), max($bodylengths), round(array_sum($bodylengths)/count($bodylengths), 2), round($bodylengths_sd, 2)
						));
					}
					else{
						$sheet->row(5, array(
							'Body Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($heartgirths != []){
						$sheet->row(6, array(
							'Heart Girth, cm', count($heartgirths), min($heartgirths), max($heartgirths), round(array_sum($heartgirths)/count($heartgirths), 2), round($heartgirths_sd, 2)
						));
					}
					else{
						$sheet->row(6, array(
							'Heart Girth, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($pelvicwidths != []){
						$sheet->row(7, array(
							'Pelvic Width, cm', count($pelvicwidths), min($pelvicwidths), max($pelvicwidths), round(array_sum($pelvicwidths)/count($pelvicwidths), 2), round($pelvicwidths_sd, 2)
						));
					}
					else{
						$sheet->row(7, array(
							'Pelvic Width, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($ponderalindices != []){
						$sheet->row(8, array(
							'Ponderal Index, kg/m3', count($ponderalindices), min($ponderalindices), max($ponderalindices), round(array_sum($ponderalindices)/count($ponderalindices), 2), round($ponderalindices_sd, 2)
						));
					}
					else{
						$sheet->row(8, array(
							'Ponderal Index, kg/m3', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($taillengths != []){
						$sheet->row(9, array(
							'Tail Length, cm', count($taillengths), min($taillengths), max($taillengths), round(array_sum($taillengths)/count($taillengths), 2), round($taillengths_sd, 2)
						));
					}
					else{
						$sheet->row(9, array(
							'Tail Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($heightsatwithers != []){
						$sheet->row(10, array(
							'Height at Withers, cm', count($heightsatwithers), min($heightsatwithers), max($heightsatwithers), round(array_sum($heightsatwithers)/count($heightsatwithers), 2), round($heightsatwithers_sd, 2)
						));
					}
					else{
						$sheet->row(10, array(
							'Height at Withers, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($normalteats != []){
						$sheet->row(11, array(
							'Number of Normal Teats', count($normalteats), min($normalteats), max($normalteats), round(array_sum($normalteats)/count($normalteats), 2), round($normalteats_sd, 2)
						));
					}
					else{
						$sheet->row(11, array(
							'Number of Normal Teats', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
				});	
			})->download('csv');
		}

		public function morphoCharsBoarDownloadCSV(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->orWhere("status", "dead breeder")->orWhere("status", "sold breeder")->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

			$filter = "Boar";

			// sorts pigs per sex
			$sows = [];
			$boars = [];
			foreach ($alive as $pig) {
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
			foreach ($alive as $pig) {
				$pigproperties = $pig->getAnimalProperties();
				foreach ($pigproperties as $pigproperty) {
					if($pigproperty->property_id == 3){ //date farrowed
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
			$ages_collected_all = [];
			
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
				$dc = $boar->getAnimalProperties()->where("property_id", 21)->first();
				if(!is_null($dc) && $dc->value != ""){
					$date_collected = Carbon::parse($dc->value);
					$bday = $boar->getAnimalProperties()->where("property_id", 3)->first();
					if(!is_null($bday) && $bday->value != "Not specified"){
						$age = $date_collected->diffInMonths(Carbon::parse($bday->value));
						array_push($ages_collected_all, $age);
					}
				}
			}
			foreach ($boarsalive as $boaralive) {
				$properties = $boaralive->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 21){ // date collected for morpho chars
						if($property->value != ""){
							$date_collected = $property->value;
							$bday = $boaralive->getAnimalProperties()->where("property_id", 3)->first();
							if(!is_null($bday) && $bday->value != "Not specified"){
								$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday->value));
								array_push($ages_collected, $age);
							}
						}
					}
					if($property->property_id == 22){ //earlength
						if($property->value != ""){
							$earlength = $property->value;
							array_push($earlengths, $earlength);
						}
					}
					if($property->property_id == 23){ //headlength
						if($property->value != ""){
							$headlength = $property->value;
							array_push($headlengths, $headlength);
						}
					}
					if($property->property_id == 24){ //snoutlength
						if($property->value != ""){
							$snoutlength = $property->value;
							array_push($snoutlengths, $snoutlength);
						}
					}
					if($property->property_id == 25){ //bodylength
						if($property->value != ""){
							$bodylength = $property->value;
							array_push($bodylengths, $bodylength);
						}
					}
					if($property->property_id == 26){ //heartgirth
						if($property->value != ""){
							$heartgirth = $property->value;
							array_push($heartgirths, $heartgirth);
						}
					}
					if($property->property_id == 27){ //pelvicwidth
						if($property->value != ""){
							$pelvicwidth = $property->value;
							array_push($pelvicwidths, $pelvicwidth);
						}
					}
					if($property->property_id == 28){ //taillength
						if($property->value != ""){
							$taillength = $property->value;
							array_push($taillengths, $taillength);
						}
					}
					if($property->property_id == 29){ //heightatwithers
						if($property->value != ""){
							$heightatwithers = $property->value;
							array_push($heightsatwithers, $heightatwithers);
						}
					}
					if($property->property_id == 30){ //numberofnormalteats
						if($property->value != ""){
							$numberofnormalteats = $property->value;
							array_push($normalteats, $numberofnormalteats);
						}
					}
					if($property->property_id == 31){ //ponderalindex
						if($property->value != ""){
							$ponderalindex = $property->value;
							array_push($ponderalindices, $ponderalindex);
						}
					}
				}
			}
				

			if($earlengths != []){
				$earlengths_sd = static::standardDeviation($earlengths, false);
			}
			else{
				$earlengths_sd = 0;
			}
			if($headlengths != []){
				$headlengths_sd = static::standardDeviation($headlengths, false);
			}
			else{
				$headlengths_sd = 0;
			}
			if($snoutlengths != []){
				$snoutlengths_sd = static::standardDeviation($snoutlengths, false);
			}
			else{
				$snoutlengths_sd = 0;
			}
			if($bodylengths != []){
				$bodylengths_sd = static::standardDeviation($bodylengths, false);
			}
			else{
				$bodylengths_sd = 0;
			}
			if($heartgirths != []){
				$heartgirths_sd = static::standardDeviation($heartgirths, false);
			}
			else{
				$heartgirths_sd = 0;
			}
			if($pelvicwidths != []){
				$pelvicwidths_sd = static::standardDeviation($pelvicwidths, false);
			}
			else{
				$pelvicwidths_sd = 0;
			}
			if($ponderalindices != []){
				$ponderalindices_sd = static::standardDeviation($ponderalindices, false);
			}
			else{
				$ponderalindices_sd = 0;
			}
			if($taillengths != []){
				$taillengths_sd = static::standardDeviation($taillengths, false);
			}
			else{
				$taillengths_sd = 0;
			}
			if($heightsatwithers != []){
				$heightsatwithers_sd = static::standardDeviation($heightsatwithers, false);
			}
			else{
				$heightsatwithers_sd = 0;
			}
			if($normalteats != []){
				$normalteats_sd = static::standardDeviation($normalteats, false);
			}
			else{
				$normalteats_sd = 0;
			}
			
			$now = new Carbon();

			
			return Excel::create('morphochars_boar_'.$now, function($excel) use ($earlengths, $headlengths, $snoutlengths, $bodylengths, $heartgirths, $pelvicwidths, $ponderalindices, $taillengths, $heightsatwithers, $normalteats, $earlengths_sd, $headlengths_sd, $snoutlengths_sd, $bodylengths_sd, $heartgirths_sd, $pelvicwidths_sd, $ponderalindices_sd, $taillengths_sd, $heightsatwithers_sd, $normalteats_sd, $now) {
				$excel->sheet('herd', function($sheet) use ($earlengths, $headlengths, $snoutlengths, $bodylengths, $heartgirths, $pelvicwidths, $ponderalindices, $taillengths, $heightsatwithers, $normalteats, $earlengths_sd, $headlengths_sd, $snoutlengths_sd, $bodylengths_sd, $heartgirths_sd, $pelvicwidths_sd, $ponderalindices_sd, $taillengths_sd, $heightsatwithers_sd, $normalteats_sd, $now) {
					$sheet->setOrientation('landscape');
					$sheet->row(1, array(
						'Property', 'Pigs with data', 'Minimum', 'Maximum', 'Average', 'Standard Deviation'
					));
					if($earlengths != []){
						$sheet->row(2, array(
							'Ear Length, cm', count($earlengths), min($earlengths), max($earlengths), round(array_sum($earlengths)/count($earlengths), 2), round($earlengths_sd, 2)
						));
					}
					else{
						$sheet->row(2, array(
							'Ear Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($headlengths != []){
						$sheet->row(3, array(
							'Head Length, cm', count($headlengths), min($headlengths), max($headlengths), round(array_sum($headlengths)/count($headlengths), 2), round($headlengths_sd, 2)
						));
					}
					else{
						$sheet->row(3, array(
							'Head Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($snoutlengths != []){
						$sheet->row(4, array(
							'Snout Length, cm', count($snoutlengths), min($snoutlengths), max($snoutlengths), round(array_sum($snoutlengths)/count($snoutlengths), 2), round($snoutlengths_sd, 2)
						));
					}
					else{
						$sheet->row(4, array(
							'Snout Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($bodylengths != []){
						$sheet->row(5, array(
							'Body Length, cm', count($bodylengths), min($bodylengths), max($bodylengths), round(array_sum($bodylengths)/count($bodylengths), 2), round($bodylengths_sd, 2)
						));
					}
					else{
						$sheet->row(5, array(
							'Body Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($heartgirths != []){
						$sheet->row(6, array(
							'Heart Girth, cm', count($heartgirths), min($heartgirths), max($heartgirths), round(array_sum($heartgirths)/count($heartgirths), 2), round($heartgirths_sd, 2)
						));
					}
					else{
						$sheet->row(6, array(
							'Heart Girth, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($pelvicwidths != []){
						$sheet->row(7, array(
							'Pelvic Width, cm', count($pelvicwidths), min($pelvicwidths), max($pelvicwidths), round(array_sum($pelvicwidths)/count($pelvicwidths), 2), round($pelvicwidths_sd, 2)
						));
					}
					else{
						$sheet->row(7, array(
							'Pelvic Width, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($ponderalindices != []){
						$sheet->row(8, array(
							'Ponderal Index, kg/m3', count($ponderalindices), min($ponderalindices), max($ponderalindices), round(array_sum($ponderalindices)/count($ponderalindices), 2), round($ponderalindices_sd, 2)
						));
					}
					else{
						$sheet->row(8, array(
							'Ponderal Index, kg/m3', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($taillengths != []){
						$sheet->row(9, array(
							'Tail Length, cm', count($taillengths), min($taillengths), max($taillengths), round(array_sum($taillengths)/count($taillengths), 2), round($taillengths_sd, 2)
						));
					}
					else{
						$sheet->row(9, array(
							'Tail Length, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($heightsatwithers != []){
						$sheet->row(10, array(
							'Height at Withers, cm', count($heightsatwithers), min($heightsatwithers), max($heightsatwithers), round(array_sum($heightsatwithers)/count($heightsatwithers), 2), round($heightsatwithers_sd, 2)
						));
					}
					else{
						$sheet->row(10, array(
							'Height at Withers, cm', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($normalteats != []){
						$sheet->row(11, array(
							'Number of Normal Teats', count($normalteats), min($normalteats), max($normalteats), round(array_sum($normalteats)/count($normalteats), 2), round($normalteats_sd, 2)
						));
					}
					else{
						$sheet->row(11, array(
							'Number of Normal Teats', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
				});	
			})->download('csv');
		}

		public function getMorphometricCharacteristicsReportPage(){ // function to display Morphometric Characteristics Report page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "dead breeder")
													->orWhere("status", "removed breeder");
													})->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();
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
			foreach ($alive as $pig) {
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
					if($pigproperty->property_id == 3){ //date farrowed
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
			$ages_collected_all = [];
			foreach ($pigs as $pig) {
				$dc = $pig->getAnimalProperties()->where("property_id", 21)->first();
				if(!is_null($dc) && $dc->value != ""){
					$date_collected = Carbon::parse($dc->value);
					$bday = $pig->getAnimalProperties()->where("property_id", 3)->first();
					if(!is_null($bday) && $bday->value != "Not specified"){
						$age = $date_collected->diffInMonths(Carbon::parse($bday->value));
						array_push($ages_collected_all, $age);
					}
				}
			}
			foreach ($alive as $pig) {
				$properties = $pig->getAnimalProperties();
				foreach ($properties as $property) {
					if($property->property_id == 21){ // date collected for morpho chars
						if($property->value != ""){
							$date_collected = $property->value;
							$bday = $pig->getAnimalProperties()->where("property_id", 3)->first();
							if(!is_null($bday) && $bday->value != "Not specified"){
								$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday->value));
								array_push($ages_collected, $age);
							}
						}
					}
					if($property->property_id == 22){ //earlength
						if($property->value != ""){
							$earlength = $property->value;
							array_push($earlengths, $earlength);
						}
					}
					if($property->property_id == 23){ //headlength
						if($property->value != ""){
							$headlength = $property->value;
							array_push($headlengths, $headlength);
						}
					}
					if($property->property_id == 24){ //snoutlength
						if($property->value != ""){
							$snoutlength = $property->value;
							array_push($snoutlengths, $snoutlength);
						}
					}
					if($property->property_id == 25){ //bodylength
						if($property->value != ""){
							$bodylength = $property->value;
							array_push($bodylengths, $bodylength);
						}
					}
					if($property->property_id == 26){ //heartgirth
						if($property->value != ""){
							$heartgirth = $property->value;
							array_push($heartgirths, $heartgirth);
						}
					}
					if($property->property_id == 27){ //pelvicwidth
						if($property->value != ""){
							$pelvicwidth = $property->value;
							array_push($pelvicwidths, $pelvicwidth);
						}
					}
					if($property->property_id == 28){ //taillength
						if($property->value != ""){
							$taillength = $property->value;
							array_push($taillengths, $taillength);
						}
					}
					if($property->property_id == 29){ //heightatwithers
						if($property->value != ""){
							$heightatwithers = $property->value;
							array_push($heightsatwithers, $heightatwithers);
						}
					}
					if($property->property_id == 30){ //numberofnormalteats
						if($property->value != ""){
							$numberofnormalteats = $property->value;
							array_push($normalteats, $numberofnormalteats);
						}
					}
					if($property->property_id == 31){ //ponderalindex
						if($property->value != ""){
							$ponderalindex = $property->value;
							array_push($ponderalindices, $ponderalindex);
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

			$now = new Carbon();

			return view('pigs.morphocharsreport', compact('pigs', 'filter', 'sows', 'boars', 'earlengths', 'headlengths', 'snoutlengths', 'bodylengths', 'heartgirths', 'pelvicwidths', 'ponderalindices', 'taillengths', 'heightsatwithers', 'normalteats', 'earlengths_sd', 'headlengths_sd', 'snoutlengths_sd', 'bodylengths_sd', 'heartgirths_sd', 'pelvicwidths_sd', 'ponderalindices_sd', 'taillengths_sd', 'heightsatwithers_sd', 'normalteats_sd', 'years', 'ages_collected', 'ages_collected_all', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars', 'now'));
		}

		public function filterMorphometricCharacteristicsReport(Request $request){ // function to filter Morphometric Characteristics Report
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->orWhere("status", "dead breeder")->orWhere("status", "sold breeder")->get();

			$alive = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$sold = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "sold breeder")->get();
			$dead = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "dead breeder")->get();
			$removed = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "removed breeder")->get();

			$filter = $request->filter_keywords2;

			// sorts pigs per sex
			$sows = [];
			$boars = [];
			foreach ($alive as $pig) {
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
			foreach ($alive as $pig) {
				$pigproperties = $pig->getAnimalProperties();
				foreach ($pigproperties as $pigproperty) {
					if($pigproperty->property_id == 3){ //date farrowed
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
			$ages_collected_all = [];
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
					$dc = $sow->getAnimalProperties()->where("property_id", 21)->first();
					if(!is_null($dc) && $dc->value != ""){
						$date_collected = Carbon::parse($dc->value);
						$bday = $sow->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bday) && $bday->value != "Not specified"){
							$age = $date_collected->diffInMonths(Carbon::parse($bday->value));
							array_push($ages_collected_all, $age);
						}
					}
				}
				foreach ($sowsalive as $sowalive) {
					$properties = $sowalive->getAnimalProperties();
					foreach ($properties as $property) {
						if($property->property_id == 21){ // date collected for morpho chars
							if($property->value != ""){
								$date_collected = $property->value;
								$bday = $sowalive->getAnimalProperties()->where("property_id", 3)->first();
								if(!is_null($bday) && $bday->value != "Not specified"){
									$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday->value));
									array_push($ages_collected, $age);
								}
							}
						}
						if($property->property_id == 22){ //earlength
							if($property->value != ""){
								$earlength = $property->value;
								array_push($earlengths, $earlength);
							}
						}
						if($property->property_id == 23){ //headlength
							if($property->value != ""){
								$headlength = $property->value;
								array_push($headlengths, $headlength);
							}
						}
						if($property->property_id == 24){ //snoutlength
							if($property->value != ""){
								$snoutlength = $property->value;
								array_push($snoutlengths, $snoutlength);
							}
						}
						if($property->property_id == 25){ //bodylength
							if($property->value != ""){
								$bodylength = $property->value;
								array_push($bodylengths, $bodylength);
							}
						}
						if($property->property_id == 26){ //heartgirth
							if($property->value != ""){
								$heartgirth = $property->value;
								array_push($heartgirths, $heartgirth);
							}
						}
						if($property->property_id == 27){ //pelvicwidth
							if($property->value != ""){
								$pelvicwidth = $property->value;
								array_push($pelvicwidths, $pelvicwidth);
							}
						}
						if($property->property_id == 28){ //taillength
							if($property->value != ""){
								$taillength = $property->value;
								array_push($taillengths, $taillength);
							}
						}
						if($property->property_id == 29){ //heightatwithers
							if($property->value != ""){
								$heightatwithers = $property->value;
								array_push($heightsatwithers, $heightatwithers);
							}
						}
						if($property->property_id == 30){ //numberofnormalteats
							if($property->value != ""){
								$numberofnormalteats = $property->value;
								array_push($normalteats, $numberofnormalteats);
							}
						}
						if($property->property_id == 31){ //ponderalindex
							if($property->value != ""){
								$ponderalindex = $property->value;
								array_push($ponderalindices, $ponderalindex);
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
					$dc = $boar->getAnimalProperties()->where("property_id", 21)->first();
					if(!is_null($dc) && $dc->value != ""){
						$date_collected = Carbon::parse($dc->value);
						$bday = $boar->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bday) && $bday->value != "Not specified"){
							$age = $date_collected->diffInMonths(Carbon::parse($bday->value));
							array_push($ages_collected_all, $age);
						}
					}
				}
				foreach ($boarsalive as $boaralive) {
					$properties = $boaralive->getAnimalProperties();
					foreach ($properties as $property) {
						if($property->property_id == 21){ // date collected for morpho chars
							if($property->value != ""){
								$date_collected = $property->value;
								$bday = $boaralive->getAnimalProperties()->where("property_id", 3)->first();
								if(!is_null($bday) && $bday->value != "Not specified"){
									$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday->value));
									array_push($ages_collected, $age);
								}
							}
						}
						if($property->property_id == 22){ //earlength
							if($property->value != ""){
								$earlength = $property->value;
								array_push($earlengths, $earlength);
							}
						}
						if($property->property_id == 23){ //headlength
							if($property->value != ""){
								$headlength = $property->value;
								array_push($headlengths, $headlength);
							}
						}
						if($property->property_id == 24){ //snoutlength
							if($property->value != ""){
								$snoutlength = $property->value;
								array_push($snoutlengths, $snoutlength);
							}
						}
						if($property->property_id == 25){ //bodylength
							if($property->value != ""){
								$bodylength = $property->value;
								array_push($bodylengths, $bodylength);
							}
						}
						if($property->property_id == 26){ //heartgirth
							if($property->value != ""){
								$heartgirth = $property->value;
								array_push($heartgirths, $heartgirth);
							}
						}
						if($property->property_id == 27){ //pelvicwidth
							if($property->value != ""){
								$pelvicwidth = $property->value;
								array_push($pelvicwidths, $pelvicwidth);
							}
						}
						if($property->property_id == 28){ //taillength
							if($property->value != ""){
								$taillength = $property->value;
								array_push($taillengths, $taillength);
							}
						}
						if($property->property_id == 29){ //heightatwithers
							if($property->value != ""){
								$heightatwithers = $property->value;
								array_push($heightsatwithers, $heightatwithers);
							}
						}
						if($property->property_id == 30){ //numberofnormalteats
							if($property->value != ""){
								$numberofnormalteats = $property->value;
								array_push($normalteats, $numberofnormalteats);
							}
						}
						if($property->property_id == 31){ //ponderalindex
							if($property->value != ""){
								$ponderalindex = $property->value;
								array_push($ponderalindices, $ponderalindex);
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
					$dc = $pig->getAnimalProperties()->where("property_id", 21)->first();
					if(!is_null($dc) && $dc->value != ""){
						$date_collected = Carbon::parse($dc->value);
						$bday = $pig->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bday) && $bday->value != "Not specified"){
							$age = $date_collected->diffInMonths(Carbon::parse($bday->value));
							array_push($ages_collected_all, $age);
						}
					}
				}
				foreach ($alive as $pig) {
					$properties = $pig->getAnimalProperties();
					foreach ($properties as $property) {
						if($property->property_id == 21){ // date collected for morpho chars
							if($property->value != ""){
								$date_collected = $property->value;
								$bday = $pig->getAnimalProperties()->where("property_id", 3)->first();
								if(!is_null($bday) && $bday->value != "Not specified"){
									$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday->value));
									array_push($ages_collected, $age);
								}
							}
						}
						if($property->property_id == 22){ //earlength
							if($property->value != ""){
								$earlength = $property->value;
								array_push($earlengths, $earlength);
							}
						}
						if($property->property_id == 23){ //headlength
							if($property->value != ""){
								$headlength = $property->value;
								array_push($headlengths, $headlength);
							}
						}
						if($property->property_id == 24){ //snoutlength
							if($property->value != ""){
								$snoutlength = $property->value;
								array_push($snoutlengths, $snoutlength);
							}
						}
						if($property->property_id == 25){ //bodylength
							if($property->value != ""){
								$bodylength = $property->value;
								array_push($bodylengths, $bodylength);
							}
						}
						if($property->property_id == 26){ //heartgirth
							if($property->value != ""){
								$heartgirth = $property->value;
								array_push($heartgirths, $heartgirth);
							}
						}
						if($property->property_id == 27){ //pelvicwidth
							if($property->value != ""){
								$pelvicwidth = $property->value;
								array_push($pelvicwidths, $pelvicwidth);
							}
						}
						if($property->property_id == 28){ //taillength
							if($property->value != ""){
								$taillength = $property->value;
								array_push($taillengths, $taillength);
							}
						}
						if($property->property_id == 29){ //heightatwithers
							if($property->value != ""){
								$heightatwithers = $property->value;
								array_push($heightsatwithers, $heightatwithers);
							}
						}
						if($property->property_id == 30){ //numberofnormalteats
							if($property->value != ""){
								$numberofnormalteats = $property->value;
								array_push($normalteats, $numberofnormalteats);
							}
						}
						if($property->property_id == 31){ //ponderalindex
							if($property->value != ""){
								$ponderalindex = $property->value;
								array_push($ponderalindices, $ponderalindex);
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

			$now = new Carbon();

			return view('pigs.morphocharsreport', compact('pigs', 'filter', 'sows', 'boars', 'earlengths', 'headlengths', 'snoutlengths', 'bodylengths', 'heartgirths', 'pelvicwidths', 'ponderalindices', 'taillengths', 'heightsatwithers', 'normalteats', 'earlengths_sd', 'headlengths_sd', 'snoutlengths_sd', 'bodylengths_sd', 'heartgirths_sd', 'pelvicwidths_sd', 'ponderalindices_sd', 'taillengths_sd', 'heightsatwithers_sd', 'normalteats_sd', 'years', 'ages_collected', 'ages_collected_all', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars', 'now'));
		}

		public static function getWeightsPerYearOfBirth($year, $property_id){ // function to get weights per year of birth
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->get();

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

		public function growthPerfDownloadPDF(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->get();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$growers = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "active")->get();
			$now = Carbon::now('Asia/Manila');

			//year of birth
			$years = [];
			$tempyears = [];
			foreach ($pigs as $pig) {
				$pigproperties = $pig->getAnimalProperties();
				foreach ($pigproperties as $pigproperty) {
					if($pigproperty->property_id == 3){ //date farrowed
						if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
							$year = Carbon::parse($pigproperty->value)->year;
							array_push($tempyears, $year);
							$years = array_reverse(array_sort(array_unique($tempyears)));
						}
					}
				}
			}

			// weights for all pigs
			$agesweaned_all = [];
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
					if($property->property_id == 3){ // date farrowed
						if(!is_null($property) && $property->value != "Not specified"){
							if(!is_null($pig->getAnimalProperties()->where("property_id", 6)->first()) && $pig->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
								$bday = Carbon::parse($property->value);
								$weaning = Carbon::parse($pig->getAnimalProperties()->where("property_id", 6)->first()->value);
								$age = $weaning->diffInDays($bday);
								array_push($agesweaned_all, $age);
							}
						}
					}
					if($property->property_id == 5){ //birth weights
						if(!is_null($property) && $property->value != ""){
							$bweight = $property->value;
							array_push($bweights, $bweight);
						}
					}
					if($property->property_id == 7){ //weaning weights
						if(!is_null($property) && $property->value != ""){
							$wweight = $property->value;
							array_push($wweights, $wweight);
						}
					}
					if($property->property_id == 32){ //45d
						if(!is_null($property) && $property->value != ""){
							$weight45d = $property->value;
							array_push($weights45d, $weight45d);
						}
					}
					if($property->property_id == 33){ //60d
						if(!is_null($property) && $property->value != ""){
							$weight60d = $property->value;
							array_push($weights60d, $weight60d);
						}
					}
					if($property->property_id == 34){ //90d
						if(!is_null($property) && $property->value != ""){
							$weight90d = $property->value;
							array_push($weights90d, $weight90d);
						}
					}
					if($property->property_id == 35){ //150d
						if(!is_null($property) && $property->value != ""){
							$weight150d = $property->value;
							array_push($weights150d, $weight150d);
						}
					}
					if($property->property_id == 36){ //180d
						if(!is_null($property) && $property->value != ""){
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
			$agesweaned_breeders = [];
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
					if($breederproperty->property_id == 3){ // date farrowed
						if(!is_null($breederproperty) && $breederproperty->value != "Not specified"){
							if(!is_null($breeder->getAnimalProperties()->where("property_id", 6)->first()) && $breeder->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
								$bday = Carbon::parse($breederproperty->value);
								$weaned = Carbon::parse($breeder->getAnimalProperties()->where("property_id", 6)->first()->value);
								$age = $weaned->diffInDays($bday);
								array_push($agesweaned_breeders, $age);
							}
						}
					}
					if($breederproperty->property_id == 5){ //birth weights
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$bweight_breeders = $breederproperty->value;
							array_push($bweights_breeders, $bweight_breeders);
						}
					}
					if($breederproperty->property_id == 7){ //weaning weights
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$wweight_breeders = $breederproperty->value;
							array_push($wweights_breeders, $wweight_breeders);
						}
					}
					if($breederproperty->property_id == 32){ //45d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$weight45d_breeders = $breederproperty->value;
							array_push($weights45d_breeders, $weight45d_breeders);
						}
					}
					if($breederproperty->property_id == 33){ //60d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$weight60d_breeders = $breederproperty->value;
							array_push($weights60d_breeders, $weight60d_breeders);
						}
					}
					if($breederproperty->property_id == 34){ //90d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$weight90d_breeders = $breederproperty->value;
							array_push($weights90d_breeders, $weight90d_breeders);
						}
					}
					if($breederproperty->property_id == 35){ //150d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$weight150d_breeders = $breederproperty->value;
							array_push($weights150d_breeders, $weight150d_breeders);
						}
					}
					if($breederproperty->property_id == 36){ //180d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
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
			$agesweaned_growers = [];
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
					if($growerproperty->property_id == 3){ // date farrowed
						if(!is_null($growerproperty) && $growerproperty->value != "Not specified"){
							if(!is_null($grower->getAnimalProperties()->where("property_id", 6)->first()) && $grower->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
								$bday =  Carbon::parse($growerproperty->value);
								$weaned = Carbon::parse($grower->getAnimalProperties()->where("property_id", 6)->first()->value);
								$age = $weaned->diffInDays($bday);
								array_push($agesweaned_growers, $age);
							}
						}
					}
					if($growerproperty->property_id == 5){ //birth weights
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$bweight_growers = $growerproperty->value;
							array_push($bweights_growers, $bweight_growers);
						}
					}
					if($growerproperty->property_id == 7){ //weaning weights
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$wweight_growers = $growerproperty->value;
							array_push($wweights_growers, $wweight_growers);
						}
					}
					if($growerproperty->property_id == 32){ //45d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$weight45d_growers = $growerproperty->value;
							array_push($weights45d_growers, $weight45d_growers);
						}
					}
					if($growerproperty->property_id == 33){ //60d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$weight60d_growers = $growerproperty->value;
							array_push($weights60d_growers, $weight60d_growers);
						}
					}
					if($growerproperty->property_id == 34){ //90d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$weight90d_growers = $growerproperty->value;
							array_push($weights90d_growers, $weight90d_growers);
						}
					}
					if($growerproperty->property_id == 35){ //150d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$weight150d_growers = $growerproperty->value;
							array_push($weights150d_growers, $weight150d_growers);
						}
					}
					if($growerproperty->property_id == 36){ //180d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
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


			$pdf = PDF::loadView('pigs.growthperfpdf', compact('pigs', 'breeders', 'growers', 'bweights', 'wweights', 'weights45d', 'weights60d', 'weights90d', 'weights150d', 'weights180d', 'bweights_sd', 'wweights_sd', 'weights45d_sd', 'weights60d_sd', 'weights90d_sd', 'weights150d_sd', 'weights180d_sd', 'bweights_breeders', 'wweights_breeders', 'weights45d_breeders', 'weights60d_breeders', 'weights90d_breeders', 'weights150d_breeders', 'weights180d_breeders', 'bweights_breeders_sd', 'wweights_breeders_sd', 'weights45d_breeders_sd', 'weights60d_breeders_sd', 'weights90d_breeders_sd', 'weights150d_breeders_sd', 'weights180d_breeders_sd', 'bweights_growers', 'wweights_growers', 'weights45d_growers', 'weights60d_growers', 'weights90d_growers', 'weights150d_growers', 'weights180d_growers', 'bweights_growers_sd', 'wweights_growers_sd', 'weights45d_growers_sd', 'weights60d_growers_sd', 'weights90d_growers_sd', 'weights150d_growers_sd', 'weights180d_growers_sd', 'years', 'now', 'agesweaned_all', 'agesweaned_breeders', 'agesweaned_growers'));
			return $pdf->download('growthperfreport_'.$now.'.pdf');
		}

		public function growthPerfDownloadCSV(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("farm_id", $farm->id)->get();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$growers = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "active")->get();
			$now = Carbon::now('Asia/Manila');

			//year of birth
			$years = [];
			$tempyears = [];
			foreach ($pigs as $pig) {
				$pigproperties = $pig->getAnimalProperties();
				foreach ($pigproperties as $pigproperty) {
					if($pigproperty->property_id == 3){ //date farrowed
						if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
							$year = Carbon::parse($pigproperty->value)->year;
							array_push($tempyears, $year);
							$years = array_reverse(array_sort(array_unique($tempyears)));
						}
					}
				}
			}

			// weights for all pigs
			$agesweaned_all = [];
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
					if($property->property_id == 3){ // date farrowed
						if(!is_null($property) && $property->value != "Not specified"){
							if(!is_null($pig->getAnimalProperties()->where("property_id", 6)->first()) && $pig->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
								$bday = Carbon::parse($property->value);
								$weaning = Carbon::parse($pig->getAnimalProperties()->where("property_id", 6)->first()->value);
								$age = $weaning->diffInDays($bday);
								array_push($agesweaned_all, $age);
							}
						}
					}
					if($property->property_id == 5){ //birth weights
						if(!is_null($property) && $property->value != ""){
							$bweight = $property->value;
							array_push($bweights, $bweight);
						}
					}
					if($property->property_id == 7){ //weaning weights
						if(!is_null($property) && $property->value != ""){
							$wweight = $property->value;
							array_push($wweights, $wweight);
						}
					}
					if($property->property_id == 32){ //45d
						if(!is_null($property) && $property->value != ""){
							$weight45d = $property->value;
							array_push($weights45d, $weight45d);
						}
					}
					if($property->property_id == 33){ //60d
						if(!is_null($property) && $property->value != ""){
							$weight60d = $property->value;
							array_push($weights60d, $weight60d);
						}
					}
					if($property->property_id == 34){ //90d
						if(!is_null($property) && $property->value != ""){
							$weight90d = $property->value;
							array_push($weights90d, $weight90d);
						}
					}
					if($property->property_id == 35){ //150d
						if(!is_null($property) && $property->value != ""){
							$weight150d = $property->value;
							array_push($weights150d, $weight150d);
						}
					}
					if($property->property_id == 36){ //180d
						if(!is_null($property) && $property->value != ""){
							$weight180d = $property->value;
							array_push($weights180d, $weight180d);
						}
					}
				}
			}
			
			if($bweights != []){
				$bweights_sd = static::standardDeviation($bweights, false);
			}
			else{
				$bweights_sd = 0;
			}
			if($wweights != []){
				$wweights_sd = static::standardDeviation($wweights, false);
			}
			else{
				$wweights_sd = 0;
			}
			if($weights45d != []){
				$weights45d_sd = static::standardDeviation($weights45d, false);
			}
			else{
				$weights45d_sd = 0;
			}
			if($weights60d != []){
				$weights60d_sd = static::standardDeviation($weights60d, false);
			}
			else{
				$weights60d_sd = 0;
			}
			if($weights90d != []){
				$weights90d_sd = static::standardDeviation($weights90d, false);
			}
			else{
				$weights90d_sd = 0;
			}
			if($weights150d != []){
				$weights150d_sd = static::standardDeviation($weights150d, false); 
			}
			else{
				$weights150d_sd = 0;
			}
			if($weights180d != []){
				$weights180d_sd = static::standardDeviation($weights180d, false); 
			}
			else{
				$weights180d_sd = 0;
			}

			// weights for breeders
			$agesweaned_breeders = [];
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
					if($breederproperty->property_id == 3){ // date farrowed
						if(!is_null($breederproperty) && $breederproperty->value != "Not specified"){
							if(!is_null($breeder->getAnimalProperties()->where("property_id", 6)->first()) && $breeder->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
								$bday = Carbon::parse($breederproperty->value);
								$weaned = Carbon::parse($breeder->getAnimalProperties()->where("property_id", 6)->first()->value);
								$age = $weaned->diffInDays($bday);
								array_push($agesweaned_breeders, $age);
							}
						}
					}
					if($breederproperty->property_id == 5){ //birth weights
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$bweight_breeders = $breederproperty->value;
							array_push($bweights_breeders, $bweight_breeders);
						}
					}
					if($breederproperty->property_id == 7){ //weaning weights
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$wweight_breeders = $breederproperty->value;
							array_push($wweights_breeders, $wweight_breeders);
						}
					}
					if($breederproperty->property_id == 32){ //45d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$weight45d_breeders = $breederproperty->value;
							array_push($weights45d_breeders, $weight45d_breeders);
						}
					}
					if($breederproperty->property_id == 33){ //60d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$weight60d_breeders = $breederproperty->value;
							array_push($weights60d_breeders, $weight60d_breeders);
						}
					}
					if($breederproperty->property_id == 34){ //90d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$weight90d_breeders = $breederproperty->value;
							array_push($weights90d_breeders, $weight90d_breeders);
						}
					}
					if($breederproperty->property_id == 35){ //150d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$weight150d_breeders = $breederproperty->value;
							array_push($weights150d_breeders, $weight150d_breeders);
						}
					}
					if($breederproperty->property_id == 36){ //180d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$weight180d_breeders = $breederproperty->value;
							array_push($weights180d_breeders, $weight180d_breeders);
						}
					}
				}
			}
			if($bweights_breeders != []){
				$bweights_breeders_sd = static::standardDeviation($bweights_breeders, false);
			}
			else{
				$bweights_breeders_sd = 0;
			}
			if($wweights_breeders != []){
				$wweights_breeders_sd = static::standardDeviation($wweights_breeders, false);
			}
			else{
				$wweights_breeders_sd = 0;
			}
			if($weights45d_breeders != []){
				$weights45d_breeders_sd = static::standardDeviation($weights45d_breeders, false);
			}
			else{
				$weights45d_breeders_sd = 0;
			}
			if($weights60d_breeders != []){
				$weights60d_breeders_sd = static::standardDeviation($weights60d_breeders, false);
			}
			else{
				$weights60d_breeders_sd = 0;
			}
			if($weights90d_breeders != []){
				$weights90d_breeders_sd = static::standardDeviation($weights90d_breeders, false);
			}
			else{
				$weights90d_breeders_sd = 0;
			}
			if($weights150d_breeders != []){
				$weights150d_breeders_sd = static::standardDeviation($weights150d_breeders, false); 
			}
			else{
				$weights150d_breeders_sd = 0;
			}
			if($weights180d_breeders != []){
				$weights180d_breeders_sd = static::standardDeviation($weights180d_breeders, false); 
			}
			else{
				$weights180d_breeders_sd = 0;
			}

			// weights for growers
			$agesweaned_growers = [];
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
					if($growerproperty->property_id == 3){ // date farrowed
						if(!is_null($growerproperty) && $growerproperty->value != "Not specified"){
							if(!is_null($grower->getAnimalProperties()->where("property_id", 6)->first()) && $grower->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
								$bday =  Carbon::parse($growerproperty->value);
								$weaned = Carbon::parse($grower->getAnimalProperties()->where("property_id", 6)->first()->value);
								$age = $weaned->diffInDays($bday);
								array_push($agesweaned_growers, $age);
							}
						}
					}
					if($growerproperty->property_id == 5){ //birth weights
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$bweight_growers = $growerproperty->value;
							array_push($bweights_growers, $bweight_growers);
						}
					}
					if($growerproperty->property_id == 7){ //weaning weights
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$wweight_growers = $growerproperty->value;
							array_push($wweights_growers, $wweight_growers);
						}
					}
					if($growerproperty->property_id == 32){ //45d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$weight45d_growers = $growerproperty->value;
							array_push($weights45d_growers, $weight45d_growers);
						}
					}
					if($growerproperty->property_id == 33){ //60d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$weight60d_growers = $growerproperty->value;
							array_push($weights60d_growers, $weight60d_growers);
						}
					}
					if($growerproperty->property_id == 34){ //90d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$weight90d_growers = $growerproperty->value;
							array_push($weights90d_growers, $weight90d_growers);
						}
					}
					if($growerproperty->property_id == 35){ //150d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$weight150d_growers = $growerproperty->value;
							array_push($weights150d_growers, $weight150d_growers);
						}
					}
					if($growerproperty->property_id == 36){ //180d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$weight180d_growers = $growerproperty->value;
							array_push($weights180d_growers, $weight180d_growers);
						}
					}
				}
			}
			if($bweights_growers != []){
				$bweights_growers_sd = static::standardDeviation($bweights_growers, false);
			}
			else{
				$bweights_growers_sd = 0;
			}
			if($wweights_growers != []){
				$wweights_growers_sd = static::standardDeviation($wweights_growers, false);
			}
			else{
				$wweights_growers_sd = 0;
			}
			if($weights45d_growers != []){
				$weights45d_growers_sd = static::standardDeviation($weights45d_growers, false);
			}
			else{
				$weights45d_growers_sd = 0;
			}
			if($weights60d_growers != []){
				$weights60d_growers_sd = static::standardDeviation($weights60d_growers, false);
			}
			else{
				$weights60d_growers_sd = 0;
			}
			if($weights90d_growers != []){
				$weights90d_growers_sd = static::standardDeviation($weights90d_growers, false);
			}
			else{
				$weights90d_growers_sd = 0;
			}
			if($weights150d_growers != []){
				$weights150d_growers_sd = static::standardDeviation($weights150d_growers, false); 
			}
			else{
				$weights150d_growers_sd = 0;
			}
			if($weights180d_growers != []){
				$weights180d_growers_sd = static::standardDeviation($weights180d_growers, false); 
			}
			else{
				$weights180d_growers_sd = 0;
			}

			return Excel::create('growthperfreport_'.$now, function($excel) use ($pigs, $breeders, $growers, $agesweaned_all, $bweights, $wweights, $weights45d, $weights60d, $weights90d, $weights150d, $weights180d, $bweights_sd, $wweights_sd, $weights45d_sd, $weights60d_sd, $weights90d_sd, $weights150d_sd, $weights180d_sd, $agesweaned_breeders, $bweights_breeders, $wweights_breeders, $weights45d_breeders, $weights60d_breeders, $weights90d_breeders, $weights150d_breeders, $weights180d_breeders, $bweights_breeders_sd, $wweights_breeders_sd, $weights45d_breeders_sd, $weights60d_breeders_sd, $weights90d_breeders_sd, $weights150d_breeders_sd, $weights180d_breeders_sd, $agesweaned_growers, $bweights_growers, $wweights_growers, $weights45d_growers, $weights60d_growers, $weights90d_growers, $weights150d_growers, $weights180d_growers, $bweights_growers_sd, $wweights_growers_sd, $weights45d_growers_sd, $weights60d_growers_sd, $weights90d_growers_sd, $weights150d_growers_sd, $weights180d_growers_sd, $now) {
				$excel->sheet('herd', function($sheet) use ($pigs, $breeders, $growers, $agesweaned_all, $bweights, $wweights, $weights45d, $weights60d, $weights90d, $weights150d, $weights180d, $bweights_sd, $wweights_sd, $weights45d_sd, $weights60d_sd, $weights90d_sd, $weights150d_sd, $weights180d_sd, $agesweaned_breeders, $bweights_breeders, $wweights_breeders, $weights45d_breeders, $weights60d_breeders, $weights90d_breeders, $weights150d_breeders, $weights180d_breeders, $bweights_breeders_sd, $wweights_breeders_sd, $weights45d_breeders_sd, $weights60d_breeders_sd, $weights90d_breeders_sd, $weights150d_breeders_sd, $weights180d_breeders_sd, $agesweaned_growers, $bweights_growers, $wweights_growers, $weights45d_growers, $weights60d_growers, $weights90d_growers, $weights150d_growers, $weights180d_growers, $bweights_growers_sd, $wweights_growers_sd, $weights45d_growers_sd, $weights60d_growers_sd, $weights90d_growers_sd, $weights150d_growers_sd, $weights180d_growers_sd, $now) {
					$sheet->setOrientation('landscape');
					$sheet->row(1, array(
						'Herd', 'Total number of pigs: '.count($pigs)
					));
					$sheet->row(2, array(
						'Weighing Age', 'Number of Pigs Weighed', 'Minimum', 'Maximum', 'Average', 'Standard Deviation'
					));
					if($bweights != []){
						$sheet->row(3, array(
							'Birth, kg', count($bweights), min($bweights), max($bweights), round(array_sum($bweights)/count($bweights), 2), round($bweights_sd, 2) 
						));
					}
					else{
						$sheet->row(3, array(
							'Birth, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($wweights != []){
						$sheet->row(4, array(
							'Weaning at '.round(array_sum($agesweaned_all)/count($agesweaned_all), 2).' days, kg', count($wweights), min($wweights), max($wweights), round(array_sum($wweights)/count($wweights), 2), round($wweights_sd, 2) 
						));
					}
					else{
						$sheet->row(4, array(
							'Weaning, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights45d != []){
						$sheet->row(5, array(
							'45 days, kg', count($weights45d), min($weights45d), max($weights45d), round(array_sum($weights45d)/count($weights45d), 2), round($weights45d_sd, 2) 
						));
					}
					else{
						$sheet->row(5, array(
							'45 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights60d != []){
						$sheet->row(6, array(
							'60 days, kg', count($weights60d), min($weights60d), max($weights60d), round(array_sum($weights60d)/count($weights60d), 2), round($weights60d_sd, 2) 
						));
					}
					else{
						$sheet->row(6, array(
							'60 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights90d != []){
						$sheet->row(7, array(
							'90 days, kg', count($weights90d), min($weights90d), max($weights90d), round(array_sum($weights90d)/count($weights90d), 2), round($weights90d_sd, 2) 
						));
					}
					else{
						$sheet->row(7, array(
							'90 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights150d != []){
						$sheet->row(8, array(
							'150 days, kg', count($weights150d), min($weights150d), max($weights150d), round(array_sum($weights150d)/count($weights150d), 2), round($weights150d_sd, 2) 
						));
					}
					else{
						$sheet->row(8, array(
							'150 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights180d != []){
						$sheet->row(9, array(
							'180 days, kg', count($weights180d), min($weights180d), max($weights180d), round(array_sum($weights180d)/count($weights180d), 2), round($weights180d_sd, 2) 
						));
					}
					else{
						$sheet->row(9, array(
							'180 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					$sheet->row(10, array(
						' '
					));
					$sheet->row(11, array(
						'Breeders', 'Total number of breeders: '.count($breeders)
					));
					$sheet->row(12, array(
						'Weighing Age', 'Number of Pigs Weighed', 'Minimum', 'Maximum', 'Average', 'Standard Deviation'
					));
					if($bweights_breeders != []){
						$sheet->row(13, array(
							'Birth, kg', count($bweights_breeders), min($bweights_breeders), max($bweights_breeders), round(array_sum($bweights_breeders)/count($bweights_breeders), 2), round($bweights_breeders_sd, 2) 
						));
					}
					else{
						$sheet->row(13, array(
							'Birth, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($wweights_breeders != []){
						$sheet->row(14, array(
							'Weaning at '.round(array_sum($agesweaned_breeders)/count($agesweaned_breeders), 2).' days, kg', count($wweights_breeders), min($wweights_breeders), max($wweights_breeders), round(array_sum($wweights_breeders)/count($wweights_breeders), 2), round($wweights_breeders_sd, 2) 
						));
					}
					else{
						$sheet->row(14, array(
							'Weaning, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights45d_breeders != []){
						$sheet->row(15, array(
							'45 days, kg', count($weights45d_breeders), min($weights45d_breeders), max($weights45d_breeders), round(array_sum($weights45d_breeders)/count($weights45d_breeders), 2), round($weights45d_breeders_sd, 2) 
						));
					}
					else{
						$sheet->row(15, array(
							'45 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights60d_breeders != []){
						$sheet->row(16, array(
							'60 days, kg', count($weights60d_breeders), min($weights60d_breeders), max($weights60d_breeders), round(array_sum($weights60d_breeders)/count($weights60d_breeders), 2), round($weights60d_breeders_sd, 2) 
						));
					}
					else{
						$sheet->row(16, array(
							'60 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights90d_breeders != []){
						$sheet->row(17, array(
							'90 days, kg', count($weights90d_breeders), min($weights90d_breeders), max($weights90d_breeders), round(array_sum($weights90d_breeders)/count($weights90d_breeders), 2), round($weights90d_breeders_sd, 2) 
						));
					}
					else{
						$sheet->row(17, array(
							'90 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights150d_breeders != []){
						$sheet->row(18, array(
							'150 days, kg', count($weights150d_breeders), min($weights150d_breeders), max($weights150d_breeders), round(array_sum($weights150d_breeders)/count($weights150d_breeders), 2), round($weights150d_breeders_sd, 2) 
						));
					}
					else{
						$sheet->row(18, array(
							'150 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights180d_breeders != []){
						$sheet->row(19, array(
							'180 days, kg', count($weights180d_breeders), min($weights180d_breeders), max($weights180d_breeders), round(array_sum($weights180d_breeders)/count($weights180d_breeders), 2), round($weights180d_breeders_sd, 2) 
						));
					}
					else{
						$sheet->row(19, array(
							'180 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					$sheet->row(20, array(
						' '
					));
					$sheet->row(21, array(
						'Growers', 'Total number of growers: '.count($growers)
					));
					$sheet->row(22, array(
						'Weighing Age', 'Number of Pigs Weighed', 'Minimum', 'Maximum', 'Average', 'Standard Deviation'
					));
					if($bweights_growers != []){
						$sheet->row(23, array(
							'Birth, kg', count($bweights_growers), min($bweights_growers), max($bweights_growers), round(array_sum($bweights_growers)/count($bweights_growers), 2), round($bweights_growers_sd, 2) 
						));
					}
					else{
						$sheet->row(23, array(
							'Birth, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($wweights_growers != []){
						$sheet->row(24, array(
							'Weaning at '.round(array_sum($agesweaned_growers)/count($agesweaned_growers), 2).' days, kg', count($wweights_growers), min($wweights_growers), max($wweights_growers), round(array_sum($wweights_growers)/count($wweights_growers), 2), round($wweights_growers_sd, 2) 
						));
					}
					else{
						$sheet->row(24, array(
							'Weaning, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights45d_growers != []){
						$sheet->row(25, array(
							'45 days, kg', count($weights45d_growers), min($weights45d_growers), max($weights45d_growers), round(array_sum($weights45d_growers)/count($weights45d_growers), 2), round($weights45d_growers_sd, 2) 
						));
					}
					else{
						$sheet->row(25, array(
							'45 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights60d_growers != []){
						$sheet->row(26, array(
							'60 days, kg', count($weights60d_growers), min($weights60d_growers), max($weights60d_growers), round(array_sum($weights60d_growers)/count($weights60d_growers), 2), round($weights60d_growers_sd, 2) 
						));
					}
					else{
						$sheet->row(26, array(
							'60 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights90d_growers != []){
						$sheet->row(27, array(
							'90 days, kg', count($weights90d_growers), min($weights90d_growers), max($weights90d_growers), round(array_sum($weights90d_growers)/count($weights90d_growers), 2), round($weights90d_growers_sd, 2) 
						));
					}
					else{
						$sheet->row(27, array(
							'90 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights150d_growers != []){
						$sheet->row(28, array(
							'150 days, kg', count($weights150d_growers), min($weights150d_growers), max($weights150d_growers), round(array_sum($weights150d_growers)/count($weights150d_growers), 2), round($weights150d_growers_sd, 2) 
						));
					}
					else{
						$sheet->row(28, array(
							'150 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
					if($weights180d_growers != []){
						$sheet->row(29, array(
							'180 days, kg', count($weights180d_growers), min($weights180d_growers), max($weights180d_growers), round(array_sum($weights180d_growers)/count($weights180d_growers), 2), round($weights180d_growers_sd, 2) 
						));
					}
					else{
						$sheet->row(29, array(
							'180 days, kg', 'No data available', 'No data available', 'No data available', 'No data available', 'No data available'
						));
					}
				});	
			})->download('csv');
		}

		public function getGrowthPerformanceReportPage(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->get();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$growers = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "active")->get();
			$now = Carbon::now('Asia/Manila');

			//year of birth
			$years = [];
			$tempyears = [];
			foreach ($pigs as $pig) {
				$pigproperties = $pig->getAnimalProperties();
				foreach ($pigproperties as $pigproperty) {
					if($pigproperty->property_id == 3){ //date farrowed
						if(!is_null($pigproperty->value) && $pigproperty->value != "Not specified"){
							$year = Carbon::parse($pigproperty->value)->year;
							array_push($tempyears, $year);
							$years = array_reverse(array_sort(array_unique($tempyears)));
						}
					}
				}
			}

			// weights for all pigs
			$agesweaned_all = [];
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
					if($property->property_id == 3){ // date farrowed
						if(!is_null($property) && $property->value != "Not specified"){
							if(!is_null($pig->getAnimalProperties()->where("property_id", 6)->first()) && $pig->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
								$bday = Carbon::parse($property->value);
								$weaning = Carbon::parse($pig->getAnimalProperties()->where("property_id", 6)->first()->value);
								$age = $weaning->diffInDays($bday);
								array_push($agesweaned_all, $age);
							}
						}
					}
					if($property->property_id == 5){ //birth weights
						if(!is_null($property) && $property->value != ""){
							$bweight = $property->value;
							array_push($bweights, $bweight);
						}
					}
					if($property->property_id == 7){ //weaning weights
						if(!is_null($property) && $property->value != ""){
							$wweight = $property->value;
							array_push($wweights, $wweight);
						}
					}
					if($property->property_id == 32){ //45d
						if(!is_null($property) && $property->value != ""){
							$weight45d = $property->value;
							array_push($weights45d, $weight45d);
						}
					}
					if($property->property_id == 33){ //60d
						if(!is_null($property) && $property->value != ""){
							$weight60d = $property->value;
							array_push($weights60d, $weight60d);
						}
					}
					if($property->property_id == 34){ //90d
						if(!is_null($property) && $property->value != ""){
							$weight90d = $property->value;
							array_push($weights90d, $weight90d);
						}
					}
					if($property->property_id == 35){ //150d
						if(!is_null($property) && $property->value != ""){
							$weight150d = $property->value;
							array_push($weights150d, $weight150d);
						}
					}
					if($property->property_id == 36){ //180d
						if(!is_null($property) && $property->value != ""){
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
			$agesweaned_breeders = [];
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
					if($breederproperty->property_id == 3){ // date farrowed
						if(!is_null($breederproperty) && $breederproperty->value != "Not specified"){
							if(!is_null($breeder->getAnimalProperties()->where("property_id", 6)->first()) && $breeder->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
								$bday = Carbon::parse($breederproperty->value);
								$weaned = Carbon::parse($breeder->getAnimalProperties()->where("property_id", 6)->first()->value);
								$age = $weaned->diffInDays($bday);
								array_push($agesweaned_breeders, $age);
							}
						}
					}
					if($breederproperty->property_id == 5){ //birth weights
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$bweight_breeders = $breederproperty->value;
							array_push($bweights_breeders, $bweight_breeders);
						}
					}
					if($breederproperty->property_id == 7){ //weaning weights
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$wweight_breeders = $breederproperty->value;
							array_push($wweights_breeders, $wweight_breeders);
						}
					}
					if($breederproperty->property_id == 32){ //45d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$weight45d_breeders = $breederproperty->value;
							array_push($weights45d_breeders, $weight45d_breeders);
						}
					}
					if($breederproperty->property_id == 33){ //60d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$weight60d_breeders = $breederproperty->value;
							array_push($weights60d_breeders, $weight60d_breeders);
						}
					}
					if($breederproperty->property_id == 34){ //90d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$weight90d_breeders = $breederproperty->value;
							array_push($weights90d_breeders, $weight90d_breeders);
						}
					}
					if($breederproperty->property_id == 35){ //150d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
							$weight150d_breeders = $breederproperty->value;
							array_push($weights150d_breeders, $weight150d_breeders);
						}
					}
					if($breederproperty->property_id == 36){ //180d
						if(!is_null($breederproperty) && $breederproperty->value != ""){
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
			$agesweaned_growers = [];
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
					if($growerproperty->property_id == 3){ // date farrowed
						if(!is_null($growerproperty) && $growerproperty->value != "Not specified"){
							if(!is_null($grower->getAnimalProperties()->where("property_id", 6)->first()) && $grower->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
								$bday =  Carbon::parse($growerproperty->value);
								$weaned = Carbon::parse($grower->getAnimalProperties()->where("property_id", 6)->first()->value);
								$age = $weaned->diffInDays($bday);
								array_push($agesweaned_growers, $age);
							}
						}
					}
					if($growerproperty->property_id == 5){ //birth weights
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$bweight_growers = $growerproperty->value;
							array_push($bweights_growers, $bweight_growers);
						}
					}
					if($growerproperty->property_id == 7){ //weaning weights
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$wweight_growers = $growerproperty->value;
							array_push($wweights_growers, $wweight_growers);
						}
					}
					if($growerproperty->property_id == 32){ //45d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$weight45d_growers = $growerproperty->value;
							array_push($weights45d_growers, $weight45d_growers);
						}
					}
					if($growerproperty->property_id == 33){ //60d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$weight60d_growers = $growerproperty->value;
							array_push($weights60d_growers, $weight60d_growers);
						}
					}
					if($growerproperty->property_id == 34){ //90d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$weight90d_growers = $growerproperty->value;
							array_push($weights90d_growers, $weight90d_growers);
						}
					}
					if($growerproperty->property_id == 35){ //150d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
							$weight150d_growers = $growerproperty->value;
							array_push($weights150d_growers, $weight150d_growers);
						}
					}
					if($growerproperty->property_id == 36){ //180d
						if(!is_null($growerproperty) && $growerproperty->value != ""){
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

			return view('pigs.growthperformancereport', compact('pigs', 'breeders', 'growers', 'bweights', 'wweights', 'weights45d', 'weights60d', 'weights90d', 'weights150d', 'weights180d', 'bweights_sd', 'wweights_sd', 'weights45d_sd', 'weights60d_sd', 'weights90d_sd', 'weights150d_sd', 'weights180d_sd', 'bweights_breeders', 'wweights_breeders', 'weights45d_breeders', 'weights60d_breeders', 'weights90d_breeders', 'weights150d_breeders', 'weights180d_breeders', 'bweights_breeders_sd', 'wweights_breeders_sd', 'weights45d_breeders_sd', 'weights60d_breeders_sd', 'weights90d_breeders_sd', 'weights150d_breeders_sd', 'weights180d_breeders_sd', 'bweights_growers', 'wweights_growers', 'weights45d_growers', 'weights60d_growers', 'weights90d_growers', 'weights150d_growers', 'weights180d_growers', 'bweights_growers_sd', 'wweights_growers_sd', 'weights45d_growers_sd', 'weights60d_growers_sd', 'weights90d_growers_sd', 'weights150d_growers_sd', 'weights180d_growers_sd', 'years', 'now', 'agesweaned_all', 'agesweaned_breeders', 'agesweaned_growers'));
		}

		public function getBreederProductionReportPage(){ // function to display Breeder Production Report page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->get();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();

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
					if($sowproperty->property_id == 6){ // date weaned
						if(!is_null($sowproperty->value) && $sowproperty->value != "Not specified"){
							$date_weanedsow = $sowproperty->value;
							$weanedsowproperties = $sow->getAnimalProperties();
							foreach ($weanedsowproperties as $weanedsowproperty) {
								if($weanedsowproperty->property_id == 3){ // date farrowed
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
					if($boarproperty->property_id == 6){ // date weaned
						if(!is_null($boarproperty->value) && $boarproperty->value != "Not specified"){
							$date_weanedboar = $boarproperty->value;
							$weanedboarproperties = $boar->getAnimalProperties();
							foreach ($weanedboarproperties as $weanedboarproperty) {
								if($weanedboarproperty->property_id == 3){ // date farrowed
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
					if($breederproperty->property_id == 6){ // date weaned
						if(!is_null($breederproperty->value) && $breederproperty->value != "Not specified"){
							$date_weanedbreeder = $breederproperty->value;
							$weanedbreederproperties = $breeder->getAnimalProperties();
							foreach ($weanedbreederproperties as $weanedbreederproperty) {
								if($weanedbreederproperty->property_id == 3){ // date farrowed
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
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();


			$firstbreds = [];
			$firstbredsows = [];
			$tempfirstbredsows = [];
			$duplicates = [];
			$firstbredboars = [];
			$firstbredsowsages = [];
			$firstbredboarsages = [];
			$firstbredages = [];

			//for sows
			$tempsows = [];
			$uniquesows = [];
			foreach ($sows as $sow) {
				$sowproperties = $sow->getAnimalProperties();
				foreach ($sowproperties as $sowproperty) {
					if($sowproperty->property_id == 61){ // frequency
						if($sowproperty->value == 1){ //for sows used only once
							array_push($firstbredsows, $sow);
						}
						elseif($sowproperty->value > 1){ //other sows
							foreach ($groups as $group) {
								if($group->mother_id == $sow->id){
									array_push($tempsows, $sow);
									$uniquesows = array_unique($tempsows);
								}
							}
						}
					}
				}
			}
			//for sows used only once
			foreach ($firstbredsows as $firstbredsow) {
				foreach ($groups as $group) {
					if($group->mother_id == $firstbredsow->id){
						$groupproperties = $group->getGroupingProperties();
						foreach ($groupproperties as $groupproperty) {
							if($groupproperty->property_id == 42){ // date bred
								$date_bred = $groupproperty->value;
								$bday = $firstbredsow->getAnimalProperties()->where("property_id", 3)->first();
								if(!is_null($bday) && $bday->value != "Not specified"){
									$bday_sow = Carbon::parse($bday->value);
									$firstbredsowsage = Carbon::parse($date_bred)->diffInMonths($bday_sow);
									array_push($firstbredsowsages, $firstbredsowsage);
								}
							}
						}
					}
				}
			}
			//other sows
			foreach ($uniquesows as $uniquesow) {
				$dates_bred = [];
				foreach ($groups as $group) {
					if($group->mother_id == $uniquesow->id){
						$groupproperties = $group->getGroupingProperties();
						foreach ($groupproperties as $groupproperty) {
							if($groupproperty->property_id == 42){ // date bred
								$date_bred = $groupproperty->value;
								array_push($dates_bred, $date_bred);
							}
						}
					}
				}
				// gets the first date of breeding
				$sorted_dates = array_sort($dates_bred);
				$keys = array_keys($sorted_dates);
				$date_bredsow = $sorted_dates[$keys[0]];
				$bday = $uniquesow->getAnimalProperties()->where("property_id", 3)->first();
				if(!is_null($bday) && $bday->value != "Not specified"){
					$bday_sow = Carbon::parse($bday->value);
				}
				else{
					$bday_sow = "";
				}
				// age computation
				if($bday_sow != ""){
					$firstbredsowsage = Carbon::parse($date_bredsow)->diffInMonths($bday_sow);
					array_push($firstbredsowsages, $firstbredsowsage);
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
					if($boarproperty->property_id == 61){ // frequency
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
							if($groupproperty->property_id == 42){ // date bred
								$date_bred = $groupproperty->value;
								$bday = $firstbredboar->getAnimalProperties()->where("property_id", 3)->first();
								if(!is_null($bday) && $bday->value != "Not specified"){
									$bday_boar = Carbon::parse($bday->value);
									$firstbredboarsage = Carbon::parse($date_bred)->diffInMonths($bday_boar);
									array_push($firstbredboarsages, $firstbredboarsage);
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
							if($groupproperty->property_id == 42){ // date bred
								$date_bred = $groupproperty->value;
								array_push($dates_bred, $date_bred);
							}
						}
						// gets the first date of breeding
						$sorted_dates = array_sort($dates_bred);
						$keys = array_keys($sorted_dates);
						$date_bredboar = $sorted_dates[$keys[0]];
						$bday = $uniqueboar->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bday) && $bday->value != "Not specified"){
							$bday_boar = Carbon::parse($bday->value);
						}
						else{
							$bday_boar = "";
						}
					}
				}
				// age computation
				if($bday_boar != ""){
					$firstbredboarsage = Carbon::parse($date_bredboar)->diffInMonths($bday_boar);
					array_push($firstbredboarsages, $firstbredboarsage);
				}
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
			$now = new Carbon();
			$breederages = [];
			$herdbreeders = [];
			foreach ($breeders as $breeder) {
				$genproperties = $breeder->getAnimalProperties();
				foreach ($genproperties as $genproperty) {
					if($genproperty->property_id == 61){ // frequency
						if($genproperty->value > 0){ // used at least once
							array_push($herdbreeders, $breeder);
							$bredbreederproperties = $breeder->getAnimalProperties();
							foreach ($bredbreederproperties as $bredbreederproperty) {
								if($bredbreederproperty->property_id == 3){ // date farrowed
									if(!is_null($bredbreederproperty->value) && $bredbreederproperty->value != "Not specified"){
										$bday_breeder = $bredbreederproperty->value;
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
					if($sowproperty->property_id == 61){ // frequency
						if($sowproperty->value > 0){ // used at least once
							array_push($breedersows, $sow);
							$bredsowproperties = $sow->getAnimalProperties();
							foreach ($bredsowproperties as $bredsowproperty) {
								if($bredsowproperty->property_id == 3){ // date farrowed
									if(!is_null($bredsowproperty->value) && $bredsowproperty->value != "Not specified"){
										$bday_sow = $bredsowproperty->value;
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
					if($boarproperty->property_id == 61){ // frequency
						if($boarproperty->value > 0){ // used at least once
							array_push($breederboars, $boar);
							$bredboarproperties = $boar->getAnimalProperties();
							foreach ($bredboarproperties as $bredboarproperty) {
								if($bredboarproperty->property_id == 3){ // date farrowed
									if(!is_null($bredboarproperty->value) && $bredboarproperty->value != "Not specified"){
										$bday_boar = $bredboarproperty->value;
										$breederboarage = $now->diffInMonths(Carbon::parse($bday_boar));
										array_push($breederboarages, $breederboarage);
									}
								}
							}
						}
					}
				}
			}

			$months = ["December", "November", "October", "September", "August", "July", "June", "May", "April", "March", "February", "January"];

			// gets unique years of age at weaning
			$years_weaning = [];
			$tempyears_weaning = [];
			foreach ($breeders as $breeder) {
				$breederproperties = $breeder->getAnimalProperties();
				foreach ($breederproperties as $breederproperty) {
					if($breederproperty->property_id == 6){ //date weaned
						if(!is_null($breederproperty->value) && $breederproperty->value != "Not specified"){
							$year_weaning = Carbon::parse($breederproperty->value)->year;
							array_push($tempyears_weaning, $year_weaning);
							$years_weaning = array_reverse(array_sort(array_unique($tempyears_weaning)));
						}
					}
				}
			}

			return view('pigs.breederproduction', compact('breeders', 'sows', 'boars', 'ages_weanedsow', 'ages_weanedsow_sd', 'ages_weanedboar', 'ages_weanedboar_sd', 'ages_weanedbreeder', 'ages_weanedbreeder_sd', 'breederages', 'herdbreeders', 'breedersowages', 'breedersows', 'breederboarages', 'breederboars', 'firstbreds', 'firstbredsows', 'uniquesows', 'firstbredsowsages', 'firstbredsowsages_sd', 'duplicates', 'firstbredboars', 'uniqueboars', 'firstbredboarsages', 'firstbredboarsages_sd', 'firstbredages', 'firstbredages_sd', 'months', 'years_weaning', 'now'));
		}

		static function getAgeAtWeaning($year, $month, $filter){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();

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
						if($breederproperty->property_id == 6){ //date weaned
							if(!is_null($breederproperty->value) && $breederproperty->value != "Not specified"){
								$date = Carbon::parse($breederproperty->value);
								if($date->year == $year && $date->format('F') == $month){
									$bday = $breeder->getAnimalProperties()->where("property_id", 3)->first();
									if(!is_null($bday) && $bday->value != "Not specified"){
										$birthday = Carbon::parse($bday->value);
										$age = $date->diffInDays($birthday);
										array_push($ages, $age);
									}
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
						if($sowbreederproperty->property_id == 6){ //date weaned
							if(!is_null($sowbreederproperty->value) && $sowbreederproperty->value != "Not specified"){
								$date = Carbon::parse($sowbreederproperty->value);
								if($date->year == $year && $date->format('F') == $month){
									$weanedproperties = $sow->getAnimalProperties();
									foreach ($weanedproperties as $weanedproperty) {
										if($weanedproperty->property_id == 3){
											if(!is_null($weanedproperty->value) && $weanedproperty->value != "Not specified"){
												$bday = Carbon::parse($weanedproperty->value);
												$age = $date->diffInDays($bday);
												array_push($ages, $age);
											}
										}
									}
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
						if($boarbreederproperty->property_id == 6){ //date weaned
							if(!is_null($boarbreederproperty->value) && $boarbreederproperty->value != "Not specified"){
								$date = Carbon::parse($boarbreederproperty->value);
								if($date->year == $year && $date->format('F') == $month){
									$weanedproperties = $boar->getAnimalProperties();
									foreach ($weanedproperties as $weanedproperty) {
										if($weanedproperty->property_id == 3){
											if(!is_null($weanedproperty->value) && $weanedproperty->value != "Not specified"){
												$bday = Carbon::parse($weanedproperty->value);
												$age = $date->diffInDays($bday);
												array_push($ages, $age);
											}
										}
									}
								}
							}
						}
					}
				}

				return $ages;
			}
		}

		public function fetchProdPerformanceParity(Request $request){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();

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

			// sow breeders are sows with frequency of at least 1
			$sowbreeders = [];
			$boarbreeders = [];
			foreach ($sows as $sow) {
				$sowproperties = $sow->getAnimalProperties();
				foreach ($sowproperties as $sowproperty) {
					if($sowproperty->property_id == 61){ // frequency
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
					if($boarproperty->property_id == 61){ // frequency
						if($boarproperty->value > 0){
							array_push($boarbreeders, $boar);
						}
					}
				}
			}

			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			// gets unique parity
			$parity = [];
			$tempparity = [];
			foreach ($groups as $group) {
				$groupproperties = $group->getGroupingProperties();
				foreach ($groupproperties as $groupproperty) {
					if($groupproperty->property_id == 48){ //parity
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
					if($groupproperty->property_id == 48){ //parity
						if($groupproperty->value == $filter){
							array_push($groupswiththisparity, $group);
						}
					}
				}
			}

			$lsba = [];
			$numbermales = [];
			$numberfemales = [];
			$stillborn = [];
			$mummified = [];
			$litterbirthweights = [];
			$avebirthweights = [];
			$litterweaningweights = [];
			$aveweaningweights = [];
			$adjweaningweights = [];
			$numberweaned = [];
			$agesweaned = [];
			$preweaningmortality = [];
			foreach ($groupswiththisparity as $groupwiththisparity) {
				$lsbaprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 50)->first();
				if(!is_null($lsbaprop)){
					$lsbavalue = $lsbaprop->value;
					array_push($lsba, $lsbavalue);
				}
				$numbermalesprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 51)->first();
				if(!is_null($numbermalesprop)){
					$numbermalesvalue = $numbermalesprop->value;
					array_push($numbermales, $numbermalesvalue);
				}
				$numberfemalesprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 52)->first();
				if(!is_null($numberfemalesprop)){
					$numberfemalesvalue = $numberfemalesprop->value;
					array_push($numberfemales, $numberfemalesvalue);
				}
				$stillbornprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 45)->first();
				if(!is_null($stillbornprop)){
					$stillbornvalue = $stillbornprop->value;
					array_push($stillborn, $stillbornvalue);
				}
				$mummifiedprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 46)->first();
				if(!is_null($mummifiedprop)){
					$mummifiedvalue = $mummifiedprop->value;
					array_push($mummified, $mummifiedvalue);
				}
				$litterbwprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 55)->first();
				if(!is_null($litterbwprop)){
					$litterbwvalue = $litterbwprop->value;
					array_push($litterbirthweights, $litterbwvalue);
				}
				$avebwprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 56)->first();
				if(!is_null($avebwprop)){
					$avebwvalue = $avebwprop->value;
					array_push($avebirthweights, $avebwvalue);
				}
				if(!is_null($groupwiththisparity->getGroupingProperties()->where("property_id", 62)->first())){
					$litterwwvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 62)->first()->value;
				}
				array_push($litterweaningweights, $litterwwvalue);
				if(!is_null($groupwiththisparity->getGroupingProperties()->where("property_id", 58)->first())){
					$avewwvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 58)->first()->value;
				}
				array_push($aveweaningweights, $avewwvalue);
				if(!is_null($groupwiththisparity->getGroupingProperties()->where("property_id", 57)->first())){
					$numberweanedvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 57)->first()->value;
				}
				array_push($numberweaned, $numberweanedvalue);
				if(!is_null($groupwiththisparity->getGroupingProperties()->where("property_id", 59)->first())){
					$pwmvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 59)->first()->value;
					array_push($preweaningmortality, $pwmvalue);
				}
				$thisoffsprings = $groupwiththisparity->getGroupingMembers();
				$ageweaned = [];
				$adjweaningweight = [];
				foreach ($thisoffsprings as $thisoffspring) {
					if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first())){
						$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
						$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
							$bday = $bdayprop->value;
						}
						$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
						array_push($ageweaned, $age);
						$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
						if(!is_null($wwprop) && $wwprop->value != ""){
							$adjww = ((float)$wwprop->value*45)/$age;
							array_push($adjweaningweight, $adjww);
						}
					}
				}
				if($ageweaned != []){
					array_push($agesweaned, (array_sum($ageweaned)/count($ageweaned)));
				}
				if($adjweaningweight != []){
					array_push($adjweaningweights, (array_sum($adjweaningweight)/count($adjweaningweight)));
				}
			}

			return view('pigs.productionperformance', compact('sowbreeders', 'boarbreeders', 'parity', 'groupswiththisparity', 'filter', 'lsba', 'numbermales', 'numberfemales', 'stillborn', 'mummified', 'litterbirthweights', 'avebirthweights', 'litterweaningweights', 'aveweaningweights', 'adjweaningweights', 'numberweaned', 'agesweaned', 'preweaningmortality'));
		}

		static function getPropertyAveragePerParity($parity, $filter){
			set_time_limit(5000);
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$groupswiththisparity = [];
			foreach ($groups as $group) {
				$groupproperties = $group->getGroupingProperties();
				foreach ($groupproperties as $groupproperty) {
					if($groupproperty->property_id == 48){ //parity
						if($groupproperty->value == $parity){
							array_push($groupswiththisparity, $group);
						}
					}
				}
			}

			$lsba = [];
			$numbermales = [];
			$numberfemales = [];
			$stillborn = [];
			$mummified = [];
			$litterbirthweights = [];
			$avebirthweights = [];
			$litterweaningweights = [];
			$aveweaningweights = [];
			$adjweaningweights = [];
			$numberweaned = [];
			$agesweaned = [];
			$preweaningmortality = [];
			foreach ($groupswiththisparity as $groupwiththisparity) {
				$lsbaprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 50)->first();
				if(!is_null($lsbaprop)){
					$lsbavalue = $lsbaprop->value;
					array_push($lsba, $lsbavalue);
				}
				$numbermalesprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 51)->first();
				if(!is_null($numbermalesprop)){
					$numbermalesvalue = $numbermalesprop->value;
					array_push($numbermales, $numbermalesvalue);
				}
				$numberfemalesprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 52)->first();
				if(!is_null($numberfemalesprop)){
					$numberfemalesvalue = $numberfemalesprop->value;
					array_push($numberfemales, $numberfemalesvalue);
				}
				$stillbornprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 45)->first();
				if(!is_null($stillbornprop)){
					$stillbornvalue = $stillbornprop->value;
					array_push($stillborn, $stillbornvalue);
				}
				$mummifiedprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 46)->first();
				if(!is_null($mummifiedprop)){
					$mummifiedvalue = $mummifiedprop->value;
					array_push($mummified, $mummifiedvalue);
				}
				$litterbwprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 55)->first();
				if(!is_null($litterbwprop)){
					$litterbwvalue = $litterbwprop->value;
					array_push($litterbirthweights, $litterbwvalue);
				}
				$avebwprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 56)->first();
				if(!is_null($avebwprop)){
					$avebwvalue = $avebwprop->value;
					array_push($avebirthweights, $avebwvalue);
				}
				if(!is_null($groupwiththisparity->getGroupingProperties()->where("property_id", 62)->first())){
					$litterwwvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 62)->first()->value;
				}
				array_push($litterweaningweights, $litterwwvalue);
				if(!is_null($groupwiththisparity->getGroupingProperties()->where("property_id", 58)->first())){
					$avewwvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 58)->first()->value;
				}
				array_push($aveweaningweights, $avewwvalue);
				if(!is_null($groupwiththisparity->getGroupingProperties()->where("property_id", 57)->first())){
					$numberweanedvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 57)->first()->value;
				}
				array_push($numberweaned, $numberweanedvalue);
				if(!is_null($groupwiththisparity->getGroupingProperties()->where("property_id", 59)->first())){
					$pwmvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 59)->first()->value;
					array_push($preweaningmortality, $pwmvalue);
				}
				$thisoffsprings = $groupwiththisparity->getGroupingMembers();
				$ageweaned = [];
				$adjweaningweight = [];
				foreach ($thisoffsprings as $thisoffspring) {
					if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
						$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
						$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
							$bday = $bdayprop->value;
						}
						$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
						array_push($ageweaned, $age);
						$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
						if(!is_null($wwprop) && $wwprop->value != ""){
							$adjww = ((float)$wwprop->value*45)/$age;
							array_push($adjweaningweight, $adjww);
						}
					}
				}
				if($ageweaned != []){
					array_push($agesweaned, (array_sum($ageweaned)/count($ageweaned)));
				}
				if($adjweaningweight != []){
					array_push($adjweaningweights, (array_sum($adjweaningweight)/count($adjweaningweight)));
				}
			}

			if($filter == "lsba"){
				return round(array_sum($lsba)/count($lsba), 2);
			}
			elseif($filter == "number of males"){
				return round(array_sum($numbermales)/count($numbermales), 2);
			}
			elseif($filter == "number of females"){
				return round(array_sum($numberfemales)/count($numberfemales), 2);
			}
			elseif($filter == "stillborn"){
				return round(array_sum($stillborn)/count($stillborn), 2);
			}
			elseif($filter == "mummified"){
				return round(array_sum($mummified)/count($mummified), 2);
			}
			elseif($filter == "birth weight"){
				return round(array_sum($litterbirthweights)/count($litterbirthweights), 2);
			}
			elseif($filter == "ave birth weight"){
				return round(array_sum($avebirthweights)/count($avebirthweights), 2);
			}
			elseif($filter == "weaning weight"){
				if($litterweaningweights == []){
					return null;
				}
				else{
					return round(array_sum($litterweaningweights)/count($litterweaningweights), 2);
				}
			}
			elseif($filter == "ave weaning weight"){
				if($aveweaningweights == []){
					return null;
				}
				else{
					return round(array_sum($aveweaningweights)/count($aveweaningweights), 2);
				}
			}
			elseif($filter == "adj weaning weight"){
				if($adjweaningweights == []){
					return null;
				}
				else{
					return round(array_sum($adjweaningweights)/count($adjweaningweights), 2);
				}
			}
			elseif($filter == "number weaned"){
				if($numberweaned == []){
					return null;
				}
				else{
					return round(array_sum($numberweaned)/count($numberweaned), 2);
				}
			}
			elseif($filter == "age weaned"){
				if($agesweaned == []){
					return null;
				}
				else{
					return round(array_sum($agesweaned)/count($agesweaned), 2);
				}
			}
			elseif($filter == "preweaning mortality"){
				if($preweaningmortality == []){
					return null;
				}
				else{
					return round(array_sum($preweaningmortality)/count($preweaningmortality), 2);
				}
			}

		}

		static function getProductionPerformanceSummary($sex, $parameter){
			set_time_limit(5000);
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();

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

			if($sex == "sow"){
				$lsba = [];
				$numbermales = [];
				$numberfemales = [];
				$stillborn = [];
				$mummified = [];
				$litterbirthweights = [];
				$avebirthweights = [];
				$litterweaningweights = [];
				$aveweaningweights = [];
				$adjweaningweights = [];
				$numberweaned = [];
				$agesweaned = [];
				$preweaningmortality = [];
				foreach ($groups as $group) {
					foreach ($sows as $sow) {
						if($group->mother_id == $sow->id){
							$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
							if(!is_null($lsbaprop)){
								$lsbavalue = $lsbaprop->value;
								array_push($lsba, $lsbavalue);
							}
							$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
							if(!is_null($numbermalesprop)){
								$numbermalesvalue = $numbermalesprop->value;
								array_push($numbermales, $numbermalesvalue);
							}
							$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
							if(!is_null($numberfemalesprop)){
								$numberfemalesvalue = $numberfemalesprop->value;
								array_push($numberfemales, $numberfemalesvalue);
							}
							$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
							if(!is_null($stillbornprop)){
								$stillbornvalue = $stillbornprop->value;
								array_push($stillborn, $stillbornvalue);
							}
							$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
							if(!is_null($mummifiedprop)){
								$mummifiedvalue = $mummifiedprop->value;
								array_push($mummified, $mummifiedvalue);
							}
							$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
							if(!is_null($litterbwprop)){
								$litterbwvalue = $litterbwprop->value;
								array_push($litterbirthweights, $litterbwvalue);
							}
							$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
							if(!is_null($avebwprop)){
								$avebwvalue = $avebwprop->value;
								array_push($avebirthweights, $avebwvalue);
							}
							if(!is_null($group->getGroupingProperties()->where("property_id", 62)->first())){
								$litterwwvalue = $group->getGroupingProperties()->where("property_id", 62)->first()->value;
								array_push($litterweaningweights, $litterwwvalue);
							}
							if(!is_null($group->getGroupingProperties()->where("property_id", 58)->first())){
								$avewwvalue = $group->getGroupingProperties()->where("property_id", 58)->first()->value;
								array_push($aveweaningweights, $avewwvalue);
							}
							if(!is_null($group->getGroupingProperties()->where("property_id", 57)->first())){
								$numberweanedvalue = $group->getGroupingProperties()->where("property_id", 57)->first()->value;
								array_push($numberweaned, $numberweanedvalue);
							}
							if(!is_null($group->getGroupingProperties()->where("property_id", 59)->first())){
								$pwmvalue = $group->getGroupingProperties()->where("property_id", 59)->first()->value;
								array_push($preweaningmortality, $pwmvalue);
							}
							$thisoffsprings = $group->getGroupingMembers();
							$ageweaned = [];
							$adjweaningweight = [];
							foreach ($thisoffsprings as $thisoffspring) {
								if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
									$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
									$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
									if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
										$bday = $bdayprop->value;
									}
									$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
									array_push($ageweaned, $age);
									$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
									if(!is_null($wwprop) && $wwprop->value != ""){
										$adjww = ((float)$wwprop->value*45)/$age;
										array_push($adjweaningweight, $adjww);
									}
								}
							}
							if($ageweaned != []){
								array_push($agesweaned, (array_sum($ageweaned)/count($ageweaned)));
							}
							if($adjweaningweight != []){
								array_push($adjweaningweights, (array_sum($adjweaningweight)/count($adjweaningweight)));
							}
						}
					}
				}
				if($parameter == "lsba"){
					if($lsba != []){
						return $lsba;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "number males"){
					if($numbermales != []){
						return $numbermales;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "number females"){
					if($numberfemales != []){
						return $numberfemales;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "stillborn"){
					if($stillborn != []){
						return $stillborn;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "mummified"){
					if($mummified != []){
						return $mummified;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "litter bw"){
					if($litterbirthweights != []){
						return $litterbirthweights;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "ave bw"){
					if($avebirthweights != []){
						return $avebirthweights;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "litter ww"){
					if($litterweaningweights != []){
						return $litterweaningweights;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "ave ww"){
					if($aveweaningweights != []){
						return $aveweaningweights;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "adj ww"){
					if($adjweaningweights != []){
						return $adjweaningweights;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "number weaned"){
					if($numberweaned != []){
						return $numberweaned;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "age weaned"){
					if($agesweaned != []){
						return $agesweaned;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "preweaning mortality"){
					if($preweaningmortality != []){
						return $preweaningmortality;
					}
					else{
						return "";
					}
				}
			}
			elseif($sex == "boar"){
				$lsba = [];
				$numbermales = [];
				$numberfemales = [];
				$stillborn = [];
				$mummified = [];
				$litterbirthweights = [];
				$avebirthweights = [];
				$litterweaningweights = [];
				$aveweaningweights = [];
				$adjweaningweights = [];
				$numberweaned = [];
				$agesweaned = [];
				$preweaningmortality = [];
				foreach ($groups as $group) {
					foreach ($boars as $boar) {
						if($group->father_id == $boar->id){
							$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
							if(!is_null($lsbaprop)){
								$lsbavalue = $lsbaprop->value;
								array_push($lsba, $lsbavalue);
							}
							$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
							if(!is_null($numbermalesprop)){
								$numbermalesvalue = $numbermalesprop->value;
								array_push($numbermales, $numbermalesvalue);
							}
							$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
							if(!is_null($numberfemalesprop)){
								$numberfemalesvalue = $numberfemalesprop->value;
								array_push($numberfemales, $numberfemalesvalue);
							}
							$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
							if(!is_null($stillbornprop)){
								$stillbornvalue = $stillbornprop->value;
								array_push($stillborn, $stillbornvalue);
							}
							$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
							if(!is_null($mummifiedprop)){
								$mummifiedvalue = $mummifiedprop->value;
								array_push($mummified, $mummifiedvalue);
							}
							$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
							if(!is_null($litterbwprop)){
								$litterbwvalue = $litterbwprop->value;
								array_push($litterbirthweights, $litterbwvalue);
							}
							$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
							if(!is_null($avebwprop)){
								$avebwvalue = $avebwprop->value;
								array_push($avebirthweights, $avebwvalue);
							}
							if(!is_null($group->getGroupingProperties()->where("property_id", 62)->first())){
								$litterwwvalue = $group->getGroupingProperties()->where("property_id", 62)->first()->value;
								array_push($litterweaningweights, $litterwwvalue);
							}
							if(!is_null($group->getGroupingProperties()->where("property_id", 58)->first())){
								$avewwvalue = $group->getGroupingProperties()->where("property_id", 58)->first()->value;
								array_push($aveweaningweights, $avewwvalue);
							}
							if(!is_null($group->getGroupingProperties()->where("property_id", 57)->first())){
								$numberweanedvalue = $group->getGroupingProperties()->where("property_id", 57)->first()->value;
								array_push($numberweaned, $numberweanedvalue);
							}
							if(!is_null($group->getGroupingProperties()->where("property_id", 59)->first())){
								$pwmvalue = $group->getGroupingProperties()->where("property_id", 59)->first()->value;
								array_push($preweaningmortality, $pwmvalue);
							}
							$thisoffsprings = $group->getGroupingMembers();
							$ageweaned = [];
							$adjweaningweight = [];
							foreach ($thisoffsprings as $thisoffspring) {
								if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
									$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
									$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
									if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
										$bday = $bdayprop->value;
									}
									$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
									array_push($ageweaned, $age);
									$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
									if(!is_null($wwprop) && $wwprop->value != ""){
										$adjww = ((float)$wwprop->value*45)/$age;
										array_push($adjweaningweight, $adjww);
									}
								}
							}
							if($ageweaned != []){
								array_push($agesweaned, (array_sum($ageweaned)/count($ageweaned)));
							}
							if($adjweaningweight != []){
								array_push($adjweaningweights, (array_sum($adjweaningweight)/count($adjweaningweight)));
							}
						}
					}
				}
				if($parameter == "lsba"){
					if($lsba != []){
						return $lsba;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "number males"){
					if($numbermales != []){
						return $numbermales;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "number females"){
					if($numberfemales != []){
						return $numberfemales;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "stillborn"){
					if($stillborn != []){
						return $stillborn;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "mummified"){
					if($mummified != []){
						return $mummified;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "litter bw"){
					if($litterbirthweights != []){
						return $litterbirthweights;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "ave bw"){
					if($avebirthweights != []){
						return $avebirthweights;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "litter ww"){
					if($litterweaningweights != []){
						return $litterweaningweights;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "ave ww"){
					if($aveweaningweights != []){
						return $aveweaningweights;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "adj ww"){
					if($adjweaningweights != []){
						return $adjweaningweights;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "number weaned"){
					if($numberweaned != []){
						return $numberweaned;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "age weaned"){
					if($agesweaned != []){
						return $agesweaned;
					}
					else{
						return "";
					}
				}
				elseif($parameter == "preweaning mortality"){
					if($preweaningmortality != []){
						return $preweaningmortality;
					}
					else{
						return "";
					}
				}
			}
		}

		public function productionPerfSummaryDownloadPDF(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();

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

			// sow breeders are sows with frequency of at least 1
			$sowbreeders = [];
			$boarbreeders = [];
			foreach ($sows as $sow) {
				$sowproperties = $sow->getAnimalProperties();
				foreach ($sowproperties as $sowproperty) {
					if($sowproperty->property_id == 61){ // frequency
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
					if($boarproperty->property_id == 61){ // frequency
						if($boarproperty->value > 0){
							array_push($boarbreeders, $boar);
						}
					}
				}
			}

			//gets all groups
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$lsba_sow = [];
			$numbermales_sow = [];
			$numberfemales_sow = [];
			$stillborn_sow = [];
			$mummified_sow = [];
			$litterbirthweights_sow = [];
			$avebirthweights_sow = [];
			$litterweaningweights_sow = [];
			$aveweaningweights_sow = [];
			$adjweaningweights_sow = [];
			$numberweaned_sow = [];
			$agesweaned_sow = [];
			$preweaningmortality_sow = [];
			foreach ($groups as $group) {
				foreach ($sowbreeders as $sow) {
					if($group->mother_id == $sow->id){
						$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
						if(!is_null($lsbaprop)){
							$lsbavalue = $lsbaprop->value;
							array_push($lsba_sow, $lsbavalue);
						}
						$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
						if(!is_null($numbermalesprop)){
							$numbermalesvalue = $numbermalesprop->value;
							array_push($numbermales_sow, $numbermalesvalue);
						}
						$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
						if(!is_null($numberfemalesprop)){
							$numberfemalesvalue = $numberfemalesprop->value;
							array_push($numberfemales_sow, $numberfemalesvalue);
						}
						$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
						if(!is_null($stillbornprop)){
							$stillbornvalue = $stillbornprop->value;
							array_push($stillborn_sow, $stillbornvalue);
						}
						$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
						if(!is_null($mummifiedprop)){
							$mummifiedvalue = $mummifiedprop->value;
							array_push($mummified_sow, $mummifiedvalue);
						}
						$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
						if(!is_null($litterbwprop)){
							$litterbwvalue = $litterbwprop->value;
							array_push($litterbirthweights_sow, $litterbwvalue);
						}
						$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
						if(!is_null($avebwprop)){
							$avebwvalue = $avebwprop->value;
							array_push($avebirthweights_sow, $avebwvalue);
						}
						if(!is_null($group->getGroupingProperties()->where("property_id", 62)->first())){
							$litterwwvalue = $group->getGroupingProperties()->where("property_id", 62)->first()->value;
						}
						array_push($litterweaningweights_sow, $litterwwvalue);
						if(!is_null($group->getGroupingProperties()->where("property_id", 58)->first())){
							$avewwvalue = $group->getGroupingProperties()->where("property_id", 58)->first()->value;
						}
						array_push($aveweaningweights_sow, $avewwvalue);
						if(!is_null($group->getGroupingProperties()->where("property_id", 57)->first())){
							$numberweanedvalue = $group->getGroupingProperties()->where("property_id", 57)->first()->value;
						}
						array_push($numberweaned_sow, $numberweanedvalue);
						if(!is_null($group->getGroupingProperties()->where("property_id", 59)->first())){
							$pwmvalue = $group->getGroupingProperties()->where("property_id", 59)->first()->value;
							array_push($preweaningmortality_sow, $pwmvalue);
						}
						$thisoffsprings = $group->getGroupingMembers();
						$ageweaned_sow = [];
						$adjweaningweight_sow = [];
						foreach ($thisoffsprings as $thisoffspring) {
							if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
								$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
								$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
								if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
									$bday = $bdayprop->value;
								}
								$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
								array_push($ageweaned_sow, $age);
								$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
								if(!is_null($wwprop) && $wwprop->value != ""){
									$adjww = ((float)$wwprop->value*45)/$age;
									array_push($adjweaningweight_sow, $adjww);
								}
							}
						}
						if($ageweaned_sow != []){
							array_push($agesweaned_sow, (array_sum($ageweaned_sow)/count($ageweaned_sow)));
						}
						if($adjweaningweight_sow != []){
							array_push($adjweaningweights_sow, (array_sum($adjweaningweight_sow)/count($adjweaningweight_sow)));
						}
					}
				}
			}

			if($lsba_sow != []){
				$lsba_sow_sd = static::standardDeviation($lsba_sow, false);
			}
			if($numbermales_sow != []){
				$numbermales_sow_sd = static::standardDeviation($numbermales_sow, false);
			}
			if($numberfemales_sow != []){
				$numberfemales_sow_sd = static::standardDeviation($numberfemales_sow, false);
			}
			if($stillborn_sow != []){
				$stillborn_sow_sd = static::standardDeviation($stillborn_sow, false);
			}
			if($mummified_sow != []){
				$mummified_sow_sd = static::standardDeviation($mummified_sow, false);
			}
			if($litterbirthweights_sow != []){
				$litterbirthweights_sow_sd = static::standardDeviation($litterbirthweights_sow, false);
			}
			if($avebirthweights_sow != []){
				$avebirthweights_sow_sd = static::standardDeviation($avebirthweights_sow, false);
			}
			if($litterweaningweights_sow != []){
				$litterweaningweights_sow_sd = static::standardDeviation($litterweaningweights_sow, false);
			}
			if($aveweaningweights_sow != []){
				$aveweaningweights_sow_sd = static::standardDeviation($aveweaningweights_sow, false);
			}
			if($adjweaningweights_sow != []){
				$adjweaningweights_sow_sd = static::standardDeviation($adjweaningweights_sow, false);
			}
			if($numberweaned_sow != []){
				$numberweaned_sow_sd = static::standardDeviation($numberweaned_sow, false);
			}
			if($agesweaned_sow != []){
				$agesweaned_sow_sd = static::standardDeviation($agesweaned_sow, false);
			}
			if($preweaningmortality_sow != []){
				$preweaningmortality_sow_sd = static::standardDeviation($preweaningmortality_sow, false);
			}
		
			$lsba_boar = [];
			$numbermales_boar = [];
			$numberfemales_boar = [];
			$stillborn_boar = [];
			$mummified_boar = [];
			$litterbirthweights_boar = [];
			$avebirthweights_boar = [];
			$litterweaningweights_boar = [];
			$aveweaningweights_boar = [];
			$adjweaningweights_boar = [];
			$numberweaned_boar = [];
			$agesweaned_boar = [];
			$preweaningmortality_boar = [];
			foreach ($groups as $group) {
				foreach ($boarbreeders as $boar) {
					if($group->father_id == $boar->id){
						$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
						if(!is_null($lsbaprop)){
							$lsbavalue = $lsbaprop->value;
							array_push($lsba_boar, $lsbavalue);
						}
						$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
						if(!is_null($numbermalesprop)){
							$numbermalesvalue = $numbermalesprop->value;
							array_push($numbermales_boar, $numbermalesvalue);
						}
						$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
						if(!is_null($numberfemalesprop)){
							$numberfemalesvalue = $numberfemalesprop->value;
							array_push($numberfemales_boar, $numberfemalesvalue);
						}
						$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
						if(!is_null($stillbornprop)){
							$stillbornvalue = $stillbornprop->value;
							array_push($stillborn_boar, $stillbornvalue);
						}
						$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
						if(!is_null($mummifiedprop)){
							$mummifiedvalue = $mummifiedprop->value;
							array_push($mummified_boar, $mummifiedvalue);
						}
						$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
						if(!is_null($litterbwprop)){
							$litterbwvalue = $litterbwprop->value;
							array_push($litterbirthweights_boar, $litterbwvalue);
						}
						$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
						if(!is_null($avebwprop)){
							$avebwvalue = $avebwprop->value;
							array_push($avebirthweights_boar, $avebwvalue);
						}
						if(!is_null($group->getGroupingProperties()->where("property_id", 62)->first())){
							$litterwwvalue = $group->getGroupingProperties()->where("property_id", 62)->first()->value;
						}
						array_push($litterweaningweights_boar, $litterwwvalue);
						if(!is_null($group->getGroupingProperties()->where("property_id", 58)->first())){
							$avewwvalue = $group->getGroupingProperties()->where("property_id", 58)->first()->value;
						}
						array_push($aveweaningweights_boar, $avewwvalue);
						if(!is_null($group->getGroupingProperties()->where("property_id", 57)->first())){
							$numberweanedvalue = $group->getGroupingProperties()->where("property_id", 57)->first()->value;
						}
						array_push($numberweaned_boar, $numberweanedvalue);
						if(!is_null($group->getGroupingProperties()->where("property_id", 59)->first())){
							$pwmvalue = $group->getGroupingProperties()->where("property_id", 59)->first()->value;
							array_push($preweaningmortality_boar, $pwmvalue);
						}
						$thisoffsprings = $group->getGroupingMembers();
						$ageweaned_boar = [];
						$adjweaningweight_boar = [];
						foreach ($thisoffsprings as $thisoffspring) {
							if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
								$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
								$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
								if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
									$bday = $bdayprop->value;
								}
								$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
								array_push($ageweaned_boar, $age);
								$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
								if(!is_null($wwprop) && $wwprop->value != ""){
									$adjww = ((float)$wwprop->value*45)/$age;
									array_push($adjweaningweight_boar, $adjww);
								}
							}
						}
						if($ageweaned_boar != []){
							array_push($agesweaned_boar, (array_sum($ageweaned_boar)/count($ageweaned_boar)));
						}
						if($adjweaningweight_boar != []){
							array_push($adjweaningweights_boar, (array_sum($adjweaningweight_boar)/count($adjweaningweight_boar)));
						}
					}
				}
			}

			if($lsba_boar != []){
				$lsba_boar_sd = static::standardDeviation($lsba_boar, false);
			}
			if($numbermales_boar != []){
				$numbermales_boar_sd = static::standardDeviation($numbermales_boar, false);
			}
			if($numberfemales_boar != []){
				$numberfemales_boar_sd = static::standardDeviation($numberfemales_boar, false);
			}
			if($stillborn_boar != []){
				$stillborn_boar_sd = static::standardDeviation($stillborn_boar, false);
			}
			if($mummified_boar != []){
				$mummified_boar_sd = static::standardDeviation($mummified_boar, false);
			}
			if($litterbirthweights_boar != []){
				$litterbirthweights_boar_sd = static::standardDeviation($litterbirthweights_boar, false);
			}
			if($avebirthweights_boar != []){
				$avebirthweights_boar_sd = static::standardDeviation($avebirthweights_boar, false);
			}
			if($litterweaningweights_boar != []){
				$litterweaningweights_boar_sd = static::standardDeviation($litterweaningweights_boar, false);
			}
			if($aveweaningweights_boar != []){
				$aveweaningweights_boar_sd = static::standardDeviation($aveweaningweights_boar, false);
			}
			if($adjweaningweights_boar != []){
				$adjweaningweights_boar_sd = static::standardDeviation($adjweaningweights_boar, false);
			}
			if($numberweaned_boar != []){
				$numberweaned_boar_sd = static::standardDeviation($numberweaned_boar, false);
			}
			if($agesweaned_boar != []){
				$agesweaned_boar_sd = static::standardDeviation($agesweaned_boar, false);
			}
			if($preweaningmortality_boar != []){
				$preweaningmortality_boar_sd = static::standardDeviation($preweaningmortality_boar, false);
			}

			$now = Carbon::now('Asia/Manila');



			$pdf = PDF::loadView('pigs.productionperfpdf', compact('lsba_sow', 'numbermales_sow', 'numberfemales_sow', 'stillborn_sow', 'mummified_sow', 'litterbirthweights_sow', 'avebirthweights_sow', 'litterweaningweights_sow', 'aveweaningweights_sow', 'adjweaningweights_sow', 'numberweaned_sow', 'agesweaned_sow', 'preweaningmortality_sow', 'lsba_sow_sd', 'numbermales_sow_sd', 'numberfemales_sow_sd', 'stillborn_sow_sd', 'mummified_sow_sd', 'litterbirthweights_sow_sd', 'avebirthweights_sow_sd', 'litterweaningweights_sow_sd', 'aveweaningweights_sow_sd', 'adjweaningweights_sow_sd', 'numberweaned_sow_sd', 'agesweaned_sow_sd', 'preweaningmortality_sow_sd', 'lsba_boar', 'numbermales_boar', 'numberfemales_boar', 'stillborn_boar', 'mummified_boar', 'litterbirthweights_boar', 'avebirthweights_boar', 'litterweaningweights_boar', 'aveweaningweights_boar', 'adjweaningweights_boar', 'numberweaned_boar', 'agesweaned_boar', 'preweaningmortality_boar', 'lsba_boar_sd', 'numbermales_boar_sd', 'numberfemales_boar_sd', 'stillborn_boar_sd', 'mummified_boar_sd', 'litterbirthweights_boar_sd', 'avebirthweights_boar_sd', 'litterweaningweights_boar_sd', 'aveweaningweights_boar_sd', 'adjweaningweights_boar_sd', 'numberweaned_boar_sd', 'agesweaned_boar_sd', 'preweaningmortality_boar_sd', 'now'));

			return $pdf->download('productionperf_'.$now.'.pdf');
		}

		public function productionPerfSummaryDownloadCSV(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();

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

			// sow breeders are sows with frequency of at least 1
			$sowbreeders = [];
			$boarbreeders = [];
			foreach ($sows as $sow) {
				$sowproperties = $sow->getAnimalProperties();
				foreach ($sowproperties as $sowproperty) {
					if($sowproperty->property_id == 61){ // frequency
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
					if($boarproperty->property_id == 61){ // frequency
						if($boarproperty->value > 0){
							array_push($boarbreeders, $boar);
						}
					}
				}
			}

			//gets all groups
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$lsba_sow = [];
			$numbermales_sow = [];
			$numberfemales_sow = [];
			$stillborn_sow = [];
			$mummified_sow = [];
			$litterbirthweights_sow = [];
			$avebirthweights_sow = [];
			$litterweaningweights_sow = [];
			$aveweaningweights_sow = [];
			$adjweaningweights_sow = [];
			$numberweaned_sow = [];
			$agesweaned_sow = [];
			$preweaningmortality_sow = [];
			foreach ($groups as $group) {
				foreach ($sowbreeders as $sow) {
					if($group->mother_id == $sow->id){
						$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
						if(!is_null($lsbaprop)){
							$lsbavalue = $lsbaprop->value;
							array_push($lsba_sow, $lsbavalue);
						}
						$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
						if(!is_null($numbermalesprop)){
							$numbermalesvalue = $numbermalesprop->value;
							array_push($numbermales_sow, $numbermalesvalue);
						}
						$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
						if(!is_null($numberfemalesprop)){
							$numberfemalesvalue = $numberfemalesprop->value;
							array_push($numberfemales_sow, $numberfemalesvalue);
						}
						$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
						if(!is_null($stillbornprop)){
							$stillbornvalue = $stillbornprop->value;
							array_push($stillborn_sow, $stillbornvalue);
						}
						$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
						if(!is_null($mummifiedprop)){
							$mummifiedvalue = $mummifiedprop->value;
							array_push($mummified_sow, $mummifiedvalue);
						}
						$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
						if(!is_null($litterbwprop)){
							$litterbwvalue = $litterbwprop->value;
							array_push($litterbirthweights_sow, $litterbwvalue);
						}
						$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
						if(!is_null($avebwprop)){
							$avebwvalue = $avebwprop->value;
							array_push($avebirthweights_sow, $avebwvalue);
						}
						if(!is_null($group->getGroupingProperties()->where("property_id", 62)->first())){
							$litterwwvalue = $group->getGroupingProperties()->where("property_id", 62)->first()->value;
						}
						array_push($litterweaningweights_sow, $litterwwvalue);
						if(!is_null($group->getGroupingProperties()->where("property_id", 58)->first())){
							$avewwvalue = $group->getGroupingProperties()->where("property_id", 58)->first()->value;
						}
						array_push($aveweaningweights_sow, $avewwvalue);
						if(!is_null($group->getGroupingProperties()->where("property_id", 57)->first())){
							$numberweanedvalue = $group->getGroupingProperties()->where("property_id", 57)->first()->value;
						}
						array_push($numberweaned_sow, $numberweanedvalue);
						if(!is_null($group->getGroupingProperties()->where("property_id", 59)->first())){
							$pwmvalue = $group->getGroupingProperties()->where("property_id", 59)->first()->value;
							array_push($preweaningmortality_sow, $pwmvalue);
						}
						$thisoffsprings = $group->getGroupingMembers();
						$ageweaned_sow = [];
						$adjweaningweight_sow = [];
						foreach ($thisoffsprings as $thisoffspring) {
							if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
								$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
								$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
								if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
									$bday = $bdayprop->value;
								}
								$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
								array_push($ageweaned_sow, $age);
								$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
								if(!is_null($wwprop) && $wwprop->value != ""){
									$adjww = ((float)$wwprop->value*45)/$age;
									array_push($adjweaningweight_sow, $adjww);
								}
							}
						}
						if($ageweaned_sow != []){
							array_push($agesweaned_sow, (array_sum($ageweaned_sow)/count($ageweaned_sow)));
						}
						if($adjweaningweight_sow != []){
							array_push($adjweaningweights_sow, (array_sum($adjweaningweight_sow)/count($adjweaningweight_sow)));
						}
					}
				}
			}

			if($lsba_sow != []){
				$lsba_sow_sd = static::standardDeviation($lsba_sow, false);
			}
			else{
				$lsba_sow_sd = 0;
			}
			if($numbermales_sow != []){
				$numbermales_sow_sd = static::standardDeviation($numbermales_sow, false);
			}
			else{
				$numbermales_sow_sd = 0;
			}
			if($numberfemales_sow != []){
				$numberfemales_sow_sd = static::standardDeviation($numberfemales_sow, false);
			}
			else{
				$numberfemales_sow_sd = 0;
			}
			if($stillborn_sow != []){
				$stillborn_sow_sd = static::standardDeviation($stillborn_sow, false);
			}
			else{
				$stillborn_sow_sd = 0;
			}
			if($mummified_sow != []){
				$mummified_sow_sd = static::standardDeviation($mummified_sow, false);
			}
			else{
				$mummified_sow_sd = 0;
			}
			if($litterbirthweights_sow != []){
				$litterbirthweights_sow_sd = static::standardDeviation($litterbirthweights_sow, false);
			}
			else{
				$litterbirthweights_sow_sd = 0;
			}
			if($avebirthweights_sow != []){
				$avebirthweights_sow_sd = static::standardDeviation($avebirthweights_sow, false);
			}
			else{
				$avebirthweights_sow_sd = 0;
			}
			if($litterweaningweights_sow != []){
				$litterweaningweights_sow_sd = static::standardDeviation($litterweaningweights_sow, false);
			}
			else{
				$litterweaningweights_sow_sd = 0;
			}
			if($aveweaningweights_sow != []){
				$aveweaningweights_sow_sd = static::standardDeviation($aveweaningweights_sow, false);
			}
			else{
				$aveweaningweights_sow_sd = 0;
			}
			if($adjweaningweights_sow != []){
				$adjweaningweights_sow_sd = static::standardDeviation($adjweaningweights_sow, false);
			}
			else{
				$adjweaningweights_sow_sd = 0;
			}
			if($numberweaned_sow != []){
				$numberweaned_sow_sd = static::standardDeviation($numberweaned_sow, false);
			}
			else{
				$numberweaned_sow_sd = 0;
			}
			if($agesweaned_sow != []){
				$agesweaned_sow_sd = static::standardDeviation($agesweaned_sow, false);
			}
			else{
				$agesweaned_sow_sd = 0;
			}
			if($preweaningmortality_sow != []){
				$preweaningmortality_sow_sd = static::standardDeviation($preweaningmortality_sow, false);
			}
			else{
				$preweaningmortality_sow_sd = 0;
			}
		
			$lsba_boar = [];
			$numbermales_boar = [];
			$numberfemales_boar = [];
			$stillborn_boar = [];
			$mummified_boar = [];
			$litterbirthweights_boar = [];
			$avebirthweights_boar = [];
			$litterweaningweights_boar = [];
			$aveweaningweights_boar = [];
			$adjweaningweights_boar = [];
			$numberweaned_boar = [];
			$agesweaned_boar = [];
			$preweaningmortality_boar = [];
			foreach ($groups as $group) {
				foreach ($boarbreeders as $boar) {
					if($group->father_id == $boar->id){
						$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
						if(!is_null($lsbaprop)){
							$lsbavalue = $lsbaprop->value;
							array_push($lsba_boar, $lsbavalue);
						}
						$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
						if(!is_null($numbermalesprop)){
							$numbermalesvalue = $numbermalesprop->value;
							array_push($numbermales_boar, $numbermalesvalue);
						}
						$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
						if(!is_null($numberfemalesprop)){
							$numberfemalesvalue = $numberfemalesprop->value;
							array_push($numberfemales_boar, $numberfemalesvalue);
						}
						$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
						if(!is_null($stillbornprop)){
							$stillbornvalue = $stillbornprop->value;
							array_push($stillborn_boar, $stillbornvalue);
						}
						$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
						if(!is_null($mummifiedprop)){
							$mummifiedvalue = $mummifiedprop->value;
							array_push($mummified_boar, $mummifiedvalue);
						}
						$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
						if(!is_null($litterbwprop)){
							$litterbwvalue = $litterbwprop->value;
							array_push($litterbirthweights_boar, $litterbwvalue);
						}
						$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
						if(!is_null($avebwprop)){
							$avebwvalue = $avebwprop->value;
							array_push($avebirthweights_boar, $avebwvalue);
						}
						if(!is_null($group->getGroupingProperties()->where("property_id", 62)->first())){
							$litterwwvalue = $group->getGroupingProperties()->where("property_id", 62)->first()->value;
						}
						array_push($litterweaningweights_boar, $litterwwvalue);
						if(!is_null($group->getGroupingProperties()->where("property_id", 58)->first())){
							$avewwvalue = $group->getGroupingProperties()->where("property_id", 58)->first()->value;
						}
						array_push($aveweaningweights_boar, $avewwvalue);
						if(!is_null($group->getGroupingProperties()->where("property_id", 57)->first())){
							$numberweanedvalue = $group->getGroupingProperties()->where("property_id", 57)->first()->value;
						}
						array_push($numberweaned_boar, $numberweanedvalue);
						if(!is_null($group->getGroupingProperties()->where("property_id", 59)->first())){
							$pwmvalue = $group->getGroupingProperties()->where("property_id", 59)->first()->value;
							array_push($preweaningmortality_boar, $pwmvalue);
						}
						$thisoffsprings = $group->getGroupingMembers();
						$ageweaned_boar = [];
						$adjweaningweight_boar = [];
						foreach ($thisoffsprings as $thisoffspring) {
							if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
								$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
								$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
								if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
									$bday = $bdayprop->value;
								}
								$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
								array_push($ageweaned_boar, $age);
								$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
								if(!is_null($wwprop) && $wwprop->value != ""){
									$adjww = ((float)$wwprop->value*45)/$age;
									array_push($adjweaningweight_boar, $adjww);
								}
							}
						}
						if($ageweaned_boar != []){
							array_push($agesweaned_boar, (array_sum($ageweaned_boar)/count($ageweaned_boar)));
						}
						if($adjweaningweight_boar != []){
							array_push($adjweaningweights_boar, (array_sum($adjweaningweight_boar)/count($adjweaningweight_boar)));
						}
					}
				}
			}

			if($lsba_boar != []){
				$lsba_boar_sd = static::standardDeviation($lsba_boar, false);
			}
			else{
				$lsba_boar_sd = 0;
			}
			if($numbermales_boar != []){
				$numbermales_boar_sd = static::standardDeviation($numbermales_boar, false);
			}
			else{
				$numbermales_boar_sd = 0;
			}
			if($numberfemales_boar != []){
				$numberfemales_boar_sd = static::standardDeviation($numberfemales_boar, false);
			}
			else{
				$numberfemales_boar_sd = 0;
			}
			if($stillborn_boar != []){
				$stillborn_boar_sd = static::standardDeviation($stillborn_boar, false);
			}
			else{
				$stillborn_boar_sd = 0;
			}
			if($mummified_boar != []){
				$mummified_boar_sd = static::standardDeviation($mummified_boar, false);
			}
			else{
				$mummified_boar_sd = 0;
			}
			if($litterbirthweights_boar != []){
				$litterbirthweights_boar_sd = static::standardDeviation($litterbirthweights_boar, false);
			}
			else{
				$litterbirthweights_boar_sd = 0;
			}
			if($avebirthweights_boar != []){
				$avebirthweights_boar_sd = static::standardDeviation($avebirthweights_boar, false);
			}
			else{
				$avebirthweights_boar_sd = 0;
			}
			if($litterweaningweights_boar != []){
				$litterweaningweights_boar_sd = static::standardDeviation($litterweaningweights_boar, false);
			}
			else{
				$litterweaningweights_boar_sd = 0;
			}
			if($aveweaningweights_boar != []){
				$aveweaningweights_boar_sd = static::standardDeviation($aveweaningweights_boar, false);
			}
			else{
				$aveweaningweights_boar_sd = 0;
			}
			if($adjweaningweights_boar != []){
				$adjweaningweights_boar_sd = static::standardDeviation($adjweaningweights_boar, false);
			}
			else{
				$adjweaningweights_boar_sd = 0;
			}
			if($numberweaned_boar != []){
				$numberweaned_boar_sd = static::standardDeviation($numberweaned_boar, false);
			}
			else{
				$numberweaned_boar_sd = 0;
			}
			if($agesweaned_boar != []){
				$agesweaned_boar_sd = static::standardDeviation($agesweaned_boar, false);
			}
			else{
				$agesweaned_boar_sd = 0;
			}
			if($preweaningmortality_boar != []){
				$preweaningmortality_boar_sd = static::standardDeviation($preweaningmortality_boar, false);
			}
			else{
				$preweaningmortality_boar_sd = 0;
			}

			$now = Carbon::now('Asia/Manila');

			return Excel::create('productionperf_'.$now, function($excel) use ($lsba_sow, $numbermales_sow, $numberfemales_sow, $stillborn_sow, $mummified_sow, $litterbirthweights_sow, $avebirthweights_sow, $litterweaningweights_sow, $aveweaningweights_sow, $adjweaningweights_sow, $numberweaned_sow, $agesweaned_sow, $preweaningmortality_sow, $lsba_sow_sd, $numbermales_sow_sd, $numberfemales_sow_sd, $stillborn_sow_sd, $mummified_sow_sd, $litterbirthweights_sow_sd, $avebirthweights_sow_sd, $litterweaningweights_sow_sd, $aveweaningweights_sow_sd, $adjweaningweights_sow_sd, $numberweaned_sow_sd, $agesweaned_sow_sd, $preweaningmortality_sow_sd, $lsba_boar, $numbermales_boar, $numberfemales_boar, $stillborn_boar, $mummified_boar, $litterbirthweights_boar, $avebirthweights_boar, $litterweaningweights_boar, $aveweaningweights_boar, $adjweaningweights_boar, $numberweaned_boar, $agesweaned_boar, $preweaningmortality_boar, $lsba_boar_sd, $numbermales_boar_sd, $numberfemales_boar_sd, $stillborn_boar_sd, $mummified_boar_sd, $litterbirthweights_boar_sd, $avebirthweights_boar_sd, $litterweaningweights_boar_sd, $aveweaningweights_boar_sd, $adjweaningweights_boar_sd, $numberweaned_boar_sd, $agesweaned_boar_sd, $preweaningmortality_boar_sd, $now) {
				$excel->sheet('productionperformance', function($sheet) use ($lsba_sow, $numbermales_sow, $numberfemales_sow, $stillborn_sow, $mummified_sow, $litterbirthweights_sow, $avebirthweights_sow, $litterweaningweights_sow, $aveweaningweights_sow, $adjweaningweights_sow, $numberweaned_sow, $agesweaned_sow, $preweaningmortality_sow, $lsba_sow_sd, $numbermales_sow_sd, $numberfemales_sow_sd, $stillborn_sow_sd, $mummified_sow_sd, $litterbirthweights_sow_sd, $avebirthweights_sow_sd, $litterweaningweights_sow_sd, $aveweaningweights_sow_sd, $adjweaningweights_sow_sd, $numberweaned_sow_sd, $agesweaned_sow_sd, $preweaningmortality_sow_sd, $lsba_boar, $numbermales_boar, $numberfemales_boar, $stillborn_boar, $mummified_boar, $litterbirthweights_boar, $avebirthweights_boar, $litterweaningweights_boar, $aveweaningweights_boar, $adjweaningweights_boar, $numberweaned_boar, $agesweaned_boar, $preweaningmortality_boar, $lsba_boar_sd, $numbermales_boar_sd, $numberfemales_boar_sd, $stillborn_boar_sd, $mummified_boar_sd, $litterbirthweights_boar_sd, $avebirthweights_boar_sd, $litterweaningweights_boar_sd, $aveweaningweights_boar_sd, $adjweaningweights_boar_sd, $numberweaned_boar_sd, $agesweaned_boar_sd, $preweaningmortality_boar_sd, $now) {
					$sheet->setOrientation('landscape');
					$sheet->row(1, array(
						'Sows Summary'
					));
					$sheet->row(2, array(
						'Parameters', 'Average', 'Standard Deviation'
					));
					if($lsba_sow != []){
						$sheet->row(3, array(
							'Litter-size Born Alive', round(array_sum($lsba_sow)/count($lsba_sow), 2), round($lsba_sow_sd, 2)
						));
					}
					else{
						$sheet->row(3, array(
							'Litter-size Born Alive', 'No data available', 'No data available'
						));
					}
					if($numbermales_sow != []){
						$sheet->row(4, array(
							'Number Male Born', round(array_sum($numbermales_sow)/count($numbermales_sow), 2), round($numbermales_sow_sd, 2)
						));
					}
					else{
						$sheet->row(4, array(
							'Number Male Born', 'No data available', 'No data available'
						));
					}
					if($numberfemales_sow != []){
						$sheet->row(5, array(
							'Number Female Born', round(array_sum($numberfemales_sow)/count($numberfemales_sow), 2), round($numberfemales_sow_sd, 2)
						));
					}
					else{
						$sheet->row(5, array(
							'Number Female Born', 'No data available', 'No data available'
						));
					}
					if($stillborn_sow != []){
						$sheet->row(6, array(
							'Number Stillborn', round(array_sum($stillborn_sow)/count($stillborn_sow), 2), round($stillborn_sow_sd, 2)
						));
					}
					else{
						$sheet->row(6, array(
							'Number Stillborn', 'No data available', 'No data available'
						));
					}
					if($mummified_sow != []){
						$sheet->row(7, array(
							'Number Mummified', round(array_sum($mummified_sow)/count($mummified_sow), 2), round($mummified_sow_sd, 2)
						));
					}
					else{
						$sheet->row(7, array(
							'Number Mummified', 'No data available', 'No data available'
						));
					}
					if($litterbirthweights_sow != []){
						$sheet->row(8, array(
							'Litter Birth Weight, kg', round(array_sum($litterbirthweights_sow)/count($litterbirthweights_sow), 2), round($litterbirthweights_sow_sd, 2)
						));
					}
					else{
						$sheet->row(8, array(
							'Litter Birth Weight, kg', 'No data available', 'No data available'
						));
					}
					if($avebirthweights_sow != []){
						$sheet->row(9, array(
							'Average Birth Weight, kg', round(array_sum($avebirthweights_sow)/count($avebirthweights_sow), 2), round($avebirthweights_sow_sd, 2)
						));
					}
					else{
						$sheet->row(9, array(
							'Average Birth Weight, kg', 'No data available', 'No data available'
						));
					}
					if($litterweaningweights_sow != []){
						$sheet->row(10, array(
							'Litter Weaning Weight, kg', round(array_sum($litterweaningweights_sow)/count($litterweaningweights_sow), 2), round($litterweaningweights_sow_sd, 2)
						));
					}
					else{
						$sheet->row(10, array(
							'Litter Weaning Weight, kg', 'No data available', 'No data available'
						));
					}
					if($aveweaningweights_sow != []){
						$sheet->row(11, array(
							'Average Weaning Weight, kg', round(array_sum($aveweaningweights_sow)/count($aveweaningweights_sow), 2), round($aveweaningweights_sow_sd, 2)
						));
					}
					else{
						$sheet->row(11, array(
							'Average Weaning Weight, kg', 'No data available', 'No data available'
						));
					}
					if($adjweaningweights_sow != []){
						$sheet->row(12, array(
							'Adjusted Weaning Weight at 45 Days, kg', round(array_sum($adjweaningweights_sow)/count($adjweaningweights_sow), 2), round($adjweaningweights_sow_sd, 2)
						));
					}
					else{
						$sheet->row(12, array(
							'Adjusted Weaning Weight at 45 Days, kg', 'No data available', 'No data available'
						));
					}
					if($numberweaned_sow != []){
						$sheet->row(13, array(
							'Number Weaned', round(array_sum($numberweaned_sow)/count($numberweaned_sow), 2), round($numberweaned_sow_sd, 2)
						));
					}
					else{
						$sheet->row(13, array(
							'Number Weaned', 'No data available', 'No data available'
						));
					}
					if($agesweaned_sow != []){
						$sheet->row(14, array(
							'Age Weaned, days', round(array_sum($agesweaned_sow)/count($agesweaned_sow), 2), round($agesweaned_sow_sd, 2)
						));
					}
					else{
						$sheet->row(14, array(
							'Age Weaned, days', 'No data available', 'No data available'
						));
					}
					if($preweaningmortality_sow != []){
						$sheet->row(15, array(
							'Pre-weaning Mortality, %', round(array_sum($preweaningmortality_sow)/count($preweaningmortality_sow), 2), round($preweaningmortality_sow_sd, 2)
						));
					}
					else{
						$sheet->row(15, array(
							'Pre-weaning Mortality, %', 'No data available', 'No data available'
						));
					}
					$sheet->row(16, array(
						' '
					));
					$sheet->row(17, array(
						'Boars Summary'
					));
					$sheet->row(18, array(
						'Parameters', 'Average', 'Standard Deviation'
					));
					if($lsba_boar != []){
						$sheet->row(19, array(
							'Litter-size Born Alive', round(array_sum($lsba_boar)/count($lsba_boar), 2), round($lsba_boar_sd, 2)
						));
					}
					else{
						$sheet->row(19, array(
							'Litter-size Born Alive', 'No data available', 'No data available'
						));
					}
					if($numbermales_boar != []){
						$sheet->row(20, array(
							'Number Male Born', round(array_sum($numbermales_boar)/count($numbermales_boar), 2), round($numbermales_boar_sd, 2)
						));
					}
					else{
						$sheet->row(20, array(
							'Number Male Born', 'No data available', 'No data available'
						));
					}
					if($numberfemales_boar != []){
						$sheet->row(21, array(
							'Number Female Born', round(array_sum($numberfemales_boar)/count($numberfemales_boar), 2), round($numberfemales_boar_sd, 2)
						));
					}
					else{
						$sheet->row(21, array(
							'Number Female Born', 'No data available', 'No data available'
						));
					}
					if($stillborn_boar != []){
						$sheet->row(22, array(
							'Number Stillborn', round(array_sum($stillborn_boar)/count($stillborn_boar), 2), round($stillborn_boar_sd, 2)
						));
					}
					else{
						$sheet->row(22, array(
							'Number Stillborn', 'No data available', 'No data available'
						));
					}

					if($mummified_boar != []){
						$sheet->row(23, array(
							'Number Mummified', round(array_sum($mummified_boar)/count($mummified_boar), 2), round($mummified_boar_sd, 2)
						));
					}
					else{
						$sheet->row(23, array(
							'Number Mummified', 'No data available', 'No data available'
						));
					}
					if($litterbirthweights_boar != []){
						$sheet->row(24, array(
							'Litter Birth Weight, kg', round(array_sum($litterbirthweights_boar)/count($litterbirthweights_boar), 2), round($litterbirthweights_boar_sd, 2)
						));
					}
					else{
						$sheet->row(24, array(
							'Litter Birth Weight, kg', 'No data available', 'No data available'
						));
					}
					if($avebirthweights_boar != []){
						$sheet->row(25, array(
							'Average Birth Weight, kg', round(array_sum($avebirthweights_boar)/count($avebirthweights_boar), 2), round($avebirthweights_boar_sd, 2)
						));
					}
					else{
						$sheet->row(25, array(
							'Average Birth Weight, kg', 'No data available', 'No data available'
						));
					}
					if($litterweaningweights_boar != []){
						$sheet->row(26, array(
							'Litter Weaning Weight, kg', round(array_sum($litterweaningweights_boar)/count($litterweaningweights_boar), 2), round($litterweaningweights_boar_sd, 2)
						));
					}
					else{
						$sheet->row(26, array(
							'Litter Weaning Weight, kg', 'No data available', 'No data available'
						));
					}
					if($aveweaningweights_boar != []){
						$sheet->row(27, array(
							'Average Weaning Weight, kg', round(array_sum($aveweaningweights_boar)/count($aveweaningweights_boar), 2), round($aveweaningweights_boar_sd, 2)
						));
					}
					else{
						$sheet->row(27, array(
							'Average Weaning Weight, kg', 'No data available', 'No data available'
						));
					}
					if($adjweaningweights_boar != []){
						$sheet->row(28, array(
							'Adjusted Weaning Weight at 45 Days, kg', round(array_sum($adjweaningweights_boar)/count($adjweaningweights_boar), 2), round($adjweaningweights_boar_sd, 2)
						));
					}
					else{
						$sheet->row(28, array(
							'Adjusted Weaning Weight at 45 Days, kg', 'No data available', 'No data available'
						));
					}
					if($numberweaned_boar != []){
						$sheet->row(29, array(
							'Number Weaned', round(array_sum($numberweaned_boar)/count($numberweaned_boar), 2), round($numberweaned_boar_sd, 2)
						));
					}
					else{
						$sheet->row(29, array(
							'Number Weaned', 'No data available', 'No data available'
						));
					}
					if($agesweaned_boar != []){
						$sheet->row(30, array(
							'Age Weaned, days', round(array_sum($agesweaned_boar)/count($agesweaned_boar), 2), round($agesweaned_boar_sd, 2)
						));
					}
					else{
						$sheet->row(30, array(
							'Age Weaned, days', 'No data available', 'No data available'
						));
					}
					if($preweaningmortality_boar != []){
						$sheet->row(31, array(
							'Pre-weaning Mortality, %', round(array_sum($preweaningmortality_boar)/count($preweaningmortality_boar), 2), round($preweaningmortality_boar_sd, 2)
						));
					}
					else{
						$sheet->row(31, array(
							'Pre-weaning Mortality, %', 'No data available', 'No data available'
						));
					}
				});	
			})->download('csv');
		}

		public function getProductionPerformancePage(Request $request){ // function to display Production Performace page
			set_time_limit(5000);
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$archived_pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "dead breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "removed breeder");
													})->get();

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

			// sow breeders are sows with frequency of at least 1
			$sowbreeders = [];
			$boarbreeders = [];
			foreach ($sows as $sow) {
				$sowproperties = $sow->getAnimalProperties();
				foreach ($sowproperties as $sowproperty) {
					if($sowproperty->property_id == 61){ // frequency
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
					if($boarproperty->property_id == 61){ // frequency
						if($boarproperty->value > 0){
							array_push($boarbreeders, $boar);
						}
					}
				}
			}

			$archived_sows = [];
			$archived_boars = [];
			$temp_archived_sows = [];
			$temp_archived_boars = [];
			foreach ($archived_pigs as $archived_pig) {
				if(substr($archived_pig->registryid, -7, 1) == 'F'){
					array_push($temp_archived_sows, $archived_pig);
				}
				if(substr($archived_pig->registryid, -7, 1) == 'M'){
					array_push($temp_archived_boars, $archived_pig);
				}
			}

			foreach ($temp_archived_sows as $temp_archived_sow) {
				$temp_sow_row = $temp_archived_sow->getAnimalProperties()->where("property_id", 61)->first();
				if (!empty($temp_sow_row)) {
					array_push($archived_sows, $temp_archived_sow);
				}
			}

			foreach ($temp_archived_boars as $temp_archived_boar) {
				$temp_boar_row = $temp_archived_boar->getAnimalProperties()->where("property_id", 61)->first();
				if (!empty($temp_boar_row)) {
					array_push($archived_boars, $temp_archived_boar);
				}
			}

			//gets all groups
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			/*** PER PARITY ***/
			// gets unique parity
			$parity = [];
			$tempparity = [];
			foreach ($groups as $group) {
				$groupproperties = $group->getGroupingProperties();
				foreach ($groupproperties as $groupproperty) {
					if($groupproperty->property_id == 48){ //parity
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
					if($groupproperty->property_id == 48){ //parity
						if($groupproperty->value == $filter){
							array_push($groupswiththisparity, $group);
						}
					}
				}
			}

			$lsba = [];
			$numbermales = [];
			$numberfemales = [];
			$stillborn = [];
			$mummified = [];
			$litterbirthweights = [];
			$avebirthweights = [];
			$litterweaningweights = [];
			$aveweaningweights = [];
			$adjweaningweights = [];
			$numberweaned = [];
			$agesweaned = [];
			$preweaningmortality = [];
			foreach ($groupswiththisparity as $groupwiththisparity) {
				$lsbaprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 50)->first();
				if(!is_null($lsbaprop)){
					$lsbavalue = $lsbaprop->value;
					array_push($lsba, $lsbavalue);
				}
				$numbermalesprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 51)->first();
				if(!is_null($numbermalesprop)){
					$numbermalesvalue = $numbermalesprop->value;
					array_push($numbermales, $numbermalesvalue);
				}
				$numberfemalesprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 52)->first();
				if(!is_null($numberfemalesprop)){
					$numberfemalesvalue = $numberfemalesprop->value;
					array_push($numberfemales, $numberfemalesvalue);
				}
				$stillbornprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 45)->first();
				if(!is_null($stillbornprop)){
					$stillbornvalue = $stillbornprop->value;
					array_push($stillborn, $stillbornvalue);
				}
				$mummifiedprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 46)->first();
				if(!is_null($mummifiedprop)){
					$mummifiedvalue = $mummifiedprop->value;
					array_push($mummified, $mummifiedvalue);
				}
				$litterbwprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 55)->first();
				if(!is_null($litterbwprop)){
					$litterbwvalue = $litterbwprop->value;
					array_push($litterbirthweights, $litterbwvalue);
				}
				$avebwprop = $groupwiththisparity->getGroupingProperties()->where("property_id", 56)->first();
				if(!is_null($avebwprop)){
					$avebwvalue = $avebwprop->value;
					array_push($avebirthweights, $avebwvalue);
				}
				if(!is_null($groupwiththisparity->getGroupingProperties()->where("property_id", 62)->first())){
					$litterwwvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 62)->first()->value;
					array_push($litterweaningweights, $litterwwvalue);
				}
				if(!is_null($groupwiththisparity->getGroupingProperties()->where("property_id", 58)->first())){
					$avewwvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 58)->first()->value;
					array_push($aveweaningweights, $avewwvalue);
				}
				if(!is_null($groupwiththisparity->getGroupingProperties()->where("property_id", 57)->first())){
					$numberweanedvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 57)->first()->value;
					array_push($numberweaned, $numberweanedvalue);
				}
				if(!is_null($groupwiththisparity->getGroupingProperties()->where("property_id", 59)->first())){
					$pwmvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 59)->first()->value;
					array_push($preweaningmortality, $pwmvalue);
				}
				$thisoffsprings = $groupwiththisparity->getGroupingMembers();
				$ageweaned = [];
				$adjweaningweight = [];
				foreach ($thisoffsprings as $thisoffspring) {
					if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
						$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
						$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
							$bday = $bdayprop->value;
						}
						$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
						array_push($ageweaned, $age);
						$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
						if(!is_null($wwprop) && $wwprop->value != ""){
							$adjww = ((float)$wwprop->value*45)/$age;
							array_push($adjweaningweight, $adjww);
						}
					}
				}
				if($ageweaned != []){
					array_push($agesweaned, (array_sum($ageweaned)/count($ageweaned)));
				}
				if($adjweaningweight != []){
					array_push($adjweaningweights, (array_sum($adjweaningweight)/count($adjweaningweight)));
				}
			}


			return view('pigs.productionperformance', compact('sowbreeders', 'boarbreeders', 'parity', 'groupswiththisparity', 'filter', 'lsba', 'numbermales', 'numberfemales', 'stillborn', 'mummified', 'litterbirthweights', 'avebirthweights', 'litterweaningweights', 'aveweaningweights', 'adjweaningweights', 'numberweaned', 'agesweaned', 'preweaningmortality', 'archived_sows', 'archived_boars'));
		}

		public function sowProductionPerfDownloadPDF($id){
			$sow = Animal::find($id);
			$properties = $sow->getAnimalProperties();
			$groups = Grouping::where("mother_id", $sow->id)->get();

			$usage = [];
			$count = 1;
			$temp = [];
			$parities = [];
			$unsorted_parities = [];
			$dates_farrowed = [];
			$unsorted_farrowings = [];
			$temp_dates = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 42){ //date bred
						$date = $groupingproperty->value;
						array_push($temp, $date);
					}
					if($groupingproperty->property_id == 48){ //parity
						array_push($unsorted_parities, $groupingproperty->value);
					}
					if($groupingproperty->property_id == 3){ //date farrowed
						$date = Carbon::parse($groupingproperty->value);
						array_push($unsorted_farrowings, $date);
					}
				}
			}
			$usage = array_sort($temp);
			$parities = array_sort($unsorted_parities);
			$removed_first = array_slice($parities, 1);
			$temp_dates = array_sort($unsorted_farrowings);
			$farrowing_intervals_text = [];
			if(count($parities) > 1){
				for($i = 0, $n = count($unsorted_farrowings); $i < $n; $i++){
					array_push($dates_farrowed, array_shift($temp_dates));
				}

				for($i = 1, $n = count($dates_farrowed); $i < $n; $i++){
					array_push($farrowing_intervals_text, "From Parity ".$i." to Parity ".($i+1).": ".$dates_farrowed[$i]->diffInDays($dates_farrowed[$i-1])."");
					$farrowing_intervals[] = $dates_farrowed[$i]->diffInDays($dates_farrowed[$i-1]);
				}

				if($farrowing_intervals != []){
					$average = array_sum($farrowing_intervals)/count($farrowing_intervals);
					$farrowing_index =  365/$average;
				}
			}

			$dobprop = $properties->where("property_id", 3)->first();
			if(!is_null($dobprop)){
				if($dobprop->value != "Not specified"){
					$dob = Carbon::parse($dobprop->value);
					$firstbred = Carbon::parse(reset($usage));
					$age_firstbred = $firstbred->diffInMonths($dob);
					if(count($parities) > 1){
						$firstparity = Carbon::parse(reset($dates_farrowed));
						$age_firstparity = $firstparity->diffInMonths($dob);
					}
					else{
						$firstparity = Carbon::parse(reset($temp_dates));
						$age_firstparity = $firstparity->diffInMonths($dob);
					}
				}
			}
			else{
				$age_firstbred = "";
				$age_firstparity = "";
			}

			$lsba_sow = [];
			$numbermales_sow = [];
			$numberfemales_sow = [];
			$stillborn_sow = [];
			$mummified_sow = [];
			$litterbirthweights_sow = [];
			$avebirthweights_sow = [];
			$litterweaningweights_sow = [];
			$aveweaningweights_sow = [];
			$adjweaningweights_sow = [];
			$numberweaned_sow = [];
			$agesweaned_sow = [];
			$preweaningmortality_sow = [];
			foreach ($groups as $group) {
				$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
				if(!is_null($lsbaprop)){
					array_push($lsba_sow, $lsbaprop->value);
				}
				$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
				if(!is_null($numbermalesprop)){
					array_push($numbermales_sow, $numbermalesprop->value);
				}
				$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
				if(!is_null($numberfemalesprop)){
					array_push($numberfemales_sow, $numberfemalesprop->value);
				}
				$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
				if(!is_null($stillbornprop)){
					array_push($stillborn_sow, $stillbornprop->value);
				}
				$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
				if(!is_null($mummifiedprop)){
					array_push($mummified_sow, $mummifiedprop->value);
				}
				$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
				if(!is_null($litterbwprop)){
					array_push($litterbirthweights_sow, $litterbwprop->value);
				}
				$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
				if(!is_null($avebwprop)){
					array_push($avebirthweights_sow, $avebwprop->value);
				}
				$litterwwprop = $group->getGroupingProperties()->where("property_id", 62)->first();
				if(!is_null($litterwwprop)){
					array_push($litterweaningweights_sow, $litterwwprop->value);	
				}
				$avewwprop = $group->getGroupingProperties()->where("property_id", 58)->first();
				if(!is_null($avewwprop)){
					array_push($aveweaningweights_sow, $avewwprop->value);
				}
				$numberweanedprop = $group->getGroupingProperties()->where("property_id", 57)->first();
				if(!is_null($numberweanedprop)){
					array_push($numberweaned_sow, $numberweanedprop->value);
				}
				$pwmprop = $group->getGroupingProperties()->where("property_id", 59)->first();
				if(!is_null($pwmprop)){
					array_push($preweaningmortality_sow, $pwmprop->value);
				}
				$thisoffsprings = $group->getGroupingMembers();
				$ageweaned_sow = [];
				$adjweaningweight_sow = [];
				foreach ($thisoffsprings as $thisoffspring) {
					if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
						$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
						$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
							$bday = $bdayprop->value;
						}
						$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
						array_push($ageweaned_sow, $age);
						$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
						if(!is_null($wwprop) && $wwprop->value != ""){
							$adjww = ((float)$wwprop->value*45)/$age;
							array_push($adjweaningweight_sow, $adjww);
						}
					}
				}
				if($ageweaned_sow != []){
					array_push($agesweaned_sow, (array_sum($ageweaned_sow)/count($ageweaned_sow)));
				}
				if($adjweaningweight_sow != []){
					array_push($adjweaningweights_sow, (array_sum($adjweaningweight_sow)/count($adjweaningweight_sow)));
				}
			}

			if($lsba_sow != []){
				$lsba_sow_sd = static::standardDeviation($lsba_sow, false);
			}
			if($numbermales_sow != []){
				$numbermales_sow_sd = static::standardDeviation($numbermales_sow, false);
			}
			if($numberfemales_sow != []){
				$numberfemales_sow_sd = static::standardDeviation($numberfemales_sow, false);
			}
			if($stillborn_sow != []){
				$stillborn_sow_sd = static::standardDeviation($stillborn_sow, false);
			}
			if($mummified_sow != []){
				$mummified_sow_sd = static::standardDeviation($mummified_sow, false);
			}
			if($litterbirthweights_sow != []){
				$litterbirthweights_sow_sd = static::standardDeviation($litterbirthweights_sow, false);
			}
			if($avebirthweights_sow != []){
				$avebirthweights_sow_sd = static::standardDeviation($avebirthweights_sow, false);
			}
			if($litterweaningweights_sow != []){
				$litterweaningweights_sow_sd = static::standardDeviation($litterweaningweights_sow, false);
			}
			if($aveweaningweights_sow != []){
				$aveweaningweights_sow_sd = static::standardDeviation($aveweaningweights_sow, false);
			}
			if($adjweaningweights_sow != []){
				$adjweaningweights_sow_sd = static::standardDeviation($adjweaningweights_sow, false);
			}
			if($numberweaned_sow != []){
				$numberweaned_sow_sd = static::standardDeviation($numberweaned_sow, false);
			}
			if($agesweaned_sow != []){
				$agesweaned_sow_sd = static::standardDeviation($agesweaned_sow, false);
			}
			if($preweaningmortality_sow != []){
				$preweaningmortality_sow_sd = static::standardDeviation($preweaningmortality_sow, false);
			}

			$now = Carbon::now('Asia/Manila');

			$pdf = PDF::loadView('pigs.sowproductionperfpdf', compact('sow', 'properties', 'usage', 'parities', 'removed_first', 'farrowing_intervals_text', 'farrowing_index', 'age_firstbred', 'age_firstparity', 'lsba_sow', 'numbermales_sow', 'numberfemales_sow', 'stillborn_sow', 'mummified_sow', 'litterbirthweights_sow', 'avebirthweights_sow', 'litterweaningweights_sow', 'aveweaningweights_sow', 'adjweaningweights_sow', 'numberweaned_sow', 'agesweaned_sow', 'preweaningmortality_sow', 'lsba_sow_sd', 'numbermales_sow_sd', 'numberfemales_sow_sd', 'stillborn_sow_sd', 'mummified_sow_sd', 'litterbirthweights_sow_sd', 'avebirthweights_sow_sd', 'litterweaningweights_sow_sd', 'aveweaningweights_sow_sd', 'adjweaningweights_sow_sd', 'numberweaned_sow_sd', 'agesweaned_sow_sd', 'preweaningmortality_sow_sd', 'now'));

			return $pdf->download('sowproductionperf_'.$sow->registryid.'_'.$now.'.pdf');
		}

		public function sowProductionPerfDownloadCSV($id){
			$sow = Animal::find($id);
			$properties = $sow->getAnimalProperties();
			$groups = Grouping::where("mother_id", $sow->id)->get();

			$usage = [];
			$count = 1;
			$temp = [];
			$parities = [];
			$unsorted_parities = [];
			$dates_farrowed = [];
			$unsorted_farrowings = [];
			$temp_dates = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 42){ //date bred
						$date = $groupingproperty->value;
						array_push($temp, $date);
					}
					if($groupingproperty->property_id == 48){ //parity
						array_push($unsorted_parities, $groupingproperty->value);
					}
					if($groupingproperty->property_id == 3){ //date farrowed
						$date = Carbon::parse($groupingproperty->value);
						array_push($unsorted_farrowings, $date);
					}
				}
			}
			$usage = array_sort($temp);
			$parities = array_sort($unsorted_parities);
			$removed_first = array_slice($parities, 1);
			$temp_dates = array_sort($unsorted_farrowings);
			$farrowing_intervals_text = [];
			if(count($parities) > 1){
				for($i = 0, $n = count($unsorted_farrowings); $i < $n; $i++){
					array_push($dates_farrowed, array_shift($temp_dates));
				}

				for($i = 1, $n = count($dates_farrowed); $i < $n; $i++){
					array_push($farrowing_intervals_text, "From Parity ".$i." to Parity ".($i+1).": ".$dates_farrowed[$i]->diffInDays($dates_farrowed[$i-1])."");
					$farrowing_intervals[] = $dates_farrowed[$i]->diffInDays($dates_farrowed[$i-1]);
				}

				if($farrowing_intervals != []){
					$average = array_sum($farrowing_intervals)/count($farrowing_intervals);
					$farrowing_index =  365/$average;
				}
				else{
					$farrowing_index = 0;
				}
			}
			else{
				$farrowing_index = 0;
			}

			$dobprop = $properties->where("property_id", 3)->first();
			if(!is_null($dobprop)){
				if($dobprop->value != "Not specified"){
					$dob = Carbon::parse($dobprop->value);
					$firstbred = Carbon::parse(reset($usage));
					$age_firstbred = $firstbred->diffInMonths($dob);
					if(count($parities) > 1){
						$firstparity = Carbon::parse(reset($dates_farrowed));
						$age_firstparity = $firstparity->diffInMonths($dob);
					}
					else{
						$firstparity = Carbon::parse(reset($temp_dates));
						$age_firstparity = $firstparity->diffInMonths($dob);
					}
				}
			}
			else{
				$age_firstbred = "";
				$age_firstparity = "";
			}

			$lsba_sow = [];
			$numbermales_sow = [];
			$numberfemales_sow = [];
			$stillborn_sow = [];
			$mummified_sow = [];
			$litterbirthweights_sow = [];
			$avebirthweights_sow = [];
			$litterweaningweights_sow = [];
			$aveweaningweights_sow = [];
			$adjweaningweights_sow = [];
			$numberweaned_sow = [];
			$agesweaned_sow = [];
			$preweaningmortality_sow = [];
			foreach ($groups as $group) {
				$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
				if(!is_null($lsbaprop)){
					array_push($lsba_sow, $lsbaprop->value);
				}
				$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
				if(!is_null($numbermalesprop)){
					array_push($numbermales_sow, $numbermalesprop->value);
				}
				$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
				if(!is_null($numberfemalesprop)){
					array_push($numberfemales_sow, $numberfemalesprop->value);
				}
				$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
				if(!is_null($stillbornprop)){
					array_push($stillborn_sow, $stillbornprop->value);
				}
				$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
				if(!is_null($mummifiedprop)){
					array_push($mummified_sow, $mummifiedprop->value);
				}
				$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
				if(!is_null($litterbwprop)){
					array_push($litterbirthweights_sow, $litterbwprop->value);
				}
				$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
				if(!is_null($avebwprop)){
					array_push($avebirthweights_sow, $avebwprop->value);
				}
				$litterwwprop = $group->getGroupingProperties()->where("property_id", 62)->first();
				if(!is_null($litterwwprop)){
					array_push($litterweaningweights_sow, $litterwwprop->value);	
				}
				$avewwprop = $group->getGroupingProperties()->where("property_id", 58)->first();
				if(!is_null($avewwprop)){
					array_push($aveweaningweights_sow, $avewwprop->value);
				}
				$numberweanedprop = $group->getGroupingProperties()->where("property_id", 57)->first();
				if(!is_null($numberweanedprop)){
					array_push($numberweaned_sow, $numberweanedprop->value);
				}
				$pwmprop = $group->getGroupingProperties()->where("property_id", 59)->first();
				if(!is_null($pwmprop)){
					array_push($preweaningmortality_sow, $pwmprop->value);
				}
				$thisoffsprings = $group->getGroupingMembers();
				$ageweaned_sow = [];
				$adjweaningweight_sow = [];
				foreach ($thisoffsprings as $thisoffspring) {
					if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
						$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
						$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
							$bday = $bdayprop->value;
						}
						$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
						array_push($ageweaned_sow, $age);
						$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
						if(!is_null($wwprop) && $wwprop->value != ""){
							$adjww = ((float)$wwprop->value*45)/$age;
							array_push($adjweaningweight_sow, $adjww);
						}
					}
				}
				if($ageweaned_sow != []){
					array_push($agesweaned_sow, (array_sum($ageweaned_sow)/count($ageweaned_sow)));
				}
				if($adjweaningweight_sow != []){
					array_push($adjweaningweights_sow, (array_sum($adjweaningweight_sow)/count($adjweaningweight_sow)));
				}
			}

			if($lsba_sow != []){
				$lsba_sow_sd = static::standardDeviation($lsba_sow, false);
			}
			else{
				$lsba_sow_sd = 0;
			}
			if($numbermales_sow != []){
				$numbermales_sow_sd = static::standardDeviation($numbermales_sow, false);
			}
			else{
				$numbermales_sow_sd = 0;
			}
			if($numberfemales_sow != []){
				$numberfemales_sow_sd = static::standardDeviation($numberfemales_sow, false);
			}
			else{
				$numberfemales_sow_sd = 0;
			}
			if($stillborn_sow != []){
				$stillborn_sow_sd = static::standardDeviation($stillborn_sow, false);
			}
			else{
				$stillborn_sow_sd = 0;
			}
			if($mummified_sow != []){
				$mummified_sow_sd = static::standardDeviation($mummified_sow, false);
			}
			else{
				$mummified_sow_sd = 0;
			}
			if($litterbirthweights_sow != []){
				$litterbirthweights_sow_sd = static::standardDeviation($litterbirthweights_sow, false);
			}
			else{
				$litterbirthweights_sow_sd = 0;
			}
			if($avebirthweights_sow != []){
				$avebirthweights_sow_sd = static::standardDeviation($avebirthweights_sow, false);
			}
			else{
				$avebirthweights_sow_sd = 0;
			}
			if($litterweaningweights_sow != []){
				$litterweaningweights_sow_sd = static::standardDeviation($litterweaningweights_sow, false);
			}
			else{
				$litterweaningweights_sow_sd = 0;
			}
			if($aveweaningweights_sow != []){
				$aveweaningweights_sow_sd = static::standardDeviation($aveweaningweights_sow, false);
			}
			else{
				$aveweaningweights_sow_sd = 0;
			}
			if($adjweaningweights_sow != []){
				$adjweaningweights_sow_sd = static::standardDeviation($adjweaningweights_sow, false);
			}
			else{
				$adjweaningweights_sow_sd = 0;
			}
			if($numberweaned_sow != []){
				$numberweaned_sow_sd = static::standardDeviation($numberweaned_sow, false);
			}
			else{
				$numberweaned_sow_sd = 0;
			}
			if($agesweaned_sow != []){
				$agesweaned_sow_sd = static::standardDeviation($agesweaned_sow, false);
			}
			else{
				$agesweaned_sow_sd = 0;
			}
			if($preweaningmortality_sow != []){
				$preweaningmortality_sow_sd = static::standardDeviation($preweaningmortality_sow, false);
			}
			else{
				$preweaningmortality_sow_sd = 0;
			}

			$now = Carbon::now('Asia/Manila');

			return Excel::create('sowproductionperf_'.$sow->registryid.'_'.$now, function($excel) use ($sow, $properties, $groups, $usage, $parities, $removed_first, $farrowing_intervals_text, $farrowing_index, $age_firstbred, $age_firstparity, $lsba_sow, $numbermales_sow, $numberfemales_sow, $stillborn_sow, $mummified_sow, $litterbirthweights_sow, $avebirthweights_sow, $litterweaningweights_sow, $aveweaningweights_sow, $adjweaningweights_sow, $numberweaned_sow, $agesweaned_sow, $preweaningmortality_sow, $lsba_sow_sd, $numbermales_sow_sd, $numberfemales_sow_sd, $stillborn_sow_sd, $mummified_sow_sd, $litterbirthweights_sow_sd, $avebirthweights_sow_sd, $litterweaningweights_sow_sd, $aveweaningweights_sow_sd, $adjweaningweights_sow_sd, $numberweaned_sow_sd, $agesweaned_sow_sd, $preweaningmortality_sow_sd, $now) {
				$excel->sheet('productionperformance', function($sheet) use ($sow, $properties, $groups, $usage, $parities, $removed_first, $farrowing_intervals_text, $farrowing_index, $age_firstbred, $age_firstparity, $lsba_sow, $numbermales_sow, $numberfemales_sow, $stillborn_sow, $mummified_sow, $litterbirthweights_sow, $avebirthweights_sow, $litterweaningweights_sow, $aveweaningweights_sow, $adjweaningweights_sow, $numberweaned_sow, $agesweaned_sow, $preweaningmortality_sow, $lsba_sow_sd, $numbermales_sow_sd, $numberfemales_sow_sd, $stillborn_sow_sd, $mummified_sow_sd, $litterbirthweights_sow_sd, $avebirthweights_sow_sd, $litterweaningweights_sow_sd, $aveweaningweights_sow_sd, $adjweaningweights_sow_sd, $numberweaned_sow_sd, $agesweaned_sow_sd, $preweaningmortality_sow_sd, $now) {
					$sheet->setOrientation('landscape');
					$sheet->row(1, array(
						$sow->registryid
					));
					if(!is_null($properties->where("property_id", 3)->first()) && $properties->where("property_id", 3)->first()->value != "Not specified"){
						$sheet->row(2, array(
							'Age First Bred: '.$age_firstbred, 'Age First Parity: '.$age_firstparity, 'Date of Birth: '.Carbon::parse($properties->where("property_id", 3)->first()->value)->format('F j, Y')
						));
					}
					else{
						$sheet->row(2, array(
							'No data for Date of Birth to compute Age First Bred and Age First Parity'
						));
					}
					$sheet->row(3, array(
						'Farrowing Intervals'
					));
					$i = 4;
					if(count($parities) <= 1){
						$sheet->row($i, array(
							'No data available'
						));
						$i++;
					}
					else{
						foreach ($farrowing_intervals_text as $farrowing_interval_text) {
							$sheet->row($i, array(
								$farrowing_interval_text.' days'
							));
							$i++;
						}
					}
					if(count($parities) <= 2){
						$sheet->row($i, array(
							'Farrowing Index: No data available'
						));
					}
					else{
						$sheet->row($i, array(
							'Farrowing Index: '.round($farrowing_index, 2)
						));	
					}
					$i++;
					$sheet->row($i, array(
						' '
					));
					$i++;
					$sheet->row($i, array(
						'Sow Card'
					));
					$i++;
					$sheet->row($i, array(
						'Parity', 'Boar Used', 'Date Bred', 'Status'
					));
					$i++;
					foreach ($usage as $sow_usage) {
						if(FarmController::getGroupingPerParity($sow->id, $sow_usage, "Parity") == 0){
							$sheet->row($i, array(
								'-', FarmController::getGroupingPerParity($sow->id, $sow_usage, "Boar Used"), Carbon::parse($sow_usage)->format('F j, Y'), FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status")
							));
						}
						else{
							$sheet->row($i, array(
								FarmController::getGroupingPerParity($sow->id, $sow_usage, "Parity"), FarmController::getGroupingPerParity($sow->id, $sow_usage, "Boar Used"), Carbon::parse($sow_usage)->format('F j, Y'), FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status")
							));
						}
						$i++;
					}
					$sheet->row($i, array(
						' '
					));
					$i++;
					$sheet->row($i, array(
						'Performance Per Parity'
					));
					$i++;
					$sheet->row($i, array(
						'Parity', 'Litter-size Born Alive', 'Number Male Born', 'Number Female Born', 'Number Stillborn', 'Number Mummified', 'Litter Birth Weight, kg', 'Average Birth Weight, kg', 'Litter Weaning Weight, kg', 'Average Weaning Weight, kg', 'Adjusted Weaning Weight at 45 Days, kg', 'Number Weaned', 'Age Weaned, days', 'Pre-weaning Mortality, %'
					));
					$i++;
					foreach ($parities as $parity) {
						$sheet->row($i, array(
							$parity, FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "lsba"), FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "number males"), FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "number females"), FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "stillborn"), FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "mummified"), FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "litter birth weight"), FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "ave birth weight"), FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "litter weaning weight"), FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "ave weaning weight"), FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "adj weaning weight"), FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "number weaned"), FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "age weaned"), FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "preweaning mortality")
						));
						$i++;
					}
					$sheet->row($i, array(
						' '
					));
					$i++;
					$sheet->row($i, array(
						'Summary'
					));
					$i++;
					$sheet->row($i, array(
						'Parameters', 'Average', 'Standard Deviation'
					));
					$i++;
					if($lsba_sow != []){
						$sheet->row($i, array(
							'Litter-size Born Alive', round(array_sum($lsba_sow)/count($lsba_sow), 2), round($lsba_sow_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Litter-size Born Alive', 'No data available', 'No data available'
						));
						$i++;
					}
					if($numbermales_sow != []){
						$sheet->row($i, array(
							'Number Male Born', round(array_sum($numbermales_sow)/count($numbermales_sow), 2), round($numbermales_sow_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Number Male Born', 'No data available', 'No data available'
						));
						$i++;
					}
					if($numberfemales_sow != []){
						$sheet->row($i, array(
							'Number Female Born', round(array_sum($numberfemales_sow)/count($numberfemales_sow), 2), round($numberfemales_sow_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Number Female Born', 'No data available', 'No data available'
						));
						$i++;
					}
					if($stillborn_sow != []){
						$sheet->row($i, array(
							'Number Stillborn', round(array_sum($stillborn_sow)/count($stillborn_sow), 2), round($stillborn_sow_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Number Stillborn', 'No data available', 'No data available'
						));
						$i++;
					}
					if($mummified_sow != []){
						$sheet->row($i, array(
							'Number Mummified', round(array_sum($mummified_sow)/count($mummified_sow), 2), round($mummified_sow_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Number Mummified', 'No data available', 'No data available'
						));
						$i++;
					}
					if($litterbirthweights_sow != []){
						$sheet->row($i, array(
							'Litter Birth Weight, kg', round(array_sum($litterbirthweights_sow)/count($litterbirthweights_sow), 2), round($litterbirthweights_sow_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Litter Birth Weight, kg', 'No data available', 'No data available'
						));
						$i++;
					}
					if($avebirthweights_sow != []){
						$sheet->row($i, array(
							'Average Birth Weight, kg', round(array_sum($avebirthweights_sow)/count($avebirthweights_sow), 2), round($avebirthweights_sow_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Average Birth Weight, kg', 'No data available', 'No data available'
						));
						$i++;
					}
					if($litterweaningweights_sow != []){
						$sheet->row($i, array(
							'Litter Weaning Weight, kg', round(array_sum($litterweaningweights_sow)/count($litterweaningweights_sow), 2), round($litterweaningweights_sow_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Litter Weaning Weight, kg', 'No data available', 'No data available'
						));
						$i++;
					}
					if($aveweaningweights_sow != []){
						$sheet->row($i, array(
							'Average Weaning Weight, kg', round(array_sum($aveweaningweights_sow)/count($aveweaningweights_sow), 2), round($aveweaningweights_sow_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Average Weaning Weight, kg', 'No data available', 'No data available'
						));
						$i++;
					}
					if($adjweaningweights_sow != []){
						$sheet->row($i, array(
							'Adjusted Weaning Weight at 45 Days, kg', round(array_sum($adjweaningweights_sow)/count($adjweaningweights_sow), 2), round($adjweaningweights_sow_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Adjusted Weaning Weight at 45 Days, kg', 'No data available', 'No data available'
						));
						$i++;
					}
					if($numberweaned_sow != []){
						$sheet->row($i, array(
							'Number Weaned', round(array_sum($numberweaned_sow)/count($numberweaned_sow), 2), round($numberweaned_sow_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Number Weaned', 'No data available', 'No data available'
						));
						$i++;
					}
					if($agesweaned_sow != []){
						$sheet->row($i, array(
							'Age Weaned, days', round(array_sum($agesweaned_sow)/count($agesweaned_sow), 2), round($agesweaned_sow_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Age Weaned, days', 'No data available', 'No data available'
						));
						$i++;
					}
					if($preweaningmortality_sow != []){
						$sheet->row($i, array(
							'Pre-weaning Mortality, %', round(array_sum($preweaningmortality_sow)/count($preweaningmortality_sow), 2), round($preweaningmortality_sow_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Pre-weaning Mortality, %', 'No data available', 'No data available'
						));
						$i++;
					}
				});	
			})->download('csv');
		}

		public function getSowProductionPerformancePage($id){ // function to display Sow Production Performance page
			set_time_limit(5000);
			$sow = Animal::find($id);
			$properties = $sow->getAnimalProperties();
			$groups = Grouping::where("mother_id", $sow->id)->get();

			$usage = [];
			$count = 1;
			$temp = [];
			$parities = [];
			$unsorted_parities = [];
			$dates_farrowed = [];
			$unsorted_farrowings = [];
			$temp_dates = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 42){ //date bred
						$date = $groupingproperty->value;
						array_push($temp, $date);
					}
					if($groupingproperty->property_id == 48){ //parity
						array_push($unsorted_parities, $groupingproperty->value);
					}
					if($groupingproperty->property_id == 3){ //date farrowed
						$date = Carbon::parse($groupingproperty->value);
						array_push($unsorted_farrowings, $date);
					}
				}
			}
			$usage = array_sort($temp);
			$parities = array_sort($unsorted_parities);
			$removed_first = array_slice($parities, 1);
			$temp_dates = array_sort($unsorted_farrowings);
			$farrowing_intervals_text = [];
			if(count($parities) > 1){
				for($i = 0, $n = count($unsorted_farrowings); $i < $n; $i++){
					array_push($dates_farrowed, array_shift($temp_dates));
				}

				for($i = 1, $n = count($dates_farrowed); $i < $n; $i++){
					array_push($farrowing_intervals_text, "From Parity ".$i." to Parity ".($i+1).": ".$dates_farrowed[$i]->diffInDays($dates_farrowed[$i-1])."");
					$farrowing_intervals[] = $dates_farrowed[$i]->diffInDays($dates_farrowed[$i-1]);
				}

				if($farrowing_intervals != []){
					$average = array_sum($farrowing_intervals)/count($farrowing_intervals);
					$farrowing_index =  365/$average;
				}
			}

			$dobprop = $properties->where("property_id", 3)->first();
			if(!is_null($dobprop)){
				if($dobprop->value != "Not specified"){
					$dob = Carbon::parse($dobprop->value);
					$firstbred = Carbon::parse(reset($usage));
					$age_firstbred = $firstbred->diffInMonths($dob);
					if(count($parities) > 1){
						$firstparity = Carbon::parse(reset($dates_farrowed));
						$age_firstparity = $firstparity->diffInMonths($dob);
					}
					else{
						$firstparity = Carbon::parse(reset($temp_dates));
						$age_firstparity = $firstparity->diffInMonths($dob);
					}
				}
			}
			else{
				$age_firstbred = "";
				$age_firstparity = "";
			}

			$lsba = [];
			$numbermales = [];
			$numberfemales = [];
			$stillborn = [];
			$mummified = [];
			$litterbirthweights = [];
			$avebirthweights = [];
			$litterweaningweights = [];
			$aveweaningweights = [];
			$adjweaningweights = [];
			$numberweaned = [];
			$agesweaned = [];
			$preweaningmortality = [];
			foreach ($groups as $group) {
				$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
				if(!is_null($lsbaprop)){
					array_push($lsba, $lsbaprop->value);
				}
				$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
				if(!is_null($numbermalesprop)){
					array_push($numbermales, $numbermalesprop->value);
				}
				$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
				if(!is_null($numberfemalesprop)){
					array_push($numberfemales, $numberfemalesprop->value);
				}
				$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
				if(!is_null($stillbornprop)){
					array_push($stillborn, $stillbornprop->value);
				}
				$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
				if(!is_null($mummifiedprop)){
					array_push($mummified, $mummifiedprop->value);
				}
				$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
				if(!is_null($litterbwprop)){
					array_push($litterbirthweights, $litterbwprop->value);
				}
				$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
				if(!is_null($avebwprop)){
					array_push($avebirthweights, $avebwprop->value);
				}
				$litterwwprop = $group->getGroupingProperties()->where("property_id", 62)->first();
				if(!is_null($litterwwprop)){
					array_push($litterweaningweights, $litterwwprop->value);	
				}
				$avewwprop = $group->getGroupingProperties()->where("property_id", 58)->first();
				if(!is_null($avewwprop)){
					array_push($aveweaningweights, $avewwprop->value);
				}
				$numberweanedprop = $group->getGroupingProperties()->where("property_id", 57)->first();
				if(!is_null($numberweanedprop)){
					array_push($numberweaned, $numberweanedprop->value);
				}
				$pwmprop = $group->getGroupingProperties()->where("property_id", 59)->first();
				if(!is_null($pwmprop)){
					array_push($preweaningmortality, $pwmprop->value);
				}
				$thisoffsprings = $group->getGroupingMembers();
				$ageweaned = [];
				$adjweaningweight = [];
				foreach ($thisoffsprings as $thisoffspring) {
					if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
						$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
						$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
							$bday = $bdayprop->value;
						}
						$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
						array_push($ageweaned, $age);
						$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
						if(!is_null($wwprop) && $wwprop->value != ""){
							$adjww = ((float)$wwprop->value*45)/$age;
							array_push($adjweaningweight, $adjww);
						}
					}
				}
				if($ageweaned != []){
					array_push($agesweaned, (array_sum($ageweaned)/count($ageweaned)));
				}
				if($adjweaningweight != []){
					array_push($adjweaningweights, (array_sum($adjweaningweight)/count($adjweaningweight)));
				}
			}



			return view('pigs.sowproductionperformance', compact('sow', 'properties', 'usage', 'parities', 'removed_first', 'farrowing_intervals_text', 'farrowing_index', 'age_firstbred', 'age_firstparity', 'lsba', 'numbermales', 'numberfemales', 'stillborn', 'mummified', 'litterbirthweights', 'avebirthweights', 'litterweaningweights', 'aveweaningweights', 'adjweaningweights', 'numberweaned', 'agesweaned', 'preweaningmortality'));
		}

		static function getGroupingPerParity($sow_id, $usage, $filter){
			$groups = Grouping::where("mother_id", $sow_id)->get();

			foreach ($groups as $group) {
				$properties = $group->getGroupingProperties();
				foreach ($properties as $property) {
					if($property->property_id == 42){ //date bred
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
				if(is_null($groupperusage->getGroupingProperties()->where("property_id", 48)->first())){
					return 0;
				}
				else{
					return $groupperusage->getGroupingProperties()->where("property_id", 48)->first()->value;
				}
			}
			elseif($filter == "Status"){
				return $groupperusage->getGroupingProperties()->where("property_id", 60)->first()->value;
			}
			elseif($filter == "Group ID"){
				return $groupperusage->id;
			}
		}

		static function getSowProductionPerformanceSummary($id, $parity, $filter){
			set_time_limit(5000);
			$groups = Grouping::where("mother_id", $id)->get();

			foreach ($groups as $group) {
				$parityprop = $group->getGroupingProperties()->where("property_id", 48)->first();
				if(!is_null($parityprop)){
					if($parityprop->value == $parity){
						if($filter == "lsba"){
							$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
							if(!is_null($lsbaprop)){
								return $lsbaprop->value;
							}
							else{
								return "No data available";
							}
						}
						elseif($filter == "number males"){
							$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
							if(!is_null($numbermalesprop)){
								return $numbermalesprop->value;
							}
							else{
								return "No data available";
							}
						}
						elseif($filter == "number females"){
							$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
							if(!is_null($numberfemalesprop)){
								return $numberfemalesprop->value;
							}
							else{
								return "No data available";
							}
						}
						elseif($filter == "stillborn"){
							$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
							if(!is_null($stillbornprop)){
								return $stillbornprop->value;
							}
							else{
								return "No data available";
							}
						}
						elseif($filter == "mummified"){
							$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
							if(!is_null($mummifiedprop)){
								return $mummifiedprop->value;
							}
							else{
								return "No data available";
							}
						}
						elseif($filter == "litter birth weight"){
							$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
							if(!is_null($litterbwprop)){
								return round($litterbwprop->value, 2);
							}
							else{
								return "No data available";
							}
						}
						elseif($filter == "ave birth weight"){
							$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
							if(!is_null($avebwprop)){
								return round($avebwprop->value, 2);
							}
							else{
								return "No data available";
							}
						}
						elseif($filter == "litter weaning weight"){
							$litterwwprop = $group->getGroupingProperties()->where("property_id", 62)->first();
							if(!is_null($litterwwprop)){
								return round($litterwwprop->value, 2);
							}
							else{
								return "No data available";
							}
						}
						elseif($filter == "ave weaning weight"){
							$avewwprop = $group->getGroupingProperties()->where("property_id", 58)->first();
							if(!is_null($avewwprop)){
								return round($avewwprop->value, 2);
							}
							else{
								return "No data available";
							}
						}
						elseif($filter == "adj weaning weight"){
							$adjweaningweights = [];
							$offsprings = $group->getGroupingMembers();
							foreach ($offsprings as $offspring) {
								$offspringproperties = $offspring->getAnimalProperties();
								foreach ($offspringproperties as $offspringproperty) {
									if($offspringproperty->property_id == 6){ //date weaned
										if($offspringproperty->value != "Not specified"){
											$date_weaned = Carbon::parse($offspringproperty->value);
											$bday = $offspring->getAnimalProperties()->where("property_id", 3)->first()->value;
											$age = $date_weaned->diffInDays(Carbon::parse($bday));
											$weaningweight = $offspring->getAnimalProperties()->where("property_id", 7)->first()->value;
											$adjweaningweightat45d = ($weaningweight*45)/$age;
											array_push($adjweaningweights, $adjweaningweightat45d);
										}
									}
								}
							}
							if($adjweaningweights != []){
								return round(array_sum($adjweaningweights)/count($adjweaningweights), 2);
							}
							else{
								return "No data available";
							}
						}
						elseif($filter == "number weaned"){
							$numberweanedprop = $group->getGroupingProperties()->where("property_id", 57)->first();
							if(!is_null($numberweanedprop)){
								return $numberweanedprop->value;
							}
							else{
								return "No data available";
							}
						}
						elseif($filter == "age weaned"){
							$agesweaned = [];
							$offsprings = $group->getGroupingMembers();
							foreach ($offsprings as $offspring) {
								$offspringproperties = $offspring->getAnimalProperties();
								foreach ($offspringproperties as $offspringproperty) {
									if($offspringproperty->property_id == 6){ //date weaned
										if($offspringproperty->value != "Not specified"){
											$date_weaned = Carbon::parse($offspringproperty->value);
											$bday = $offspring->getAnimalProperties()->where("property_id", 3)->first()->value;
											$age = $date_weaned->diffInDays(Carbon::parse($bday));
											array_push($agesweaned, $age);
										}
									}
								}
							}
							$numberweaned = $group->getGroupingProperties()->where("property_id", 57)->first()->value;
							if($agesweaned != []){
								return round(array_sum($agesweaned)/$numberweaned, 2);
							}
							else{
								return "No data available";
							}
						}
						elseif($filter == "preweaning mortality"){
							$pwmprop = $group->getGroupingProperties()->where("property_id", 59)->first();
							if(!is_null($pwmprop)){
								return round($pwmprop->value, 2);
							}
							else{
								return "No data available";
							}
						}
					}
				}
			}

		}

		public function getSowProductionPerformancePerParityPage($id){
			set_time_limit(5000);
			$group = Grouping::find($id);
			$groupingproperties = $group->getGroupingProperties();

			$adjweaningweights = [];
			$agesweaned = [];
			
			$offsprings = $group->getGroupingMembers();
			foreach ($offsprings as $offspring) {
				$offspringproperties = $offspring->getAnimalProperties();
				foreach ($offspringproperties as $offspringproperty) {
					if($offspringproperty->property_id == 6){ //date weaned
						if($offspringproperty->value != "Not specified"){
							$date_weaned = Carbon::parse($offspringproperty->value);
							$bday = $offspring->getAnimalProperties()->where("property_id", 3)->first()->value;
							$age = $date_weaned->diffInDays(Carbon::parse($bday));
							array_push($agesweaned, $age);
							$weaningweight = $offspring->getAnimalProperties()->where("property_id", 7)->first()->value;
							$adjweaningweightat45d = ($weaningweight*45)/$age;
							array_push($adjweaningweights, $adjweaningweightat45d);
						}
					}
				}
			}
			$numberweaned = $groupingproperties->where("property_id", 57)->first()->value;
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
			

			return view('pigs.sowproductionperformanceperparity', compact('group', 'groupingproperties', 'aveadjweaningweights', 'aveageweaned'));
		}

		public function boarProductionPerfDownloadPDF($id){
			$boar = Animal::find($id);
			$properties = $boar->getAnimalProperties();
			$groups = Grouping::where("father_id", $boar->id)->get();

			$services = [];
			$count = 1;
			$temp = [];
			$successful = [];
			$failed = [];
			$others = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 42){ //date bred
						$date = $groupingproperty->value;
						array_push($temp, $date);
					}
					if($groupingproperty->property_id == 60){ //status
						if($groupingproperty->value == "Farrowed"){
							array_push($successful, $group);
						}
						elseif($groupingproperty->value == "Recycled"){
							array_push($failed, $group);
						}
						else{
							array_push($others, $group);
						}
					}
				}
			}
			$services = array_sort($temp);

			$lsba = [];
			$numbermales = [];
			$numberfemales = [];
			$stillborn = [];
			$mummified = [];
			$litterbirthweights = [];
			$avebirthweights = [];
			$litterweaningweights = [];
			$aveweaningweights = [];
			$adjweaningweights = [];
			$numberweaned = [];
			$agesweaned = [];
			$preweaningmortality = [];
			foreach ($groups as $group) {
				$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
				if(!is_null($lsbaprop)){
					array_push($lsba, $lsbaprop->value);
				}
				$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
				if(!is_null($numbermalesprop)){
					array_push($numbermales, $numbermalesprop->value);
				}
				$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
				if(!is_null($numberfemalesprop)){
					array_push($numberfemales, $numberfemalesprop->value);
				}
				$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
				if(!is_null($stillbornprop)){
					array_push($stillborn, $stillbornprop->value);
				}
				$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
				if(!is_null($mummifiedprop)){
					array_push($mummified, $mummifiedprop->value);
				}
				$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
				if(!is_null($litterbwprop)){
					array_push($litterbirthweights, $litterbwprop->value);
				}
				$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
				if(!is_null($avebwprop)){
					array_push($avebirthweights, $avebwprop->value);
				}
				$litterwwprop = $group->getGroupingProperties()->where("property_id", 62)->first();
				if(!is_null($litterwwprop)){
					array_push($litterweaningweights, $litterwwprop->value);	
				}
				$avewwprop = $group->getGroupingProperties()->where("property_id", 58)->first();
				if(!is_null($avewwprop)){
					array_push($aveweaningweights, $avewwprop->value);
				}
				$numberweanedprop = $group->getGroupingProperties()->where("property_id", 57)->first();
				if(!is_null($numberweanedprop)){
					array_push($numberweaned, $numberweanedprop->value);
				}
				$pwmprop = $group->getGroupingProperties()->where("property_id", 59)->first();
				if(!is_null($pwmprop)){
					array_push($preweaningmortality, $pwmprop->value);
				}
				$thisoffsprings = $group->getGroupingMembers();
				$ageweaned = [];
				$adjweaningweight = [];
				foreach ($thisoffsprings as $thisoffspring) {
					if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
						$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
						$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
							$bday = $bdayprop->value;
						}
						$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
						array_push($ageweaned, $age);
						$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
						if(!is_null($wwprop) && $wwprop->value != ""){
							$adjww = ((float)$wwprop->value*45)/$age;
							array_push($adjweaningweight, $adjww);
						}
					}
				}
				if($ageweaned != []){
					array_push($agesweaned, (array_sum($ageweaned)/count($ageweaned)));
				}
				if($adjweaningweight != []){
					array_push($adjweaningweights, (array_sum($adjweaningweight)/count($adjweaningweight)));
				}
			}

			$now = Carbon::now('Asia/Manila');

			$pdf = PDF::loadView('pigs.boarproductionperfpdf', compact('boar', 'properties', 'services', 'count', 'successful', 'failed', 'others', 'lsba', 'numbermales', 'numberfemales', 'stillborn', 'mummified', 'litterbirthweights', 'avebirthweights', 'litterweaningweights', 'aveweaningweights', 'adjweaningweights', 'numberweaned', 'agesweaned', 'preweaningmortality', 'now'));

			return $pdf->download('boarproductionperf_'.$boar->registryid.'_'.$now.'.pdf');
		}

		public function boarProductionPerfDownloadCSV($id){
			$boar = Animal::find($id);
			$properties = $boar->getAnimalProperties();
			$groups = Grouping::where("father_id", $boar->id)->get();

			$services = [];
			$count = 1;
			$temp = [];
			$successful = [];
			$failed = [];
			$others = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 42){ //date bred
						$date = $groupingproperty->value;
						array_push($temp, $date);
					}
					if($groupingproperty->property_id == 60){ //status
						if($groupingproperty->value == "Farrowed"){
							array_push($successful, $group);
						}
						elseif($groupingproperty->value == "Recycled"){
							array_push($failed, $group);
						}
						else{
							array_push($others, $group);
						}
					}
				}
			}
			$services = array_sort($temp);

			$lsba = [];
			$numbermales = [];
			$numberfemales = [];
			$stillborn = [];
			$mummified = [];
			$litterbirthweights = [];
			$avebirthweights = [];
			$litterweaningweights = [];
			$aveweaningweights = [];
			$adjweaningweights = [];
			$numberweaned = [];
			$agesweaned = [];
			$preweaningmortality = [];
			foreach ($groups as $group) {
				$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
				if(!is_null($lsbaprop)){
					array_push($lsba, $lsbaprop->value);
				}
				$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
				if(!is_null($numbermalesprop)){
					array_push($numbermales, $numbermalesprop->value);
				}
				$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
				if(!is_null($numberfemalesprop)){
					array_push($numberfemales, $numberfemalesprop->value);
				}
				$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
				if(!is_null($stillbornprop)){
					array_push($stillborn, $stillbornprop->value);
				}
				$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
				if(!is_null($mummifiedprop)){
					array_push($mummified, $mummifiedprop->value);
				}
				$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
				if(!is_null($litterbwprop)){
					array_push($litterbirthweights, $litterbwprop->value);
				}
				$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
				if(!is_null($avebwprop)){
					array_push($avebirthweights, $avebwprop->value);
				}
				$litterwwprop = $group->getGroupingProperties()->where("property_id", 62)->first();
				if(!is_null($litterwwprop)){
					array_push($litterweaningweights, $litterwwprop->value);	
				}
				$avewwprop = $group->getGroupingProperties()->where("property_id", 58)->first();
				if(!is_null($avewwprop)){
					array_push($aveweaningweights, $avewwprop->value);
				}
				$numberweanedprop = $group->getGroupingProperties()->where("property_id", 57)->first();
				if(!is_null($numberweanedprop)){
					array_push($numberweaned, $numberweanedprop->value);
				}
				$pwmprop = $group->getGroupingProperties()->where("property_id", 59)->first();
				if(!is_null($pwmprop)){
					array_push($preweaningmortality, $pwmprop->value);
				}
				$thisoffsprings = $group->getGroupingMembers();
				$ageweaned = [];
				$adjweaningweight = [];
				foreach ($thisoffsprings as $thisoffspring) {
					if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
						$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
						$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
							$bday = $bdayprop->value;
						}
						$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
						array_push($ageweaned, $age);
						$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
						if(!is_null($wwprop) && $wwprop->value != ""){
							$adjww = ((float)$wwprop->value*45)/$age;
							array_push($adjweaningweight, $adjww);
						}
					}
				}
				if($ageweaned != []){
					array_push($agesweaned, (array_sum($ageweaned)/count($ageweaned)));
				}
				if($adjweaningweight != []){
					array_push($adjweaningweights, (array_sum($adjweaningweight)/count($adjweaningweight)));
				}
			}

			if($lsba != []){
				$lsba_sd = static::standardDeviation($lsba, false);
			}
			else{
				$lsba_sd = 0;
			}
			if($numbermales != []){
				$numbermales_sd = static::standardDeviation($numbermales, false);
			}
			else{
				$numbermales_sd = 0;
			}
			if($numberfemales != []){
				$numberfemales_sd = static::standardDeviation($numberfemales, false);
			}
			else{
				$numberfemales_sd = 0;
			}
			if($stillborn != []){
				$stillborn_sd = static::standardDeviation($stillborn, false);
			}
			else{
				$stillborn_sd = 0;
			}
			if($mummified != []){
				$mummified_sd = static::standardDeviation($mummified, false);
			}
			else{
				$mummified_sd = 0;
			}
			if($litterbirthweights != []){
				$litterbirthweights_sd = static::standardDeviation($litterbirthweights, false);
			}
			else{
				$litterbirthweights_sd = 0;
			}
			if($avebirthweights != []){
				$avebirthweights_sd = static::standardDeviation($avebirthweights, false);
			}
			else{
				$avebirthweights_sd = 0;
			}
			if($litterweaningweights != []){
				$litterweaningweights_sd = static::standardDeviation($litterweaningweights, false);
			}
			else{
				$litterweaningweights_sd = 0;
			}
			if($aveweaningweights != []){
				$aveweaningweights_sd = static::standardDeviation($aveweaningweights, false);
			}
			else{
				$aveweaningweights_sd = 0;
			}
			if($adjweaningweights != []){
				$adjweaningweights_sd = static::standardDeviation($adjweaningweights, false);
			}
			else{
				$adjweaningweights_sd = 0;
			}
			if($numberweaned != []){
				$numberweaned_sd = static::standardDeviation($numberweaned, false);
			}
			else{
				$numberweaned_sd = 0;
			}
			if($agesweaned != []){
				$agesweaned_sd = static::standardDeviation($agesweaned, false);
			}
			else{
				$agesweaned_sd = 0;
			}
			if($preweaningmortality != []){
				$preweaningmortality_sd = static::standardDeviation($preweaningmortality, false);
			}
			else{
				$preweaningmortality_sd = 0;
			}

			$now = Carbon::now('Asia/Manila');

			return Excel::create('boarproductionperf_'.$boar->registryid.'_'.$now, function($excel) use ($boar, $properties, $groups, $services, $count, $successful, $failed, $others, $lsba, $numbermales, $numberfemales, $stillborn, $mummified, $litterbirthweights, $avebirthweights, $litterweaningweights, $aveweaningweights, $adjweaningweights, $numberweaned, $agesweaned, $preweaningmortality, $lsba_sd, $numbermales_sd, $numberfemales_sd, $stillborn_sd, $mummified_sd, $litterbirthweights_sd, $avebirthweights_sd, $litterweaningweights_sd, $aveweaningweights_sd, $adjweaningweights_sd, $numberweaned_sd, $agesweaned_sd, $preweaningmortality_sd, $now) {
				$excel->sheet('productionperformance', function($sheet) use ($boar, $properties, $groups, $services, $count, $successful, $failed, $others, $lsba, $numbermales, $numberfemales, $stillborn, $mummified, $litterbirthweights, $avebirthweights, $litterweaningweights, $aveweaningweights, $adjweaningweights, $numberweaned, $agesweaned, $preweaningmortality, $lsba_sd, $numbermales_sd, $numberfemales_sd, $stillborn_sd, $mummified_sd, $litterbirthweights_sd, $avebirthweights_sd, $litterweaningweights_sd, $aveweaningweights_sd, $adjweaningweights_sd, $numberweaned_sd, $agesweaned_sd, $preweaningmortality_sd, $now) {
					$sheet->setOrientation('landscape');
					$sheet->row(1, array(
						$boar->registryid
					));
					$sheet->row(2, array(
						'Boar Card'
					));
					$sheet->row(3, array(
						'Service', 'Sow Used', 'Date Bred', 'Status'
					));
					$i = 4;
					foreach ($services as $service) {
						if(FarmController::getGroupingPerService($boar->id, $service, "Status") == "Farrowed"){
							$sheet->row($i, array(
								$count++, FarmController::getGroupingPerService($boar->id, $service, "Sow Used"), Carbon::parse($service)->format('F j, Y'), 'Successful'
							));
						}
						elseif(FarmController::getGroupingPerService($boar->id, $service, "Status") == "Recycled"){
							$sheet->row($i, array(
								$count++, FarmController::getGroupingPerService($boar->id, $service, "Sow Used"), Carbon::parse($service)->format('F j, Y'), 'Failed'
							));
						}
						else{
							$sheet->row($i, array(
								$count++, FarmController::getGroupingPerService($boar->id, $service, "Sow Used"), Carbon::parse($service)->format('F j, Y'), FarmController::getGroupingPerService($boar->id, $service, "Status")
							));
						}
						$i++;
					}
					$sheet->row($i, array(
						' '
					));
					$i++;
					$sheet->row($i, array(
						'Reproductive Performance'
					));
					$i++;
					$sheet->row($i, array(
						'Total number of services: '.count($services), "----->", 'Successful: '.count($successful), 'Failed: '.count($failed), 'Others: '.count($others)
					));
					$i++;
					$sheet->row($i, array(
						'Parameters (Averages)', 'Value', 'Standard Deviation'
					));
					$i++;
					if($lsba != []){
						$sheet->row($i, array(
							'Litter-size Born Alive', round(array_sum($lsba)/count($lsba), 2), round($lsba_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Litter-size Born Alive', 'No data available', 'No data available'
						));
						$i++;
					}
					if($numbermales != []){
						$sheet->row($i, array(
							'Number Male Born', round(array_sum($numbermales)/count($numbermales), 2), round($numbermales_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Number Male Born', 'No data available', 'No data available'
						));
						$i++;
					}
					if($numberfemales != []){
						$sheet->row($i, array(
							'Number Female Born', round(array_sum($numberfemales)/count($numberfemales), 2), round($numberfemales_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Number Female Born', 'No data available', 'No data available'
						));
						$i++;
					}
					if($stillborn != []){
						$sheet->row($i, array(
							'Number Stillborn', round(array_sum($stillborn)/count($stillborn), 2), round($stillborn_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Number Stillborn', 'No data available', 'No data available'
						));
						$i++;
					}
					if($mummified != []){
						$sheet->row($i, array(
							'Number Mummified', round(array_sum($mummified)/count($mummified), 2), round($mummified_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Number Mummified', 'No data available', 'No data available'
						));
						$i++;
					}
					if($litterbirthweights != []){
						$sheet->row($i, array(
							'Litter Birth Weight, kg', round(array_sum($litterbirthweights)/count($litterbirthweights), 2), round($litterbirthweights_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Litter Birth Weight, kg', 'No data available', 'No data available'
						));
						$i++;
					}
					if($avebirthweights != []){
						$sheet->row($i, array(
							'Average Birth Weight, kg', round(array_sum($avebirthweights)/count($avebirthweights), 2), round($avebirthweights_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Average Birth Weight, kg', 'No data available', 'No data available'
						));
						$i++;
					}
					if($litterweaningweights != []){
						$sheet->row($i, array(
							'Litter Weaning Weight, kg', round(array_sum($litterweaningweights)/count($litterweaningweights), 2), round($litterweaningweights_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Litter Weaning Weight, kg', 'No data available', 'No data available'
						));
						$i++;
					}
					if($aveweaningweights != []){
						$sheet->row($i, array(
							'Average Weaning Weight, kg', round(array_sum($aveweaningweights)/count($aveweaningweights), 2), round($aveweaningweights_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Average Weaning Weight, kg', 'No data available', 'No data available'
						));
						$i++;
					}
					if($adjweaningweights != []){
						$sheet->row($i, array(
							'Adjusted Weaning Weight at 45 Days, kg', round(array_sum($adjweaningweights)/count($adjweaningweights), 2), round($adjweaningweights_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Adjusted Weaning Weight at 45 Days, kg', 'No data available', 'No data available'
						));
						$i++;
					}
					if($numberweaned != []){
						$sheet->row($i, array(
							'Number Weaned', round(array_sum($numberweaned)/count($numberweaned), 2), round($numberweaned_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Number Weaned', 'No data available', 'No data available'
						));
						$i++;
					}
					if($agesweaned != []){
						$sheet->row($i, array(
							'Age Weaned, days', round(array_sum($agesweaned)/count($agesweaned), 2), round($agesweaned_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Age Weaned, days', 'No data available', 'No data available'
						));
						$i++;
					}
					if($preweaningmortality != []){
						$sheet->row($i, array(
							'Pre-weaning Mortality, %', round(array_sum($preweaningmortality)/count($preweaningmortality), 2), round($preweaningmortality_sd, 2)
						));
						$i++;
					}
					else{
						$sheet->row($i, array(
							'Pre-weaning Mortality, %', 'No data available', 'No data available'
						));
						$i++;
					}
				});
			})->download('csv');
		}

		public function getBoarProductionPerformancePage($id){ // function to display Boar Production Performance page
			set_time_limit(5000);
			$boar = Animal::find($id);
			$properties = $boar->getAnimalProperties();
			$groups = Grouping::where("father_id", $boar->id)->get();

			$services = [];
			$count = 1;
			$temp = [];
			$successful = [];
			$failed = [];
			$others = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 42){ //date bred
						$date = $groupingproperty->value;
						array_push($temp, $date);
					}
					if($groupingproperty->property_id == 60){ //status
						if($groupingproperty->value == "Farrowed"){
							array_push($successful, $group);
						}
						elseif($groupingproperty->value == "Recycled"){
							array_push($failed, $group);
						}
						else{
							array_push($others, $group);
						}
					}
				}
			}
			$services = array_sort($temp);

			$lsba = [];
			$numbermales = [];
			$numberfemales = [];
			$stillborn = [];
			$mummified = [];
			$litterbirthweights = [];
			$avebirthweights = [];
			$litterweaningweights = [];
			$aveweaningweights = [];
			$adjweaningweights = [];
			$numberweaned = [];
			$agesweaned = [];
			$preweaningmortality = [];
			foreach ($groups as $group) {
				$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
				if(!is_null($lsbaprop)){
					array_push($lsba, $lsbaprop->value);
				}
				$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
				if(!is_null($numbermalesprop)){
					array_push($numbermales, $numbermalesprop->value);
				}
				$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
				if(!is_null($numberfemalesprop)){
					array_push($numberfemales, $numberfemalesprop->value);
				}
				$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
				if(!is_null($stillbornprop)){
					array_push($stillborn, $stillbornprop->value);
				}
				$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
				if(!is_null($mummifiedprop)){
					array_push($mummified, $mummifiedprop->value);
				}
				$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
				if(!is_null($litterbwprop)){
					array_push($litterbirthweights, $litterbwprop->value);
				}
				$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
				if(!is_null($avebwprop)){
					array_push($avebirthweights, $avebwprop->value);
				}
				$litterwwprop = $group->getGroupingProperties()->where("property_id", 62)->first();
				if(!is_null($litterwwprop)){
					array_push($litterweaningweights, $litterwwprop->value);	
				}
				$avewwprop = $group->getGroupingProperties()->where("property_id", 58)->first();
				if(!is_null($avewwprop)){
					array_push($aveweaningweights, $avewwprop->value);
				}
				$numberweanedprop = $group->getGroupingProperties()->where("property_id", 57)->first();
				if(!is_null($numberweanedprop)){
					array_push($numberweaned, $numberweanedprop->value);
				}
				$pwmprop = $group->getGroupingProperties()->where("property_id", 59)->first();
				if(!is_null($pwmprop)){
					array_push($preweaningmortality, $pwmprop->value);
				}
				$thisoffsprings = $group->getGroupingMembers();
				$ageweaned = [];
				$adjweaningweight = [];
				foreach ($thisoffsprings as $thisoffspring) {
					if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
						$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
						$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
							$bday = $bdayprop->value;
						}
						$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
						array_push($ageweaned, $age);
						$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
						if(!is_null($wwprop) && $wwprop->value != ""){
							$adjww = ((float)$wwprop->value*45)/$age;
							array_push($adjweaningweight, $adjww);
						}
					}
				}
				if($ageweaned != []){
					array_push($agesweaned, (array_sum($ageweaned)/count($ageweaned)));
				}
				if($adjweaningweight != []){
					array_push($adjweaningweights, (array_sum($adjweaningweight)/count($adjweaningweight)));
				}
			}


			return view('pigs.boarproductionperformance', compact('boar', 'properties', 'services', 'count', 'successful', 'failed', 'others', 'lsba', 'numbermales', 'numberfemales', 'stillborn', 'mummified', 'litterbirthweights', 'avebirthweights', 'litterweaningweights', 'aveweaningweights', 'adjweaningweights', 'numberweaned', 'agesweaned', 'preweaningmortality'));
		}

		static function getGroupingPerService($boar_id, $service, $filter){
			$groups = Grouping::where("father_id", $boar_id)->get();

			foreach ($groups as $group) {
				$properties = $group->getGroupingProperties();
				foreach ($properties as $property) {
					if($property->property_id == 42){ //date bred
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
				return $groupperservice->getGroupingProperties()->where("property_id", 60)->first()->value;
			}
		}

		public function cumulativeDownloadPDF($filter){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			// default filter is the current year
			$now = Carbon::now('Asia/Manila');
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			// $filter = $now->year;

			//gets all the last days of the month
			$dates = [];
			foreach ($months as $month) {
				$date = new Carbon('last day of '.$month.' '.$filter);
				array_push($dates, $date);
			}

			//gets all the months that are finished
			$headings = [];
			foreach ($dates as $date) {
				if($now->gte($date)){
					// $month = $date->month;
					array_push($headings, $date);
				}
			}

			$monthlyperformances = [];
			$datesfarrowed = [];
			foreach ($headings as $heading) {
				$lsba = [];
				$numbermales = [];
				$numberfemales = [];
				$stillborn = [];
				$mummified = [];
				$litterbirthweights = [];
				$avebirthweights = [];
				$litterweaningweights = [];
				$aveweaningweights = [];
				$adjweaningweights = [];
				$numberweaned = [];
				$agesweaned = [];
				$preweaningmortality = [];
				foreach ($groups as $group) {
					$datefarrowedprop = $group->getGroupingProperties()->where("property_id", 3)->first();
					if(!is_null($datefarrowedprop) && $datefarrowedprop->value != "Not specified"){
						$datefarrowed = Carbon::parse($datefarrowedprop->value);
						if($datefarrowed->format('F') == $heading->format('F') && $datefarrowed->year == $filter){
							array_push($datesfarrowed, $datefarrowed);
							$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
							if(!is_null($lsbaprop)){
								array_push($lsba, $lsbaprop->value);
							}
							$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
							if(!is_null($numbermalesprop)){
								array_push($numbermales, $numbermalesprop->value);
							}
							$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
							if(!is_null($numberfemalesprop)){
								array_push($numberfemales, $numberfemalesprop->value);
							}
							$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
							if(!is_null($stillbornprop)){
								array_push($stillborn, $stillbornprop->value);
							}
							$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
							if(!is_null($mummifiedprop)){
								array_push($mummified, $mummifiedprop->value);
							}
							$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
							if(!is_null($litterbwprop)){
								array_push($litterbirthweights, $litterbwprop->value);
							}
							$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
							if(!is_null($avebwprop)){
								array_push($avebirthweights, $avebwprop->value);
							}
							$litterwwprop = $group->getGroupingProperties()->where("property_id", 62)->first();
							if(!is_null($litterwwprop)){
								array_push($litterweaningweights, $litterwwprop->value);	
							}
							$avewwprop = $group->getGroupingProperties()->where("property_id", 58)->first();
							if(!is_null($avewwprop)){
								array_push($aveweaningweights, $avewwprop->value);
							}
							$numberweanedprop = $group->getGroupingProperties()->where("property_id", 57)->first();
							if(!is_null($numberweanedprop)){
								array_push($numberweaned, $numberweanedprop->value);
							}
							$pwmprop = $group->getGroupingProperties()->where("property_id", 59)->first();
							if(!is_null($pwmprop)){
								array_push($preweaningmortality, $pwmprop->value);
							}
							$thisoffsprings = $group->getGroupingMembers();
							$ageweaned = [];
							$adjweaningweight = [];
							foreach ($thisoffsprings as $thisoffspring) {
								if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
									$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
									$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
									if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
										$bday = $bdayprop->value;
									}
									$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
									array_push($ageweaned, $age);
									$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
									if(!is_null($wwprop) && $wwprop->value != ""){
										$adjww = ((float)$wwprop->value*45)/$age;
										array_push($adjweaningweight, $adjww);
									}
								}
							}
							if($ageweaned != []){
								array_push($agesweaned, (array_sum($ageweaned)/count($ageweaned)));
							}
							if($adjweaningweight != []){
								array_push($adjweaningweights, (array_sum($adjweaningweight)/count($adjweaningweight)));
							}
							$monthlyperformances[$datefarrowed->month -1] = [$lsba, $numbermales, $numberfemales, $stillborn, $mummified, $litterbirthweights, $avebirthweights, $litterweaningweights, $aveweaningweights, $adjweaningweights, $numberweaned, $agesweaned, $preweaningmortality];
						}
					}
				}
			}
			// dd($datesfarrowed, $monthlyperformances);

			$all_lsba = [];
			$all_numbermales = [];
			$all_numberfemales = [];
			$all_stillborn = [];
			$all_mummified = [];
			$all_litterbirthweights = [];
			$all_avebirthweights = [];
			$all_litterweaningweights = [];
			$all_aveweaningweights = [];
			$all_adjweaningweights = [];
			$all_numberweaned = [];
			$all_agesweaned = [];
			$all_preweaningmortality = [];
			foreach ($monthlyperformances as $monthlyperformance) {
				if($monthlyperformance[0] != []){
					array_push($all_lsba, array_sum($monthlyperformance[0])/count($monthlyperformance[0]));
				}
				else{
					array_push($all_lsba, 0);
				}
				if($monthlyperformance[1] != []){
					array_push($all_numbermales, array_sum($monthlyperformance[1])/count($monthlyperformance[1]));
				}
				else{
					array_push($all_numbermales, 0);
				}
				if($monthlyperformance[2] != []){
					array_push($all_numberfemales, array_sum($monthlyperformance[2])/count($monthlyperformance[2]));
				}
				else{
					array_push($all_numberfemales, 0);
				}
				if($monthlyperformance[3] != []){
					array_push($all_stillborn, array_sum($monthlyperformance[3])/count($monthlyperformance[3]));
				}
				else{
					array_push($all_stillborn, 0);
				}
				if($monthlyperformance[4] != []){
					array_push($all_mummified, array_sum($monthlyperformance[4])/count($monthlyperformance[4]));
				}
				else{
					array_push($all_mummified, 0);
				}
				if($monthlyperformance[5] != []){
					array_push($all_litterbirthweights, array_sum($monthlyperformance[5])/count($monthlyperformance[5]));
				}
				else{
					array_push($all_litterbirthweights, 0);
				}
				if($monthlyperformance[6] != []){
					array_push($all_avebirthweights, array_sum($monthlyperformance[6])/count($monthlyperformance[6]));
				}
				else{
					array_push($all_avebirthweights, 0);
				}
				if($monthlyperformance[7] != []){
					array_push($all_litterweaningweights, array_sum($monthlyperformance[7])/count($monthlyperformance[7]));
				}
				else{
					array_push($all_litterweaningweights, 0);
				}
				if($monthlyperformance[8] != []){
					array_push($all_aveweaningweights, array_sum($monthlyperformance[8])/count($monthlyperformance[8]));
				}
				else{
					array_push($all_aveweaningweights, 0);
				}
				if($monthlyperformance[9] != []){
					array_push($all_adjweaningweights, array_sum($monthlyperformance[9])/count($monthlyperformance[9]));
				}
				else{
					array_push($all_adjweaningweights, 0);
				}
				if($monthlyperformance[10] != []){
					array_push($all_numberweaned, array_sum($monthlyperformance[10])/count($monthlyperformance[10]));
				}
				else{
					array_push($all_numberweaned, 0);
				}
				if($monthlyperformance[11] != []){
					array_push($all_agesweaned, array_sum($monthlyperformance[11])/count($monthlyperformance[11]));
				}
				else{
					array_push($all_agesweaned, 0);
				}
				if($monthlyperformance[12] != []){
					array_push($all_preweaningmortality, array_sum($monthlyperformance[12])/count($monthlyperformance[12]));
				}
				else{
					array_push($all_preweaningmortality, 0);
				}
			}


			$pdf = PDF::loadView('pigs.cumulativepdf', compact('months', 'now', 'years', 'filter', 'dates', 'headings', 'monthlyperformances', 'all_lsba', 'all_numbermales', 'all_numberfemales', 'all_stillborn', 'all_mummified', 'all_litterbirthweights', 'all_avebirthweights', 'all_litterweaningweights', 'all_aveweaningweights', 'all_adjweaningweights', 'all_numberweaned','all_agesweaned', 'all_preweaningmortality'))->setPaper('a4', 'landscape');

			return $pdf->download('cumulative_'.$filter.'_'.$now.'.pdf');

		}

		public function getCumulativeReportPage($filter){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			// default filter is the current year
			$now = Carbon::now('Asia/Manila');
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			// $filter = $now->year;

			//gets all the last days of the month
			$dates = [];
			foreach ($months as $month) {
				$date = new Carbon('last day of '.$month.' '.$filter);
				array_push($dates, $date);
			}

			//gets all the months that are finished
			$headings = [];
			foreach ($dates as $date) {
				if($now->gte($date)){
					// $month = $date->month;
					array_push($headings, $date);
				}
			}

			$monthlyperformances = [];
			$datesfarrowed = [];
			foreach ($headings as $heading) {
				$lsba = [];
				$numbermales = [];
				$numberfemales = [];
				$stillborn = [];
				$mummified = [];
				$litterbirthweights = [];
				$avebirthweights = [];
				$litterweaningweights = [];
				$aveweaningweights = [];
				$adjweaningweights = [];
				$numberweaned = [];
				$agesweaned = [];
				$preweaningmortality = [];
				foreach ($groups as $group) {
					$datefarrowedprop = $group->getGroupingProperties()->where("property_id", 3)->first();
					if(!is_null($datefarrowedprop) && $datefarrowedprop->value != "Not specified"){
						$datefarrowed = Carbon::parse($datefarrowedprop->value);
						if($datefarrowed->format('F') == $heading->format('F') && $datefarrowed->year == $filter){
							array_push($datesfarrowed, $datefarrowed);
							$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
							if(!is_null($lsbaprop)){
								array_push($lsba, $lsbaprop->value);
							}
							$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
							if(!is_null($numbermalesprop)){
								array_push($numbermales, $numbermalesprop->value);
							}
							$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
							if(!is_null($numberfemalesprop)){
								array_push($numberfemales, $numberfemalesprop->value);
							}
							$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
							if(!is_null($stillbornprop)){
								array_push($stillborn, $stillbornprop->value);
							}
							$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
							if(!is_null($mummifiedprop)){
								array_push($mummified, $mummifiedprop->value);
							}
							$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
							if(!is_null($litterbwprop)){
								array_push($litterbirthweights, $litterbwprop->value);
							}
							$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
							if(!is_null($avebwprop)){
								array_push($avebirthweights, $avebwprop->value);
							}
							$litterwwprop = $group->getGroupingProperties()->where("property_id", 62)->first();
							if(!is_null($litterwwprop)){
								array_push($litterweaningweights, $litterwwprop->value);	
							}
							$avewwprop = $group->getGroupingProperties()->where("property_id", 58)->first();
							if(!is_null($avewwprop)){
								array_push($aveweaningweights, $avewwprop->value);
							}
							$numberweanedprop = $group->getGroupingProperties()->where("property_id", 57)->first();
							if(!is_null($numberweanedprop)){
								array_push($numberweaned, $numberweanedprop->value);
							}
							$pwmprop = $group->getGroupingProperties()->where("property_id", 59)->first();
							if(!is_null($pwmprop)){
								array_push($preweaningmortality, $pwmprop->value);
							}
							$thisoffsprings = $group->getGroupingMembers();
							$ageweaned = [];
							$adjweaningweight = [];
							foreach ($thisoffsprings as $thisoffspring) {
								if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
									$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
									$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
									if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
										$bday = $bdayprop->value;
									}
									$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
									array_push($ageweaned, $age);
									$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
									if(!is_null($wwprop) && $wwprop->value != ""){
										$adjww = ((float)$wwprop->value*45)/$age;
										array_push($adjweaningweight, $adjww);
									}
								}
							}
							if($ageweaned != []){
								array_push($agesweaned, (array_sum($ageweaned)/count($ageweaned)));
							}
							if($adjweaningweight != []){
								array_push($adjweaningweights, (array_sum($adjweaningweight)/count($adjweaningweight)));
							}
							$monthlyperformances[$datefarrowed->month -1] = [$lsba, $numbermales, $numberfemales, $stillborn, $mummified, $litterbirthweights, $avebirthweights, $litterweaningweights, $aveweaningweights, $adjweaningweights, $numberweaned, $agesweaned, $preweaningmortality];
						}
					}
				}
			}
			// dd($datesfarrowed, $monthlyperformances);

			$all_lsba = [];
			$all_numbermales = [];
			$all_numberfemales = [];
			$all_stillborn = [];
			$all_mummified = [];
			$all_litterbirthweights = [];
			$all_avebirthweights = [];
			$all_litterweaningweights = [];
			$all_aveweaningweights = [];
			$all_adjweaningweights = [];
			$all_numberweaned = [];
			$all_agesweaned = [];
			$all_preweaningmortality = [];
			foreach ($monthlyperformances as $monthlyperformance) {
				if($monthlyperformance[0] != []){
					array_push($all_lsba, array_sum($monthlyperformance[0])/count($monthlyperformance[0]));
				}
				else{
					array_push($all_lsba, 0);
				}
				if($monthlyperformance[1] != []){
					array_push($all_numbermales, array_sum($monthlyperformance[1])/count($monthlyperformance[1]));
				}
				else{
					array_push($all_numbermales, 0);
				}
				if($monthlyperformance[2] != []){
					array_push($all_numberfemales, array_sum($monthlyperformance[2])/count($monthlyperformance[2]));
				}
				else{
					array_push($all_numberfemales, 0);
				}
				if($monthlyperformance[3] != []){
					array_push($all_stillborn, array_sum($monthlyperformance[3])/count($monthlyperformance[3]));
				}
				else{
					array_push($all_stillborn, 0);
				}
				if($monthlyperformance[4] != []){
					array_push($all_mummified, array_sum($monthlyperformance[4])/count($monthlyperformance[4]));
				}
				else{
					array_push($all_mummified, 0);
				}
				if($monthlyperformance[5] != []){
					array_push($all_litterbirthweights, array_sum($monthlyperformance[5])/count($monthlyperformance[5]));
				}
				else{
					array_push($all_litterbirthweights, 0);
				}
				if($monthlyperformance[6] != []){
					array_push($all_avebirthweights, array_sum($monthlyperformance[6])/count($monthlyperformance[6]));
				}
				else{
					array_push($all_avebirthweights, 0);
				}
				if($monthlyperformance[7] != []){
					array_push($all_litterweaningweights, array_sum($monthlyperformance[7])/count($monthlyperformance[7]));
				}
				else{
					array_push($all_litterweaningweights, 0);
				}
				if($monthlyperformance[8] != []){
					array_push($all_aveweaningweights, array_sum($monthlyperformance[8])/count($monthlyperformance[8]));
				}
				else{
					array_push($all_aveweaningweights, 0);
				}
				if($monthlyperformance[9] != []){
					array_push($all_adjweaningweights, array_sum($monthlyperformance[9])/count($monthlyperformance[9]));
				}
				else{
					array_push($all_adjweaningweights, 0);
				}
				if($monthlyperformance[10] != []){
					array_push($all_numberweaned, array_sum($monthlyperformance[10])/count($monthlyperformance[10]));
				}
				else{
					array_push($all_numberweaned, 0);
				}
				if($monthlyperformance[11] != []){
					array_push($all_agesweaned, array_sum($monthlyperformance[11])/count($monthlyperformance[11]));
				}
				else{
					array_push($all_agesweaned, 0);
				}
				if($monthlyperformance[12] != []){
					array_push($all_preweaningmortality, array_sum($monthlyperformance[12])/count($monthlyperformance[12]));
				}
				else{
					array_push($all_preweaningmortality, 0);
				}
			}
			// dd($monthlyperformances, $all_lsba, $all_numbermales, $all_numberfemales, $all_stillborn, $all_mummified, $all_litterbirthweights, $all_avebirthweights, $all_litterweaningweights, $all_aveweaningweights, $all_adjweaningweights, $all_numberweaned, $all_agesweaned, $all_preweaningmortality);

			return view('pigs.cumulative', compact('months', 'now', 'years', 'filter', 'dates', 'headings', 'monthlyperformances', 'all_lsba', 'all_numbermales', 'all_numberfemales', 'all_stillborn', 'all_mummified', 'all_litterbirthweights', 'all_avebirthweights', 'all_litterweaningweights', 'all_aveweaningweights', 'all_adjweaningweights', 'all_numberweaned','all_agesweaned', 'all_preweaningmortality'));
		}

		public function filterCumulativeReport(Request $request){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
							->whereNotNull("mother_id")
							->where("groupings.breed_id", $breed->id)
							->where("animals.farm_id", $farm->id)
							->get();

			$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			// default filter is the current year
			$now = Carbon::now('Asia/Manila');
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			$filter = $request->year_cumulative_report;

			//gets all the last days of the month
			$dates = [];
			foreach ($months as $month) {
				$date = new Carbon('last day of '.$month.' '.$filter);
				array_push($dates, $date);
			}

			//gets all the months that are finished
			$headings = [];
			foreach ($dates as $date) {
				if($now->gte($date)){
					// $month = $date->month;
					array_push($headings, $date);
				}
			}

			$monthlyperformances = [];
			$datesfarrowed = [];
			foreach ($headings as $heading) {
				$lsba = [];
				$numbermales = [];
				$numberfemales = [];
				$stillborn = [];
				$mummified = [];
				$litterbirthweights = [];
				$avebirthweights = [];
				$litterweaningweights = [];
				$aveweaningweights = [];
				$adjweaningweights = [];
				$numberweaned = [];
				$agesweaned = [];
				$preweaningmortality = [];
				foreach ($groups as $group) {
					$datefarrowedprop = $group->getGroupingProperties()->where("property_id", 3)->first();
					if(!is_null($datefarrowedprop) && $datefarrowedprop->value != "Not specified"){
						$datefarrowed = Carbon::parse($datefarrowedprop->value);
						if($datefarrowed->format('F') == $heading->format('F') && $datefarrowed->year == $filter){
							array_push($datesfarrowed, $datefarrowed);
							$lsbaprop = $group->getGroupingProperties()->where("property_id", 50)->first();
							if(!is_null($lsbaprop)){
								array_push($lsba, $lsbaprop->value);
							}
							$numbermalesprop = $group->getGroupingProperties()->where("property_id", 51)->first();
							if(!is_null($numbermalesprop)){
								array_push($numbermales, $numbermalesprop->value);
							}
							$numberfemalesprop = $group->getGroupingProperties()->where("property_id", 52)->first();
							if(!is_null($numberfemalesprop)){
								array_push($numberfemales, $numberfemalesprop->value);
							}
							$stillbornprop = $group->getGroupingProperties()->where("property_id", 45)->first();
							if(!is_null($stillbornprop)){
								array_push($stillborn, $stillbornprop->value);
							}
							$mummifiedprop = $group->getGroupingProperties()->where("property_id", 46)->first();
							if(!is_null($mummifiedprop)){
								array_push($mummified, $mummifiedprop->value);
							}
							$litterbwprop = $group->getGroupingProperties()->where("property_id", 55)->first();
							if(!is_null($litterbwprop)){
								array_push($litterbirthweights, $litterbwprop->value);
							}
							$avebwprop = $group->getGroupingProperties()->where("property_id", 56)->first();
							if(!is_null($avebwprop)){
								array_push($avebirthweights, $avebwprop->value);
							}
							$litterwwprop = $group->getGroupingProperties()->where("property_id", 62)->first();
							if(!is_null($litterwwprop)){
								array_push($litterweaningweights, $litterwwprop->value);	
							}
							$avewwprop = $group->getGroupingProperties()->where("property_id", 58)->first();
							if(!is_null($avewwprop)){
								array_push($aveweaningweights, $avewwprop->value);
							}
							$numberweanedprop = $group->getGroupingProperties()->where("property_id", 57)->first();
							if(!is_null($numberweanedprop)){
								array_push($numberweaned, $numberweanedprop->value);
							}
							$pwmprop = $group->getGroupingProperties()->where("property_id", 59)->first();
							if(!is_null($pwmprop)){
								array_push($preweaningmortality, $pwmprop->value);
							}
							$thisoffsprings = $group->getGroupingMembers();
							$ageweaned = [];
							$adjweaningweight = [];
							foreach ($thisoffsprings as $thisoffspring) {
								if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first()) && $thisoffspring->getAnimalProperties()->where("property_id", 6)->first()->value != "Not specified"){
									$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
									$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
									if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
										$bday = $bdayprop->value;
									}
									$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
									array_push($ageweaned, $age);
									$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
									if(!is_null($wwprop) && $wwprop->value != ""){
										$adjww = ((float)$wwprop->value*45)/$age;
										array_push($adjweaningweight, $adjww);
									}
								}
							}
							if($ageweaned != []){
								array_push($agesweaned, (array_sum($ageweaned)/count($ageweaned)));
							}
							if($adjweaningweight != []){
								array_push($adjweaningweights, (array_sum($adjweaningweight)/count($adjweaningweight)));
							}
							$monthlyperformances[$datefarrowed->month -1] = [$lsba, $numbermales, $numberfemales, $stillborn, $mummified, $litterbirthweights, $avebirthweights, $litterweaningweights, $aveweaningweights, $adjweaningweights, $numberweaned, $agesweaned, $preweaningmortality];
						}
					}
				}
			}
			// dd($datesfarrowed, $monthlyperformances);

			$all_lsba = [];
			$all_numbermales = [];
			$all_numberfemales = [];
			$all_stillborn = [];
			$all_mummified = [];
			$all_litterbirthweights = [];
			$all_avebirthweights = [];
			$all_litterweaningweights = [];
			$all_aveweaningweights = [];
			$all_adjweaningweights = [];
			$all_numberweaned = [];
			$all_agesweaned = [];
			$all_preweaningmortality = [];
			foreach ($monthlyperformances as $monthlyperformance) {
				if($monthlyperformance[0] != []){
					array_push($all_lsba, array_sum($monthlyperformance[0])/count($monthlyperformance[0]));
				}
				else{
					array_push($all_lsba, 0);
				}
				if($monthlyperformance[1] != []){
					array_push($all_numbermales, array_sum($monthlyperformance[1])/count($monthlyperformance[1]));
				}
				else{
					array_push($all_numbermales, 0);
				}
				if($monthlyperformance[2] != []){
					array_push($all_numberfemales, array_sum($monthlyperformance[2])/count($monthlyperformance[2]));
				}
				else{
					array_push($all_numberfemales, 0);
				}
				if($monthlyperformance[3] != []){
					array_push($all_stillborn, array_sum($monthlyperformance[3])/count($monthlyperformance[3]));
				}
				else{
					array_push($all_stillborn, 0);
				}
				if($monthlyperformance[4] != []){
					array_push($all_mummified, array_sum($monthlyperformance[4])/count($monthlyperformance[4]));
				}
				else{
					array_push($all_mummified, 0);
				}
				if($monthlyperformance[5] != []){
					array_push($all_litterbirthweights, array_sum($monthlyperformance[5])/count($monthlyperformance[5]));
				}
				else{
					array_push($all_litterbirthweights, 0);
				}
				if($monthlyperformance[6] != []){
					array_push($all_avebirthweights, array_sum($monthlyperformance[6])/count($monthlyperformance[6]));
				}
				else{
					array_push($all_avebirthweights, 0);
				}
				if($monthlyperformance[7] != []){
					array_push($all_litterweaningweights, array_sum($monthlyperformance[7])/count($monthlyperformance[7]));
				}
				else{
					array_push($all_litterweaningweights, 0);
				}
				if($monthlyperformance[8] != []){
					array_push($all_aveweaningweights, array_sum($monthlyperformance[8])/count($monthlyperformance[8]));
				}
				else{
					array_push($all_aveweaningweights, 0);
				}
				if($monthlyperformance[9] != []){
					array_push($all_adjweaningweights, array_sum($monthlyperformance[9])/count($monthlyperformance[9]));
				}
				else{
					array_push($all_adjweaningweights, 0);
				}
				if($monthlyperformance[10] != []){
					array_push($all_numberweaned, array_sum($monthlyperformance[10])/count($monthlyperformance[10]));
				}
				else{
					array_push($all_numberweaned, 0);
				}
				if($monthlyperformance[11] != []){
					array_push($all_agesweaned, array_sum($monthlyperformance[11])/count($monthlyperformance[11]));
				}
				else{
					array_push($all_agesweaned, 0);
				}
				if($monthlyperformance[12] != []){
					array_push($all_preweaningmortality, array_sum($monthlyperformance[12])/count($monthlyperformance[12]));
				}
				else{
					array_push($all_preweaningmortality, 0);
				}
			}
			// dd($monthlyperformances, $all_lsba, $all_numbermales, $all_numberfemales, $all_stillborn, $all_mummified, $all_litterbirthweights, $all_avebirthweights, $all_litterweaningweights, $all_aveweaningweights, $all_adjweaningweights, $all_numberweaned, $all_agesweaned, $all_preweaningmortality);

			return view('pigs.cumulative', compact('months', 'now', 'years', 'filter', 'dates', 'headings', 'monthlyperformances', 'all_lsba', 'all_numbermales', 'all_numberfemales', 'all_stillborn', 'all_mummified', 'all_litterbirthweights', 'all_avebirthweights', 'all_litterweaningweights', 'all_aveweaningweights', 'all_adjweaningweights', 'all_numberweaned','all_agesweaned', 'all_preweaningmortality'));
		}

		public function monthlyPerfDownloadPDF($filter){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			// default filter is the current year
			$now = Carbon::now('Asia/Manila');
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			$pdf = PDF::loadView('pigs.monthlypdf', compact('months', 'now', 'years', 'filter'));

			return $pdf->download('monthlyperformance_'.$filter.'_'.$now.'.pdf');
		}

		public function getMonthlyPerformanceReportPage($filter){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			// default filter is the current year
			$now = Carbon::now('Asia/Manila');
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			// $filter = $now->year;

			return view('pigs.monthlyperformance', compact('months', 'now', 'years', 'filter'));
		}

		public function filterMonthlyPerformance(Request $request){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			// default filter is the current year
			$filter = $request->year_monthly_performance;

			$now = Carbon::now('Asia/Manila');
			$current_year = $filter;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			return view('pigs.monthlyperformance', compact('months', 'now', 'years', 'filter'));
		}

		static function getMonthlyBred($filter, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$count = 0;
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 42){ //date bred
						if(!is_null($groupingproperty) && $groupingproperty->value != "Not specified"){
							$datebred = Carbon::parse($groupingproperty->value);
							if($datebred->year == $filter && $datebred->format('F') == $month){
								$count = $count + 1;
							}
						}
					}
				}
			}

			return $count;
		}

		static function getMonthlyFarrowed($filter, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$count = 0;
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 3){ //date farrowed
						if(!is_null($groupingproperty) && $groupingproperty->value != "Not specified"){
							$datefarrowed = Carbon::parse($groupingproperty->value);
							if($datefarrowed->year == $filter && $datefarrowed->format('F') == $month){
								$count = $count + 1;
							}
						}
					}
				}
			}

			return $count;
		}

		static function getMonthlyWeaned($filter, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();
				
			$count = 0;
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 6){ //date weaned
						if(!is_null($groupingproperty) && $groupingproperty->value != "Not specified"){
							$dateweaned = Carbon::parse($groupingproperty->value);
							if($dateweaned->year == $filter && $dateweaned->format('F') == $month){
								$count = $count + 1;
							}
						}
					}
				}
			}

			return $count;
		}

		static function getMonthlyLSBA($filter, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();
				
			$lsbavalues = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 3){ //date farrowed
						if(!is_null($groupingproperty) && $groupingproperty->value != "Not specified"){
							$datefarrowed = Carbon::parse($groupingproperty->value);
							if($datefarrowed->year == $filter && $datefarrowed->format('F') == $month){
								$lsba = $group->getGroupingProperties()->where("property_id", 50)->first();
                                if (empty($lsba)) {
									continue 2;
                                } else {
									array_push($lsbavalues, $lsba->value);
								}
							}
						}
					}
				}
			}

			return array_sum($lsbavalues);
		}

		static function getMonthlyNumberMales($filter, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();
				
			$numbermalesvalues = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 3){ //date farrowed
						if(!is_null($groupingproperty) && $groupingproperty->value != "Not specified"){
							$datefarrowed = Carbon::parse($groupingproperty->value);
							if($datefarrowed->year == $filter && $datefarrowed->format('F') == $month){
								$numbermales = $group->getGroupingProperties()->where("property_id", 51)->first()->value;
								array_push($numbermalesvalues, $numbermales);
							}
						}
					}
				}
			}

			return array_sum($numbermalesvalues);
		}

		static function getMonthlyNumberFemales($filter, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();
				
			$numberfemalesvalue = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 3){ //date farrowed
						if(!is_null($groupingproperty) && $groupingproperty->value != "Not specified"){
							$datefarrowed = Carbon::parse($groupingproperty->value);
							if($datefarrowed->year == $filter && $datefarrowed->format('F') == $month){
								$numberfemales = $group->getGroupingProperties()->where("property_id", 52)->first()->value;
								array_push($numberfemalesvalue, $numberfemales);
							}
						}
					}
				}
			}

			return array_sum($numberfemalesvalue);
		}

		static function getMonthlyAverageBorn($filter, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();
				
			$lsbavalues = [];
			$groupsthismonth = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 3){ //date farrowed
						if(!is_null($groupingproperty) && $groupingproperty->value != "Not specified"){
							$datefarrowed = Carbon::parse($groupingproperty->value);
							if($datefarrowed->year == $filter && $datefarrowed->format('F') == $month){
								$lsba = $group->getGroupingProperties()->where("property_id", 50)->first();
								if (empty($lsba)) {
									continue 2;
                                } else {
									array_push($lsbavalues, $lsba->value);
									array_push($groupsthismonth, $group);
								}
							}
						}
					}
				}
			}

			if(count($groupsthismonth) != 0){
				$averageborn = round(array_sum($lsbavalues)/count($groupsthismonth), 2);
			}
			else{
				$averageborn = 0;
			}

			return $averageborn;
			
		}

		static function getMonthlyNumberWeaned($filter, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();
				
			$numberweanedvalues = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 6){ //date weaned
						if(!is_null($groupingproperty) && $groupingproperty->value != "Not specified"){
							$dateweaned = Carbon::parse($groupingproperty->value);
							if($dateweaned->year == $filter && $dateweaned->format('F') == $month){
								$numberweaned = $group->getGroupingProperties()->where("property_id", 57)->first();
								if (empty($numberweaned)) {
									continue 2;
                                } else {
									array_push($numberweanedvalues, $numberweaned->value);
								}
							}
						}
					}
				}
			}

			return array_sum($numberweanedvalues);
		}

		static function getMonthlyAverageWeaned($filter, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();
				
			$numberweanedvalues = [];
			$groupsthismonth = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 6){ //date weaned
						if(!is_null($groupingproperty) && $groupingproperty->value != "Not specified"){
							$dateweaned = Carbon::parse($groupingproperty->value);
							if($dateweaned->year == $filter && $dateweaned->format('F') == $month){
								$numberweaned = $group->getGroupingProperties()->where("property_id", 57)->first();
								if (empty($numberweaned)) {
									continue 2;
                                } else {
									array_push($groupsthismonth, $group);
									array_push($numberweanedvalues, $numberweaned->value);
								}
							}
						}
					}
				}
			}

			if(count($groupsthismonth) != 0){
				$averageweaned = round(array_sum($numberweanedvalues)/count($groupsthismonth), 2);
			}
			else{
				$averageweaned = 0;
			}

			return $averageweaned;
			
		}

		static function getMonthlyAverageBirthWeight($filter, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();
				
			$avebirthweights = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 3){ //date farrowed
						if(!is_null($groupingproperty) && $groupingproperty->value != "Not specified"){
							$datefarrowed = Carbon::parse($groupingproperty->value);
							if($datefarrowed->year == $filter && $datefarrowed->format('F') == $month){
								$avebirthweight = $group->getGroupingProperties()->where("property_id", 56)->first();
								if (empty($avebirthweight)) {
									continue 2;
                                } else {
									array_push($avebirthweights, $avebirthweight->value);
								}
							}
						}
					}
				}
			}

			if(count($avebirthweights) != 0){
				$averagebirthweight = round(array_sum($avebirthweights)/count($avebirthweights), 2);
			}
			else{
				$averagebirthweight = 0;
			}

			return $averagebirthweight;
		}

		static function getMonthlyAverageWeaningWeight($filter, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();
				
			$aveweaningweights = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 6){ //date weaned
						if(!is_null($groupingproperty) && $groupingproperty->value != "Not specified"){
							$dateweaned = Carbon::parse($groupingproperty->value);
							if($dateweaned->year == $filter && $dateweaned->format('F') == $month){
								$aveweaningweight = $group->getGroupingProperties()->where("property_id", 58)->first();
								if (empty($aveweaningweight)) {
									continue 2;
                                } else {
									array_push($aveweaningweights, $aveweaningweight->value);
								}
							}
						}
					}
				}
			}

			if(count($aveweaningweights) != 0){
				$averageweaningweight = round(array_sum($aveweaningweights)/count($aveweaningweights), 2);
			}
			else{
				$averageweaningweight = 0;
			}

			return $averageweaningweight;
		}

		public function breederInventoryDownloadPDF(){
			set_time_limit(5000);
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$now = Carbon::now('Asia/Manila');

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
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			// BOAR INVENTORY
			
			// sorts male pigs into jr and sr boars
			$jrboars = []; // less than 1 year old
			$srboars = []; // at least 1 year old
			$noage_boars = [];
			$age_boars = [];
			foreach ($boars as $boar) {
				$iproperties = $boar->getAnimalProperties();
				foreach ($iproperties as $iproperty) {
					if($iproperty->property_id == 3){ // date farrowed
						if(!is_null($iproperty->value) && $iproperty->value != "Not specified"){
							$end_date = Carbon::parse($iproperty->value);
							$age = $now->diffInMonths($end_date);
							if($age < 12){
								array_push($jrboars, $boar);
								array_push($age_boars, $age);
							}
							else{
								array_push($srboars, $boar);
								array_push($age_boars, $age);
							}
						}
						else{
							array_push($noage_boars, $boar);
						}
					}
				}
			}

			// SOW INVENTORY
			$breds = [];
			$pregnantsows = [];
			$lactatingsows = [];
			$templactating = [];
			foreach ($groups as $group) {
				$datebredprop = $group->getGroupingProperties()->where("property_id", 42)->first();
				$status = $group->getGroupingProperties()->where("property_id", 60)->first()->value;
				$datefarrowedprop = $group->getGroupingProperties()->where("property_id", 3)->first();
				if(!is_null($datebredprop)){
					$datebred = Carbon::parse($datebredprop->value);
					if($datebred->month == $now->month && $datebred->year == $now->year){
						if($now->gte($datebred)){
							if($status == "Bred"){
								$bred = $group->getMother();
								if($bred->status == "breeder"){
									array_push($breds, $bred);
								}
							}
						}
					}
				}
				if($status == "Pregnant"){
					$pregnant = $group->getMother();
					if($pregnant->status == "breeder"){
						array_push($pregnantsows, $pregnant);
					}
				}
				if(!is_null($datefarrowedprop) && $datefarrowedprop->value != "Not specified"){
					$datefarrowed = Carbon::parse($datefarrowedprop->value);
					if($now->gte($datefarrowed)){
						$dateweanedprop = $group->getGroupingProperties()->where("property_id", 6)->first();
						if(is_null($dateweanedprop)){
							$lactating = $group->getMother();
							if($lactating->status == "breeder"){
								array_push($templactating, $lactating);
							}
						}
					}
				}
			}
			$intersection = array_intersect($pregnantsows, array_unique($templactating));
			$lactatingsows = array_diff(array_unique($templactating), $intersection);
			// dd($breds, $pregnantsows, $lactatingsows);
			
			$bredsows = [];
			$bredgilts = [];
			foreach ($breds as $bred) {
				$parity = $bred->getAnimalProperties()->where("property_id", 48)->first();
				$frequency = $bred->getAnimalProperties()->where("property_id", 61)->first();
				if(!is_null($parity)){
					if($parity->value >= 1 || $frequency->value > 1){
						array_push($bredsows, $bred);
					}
					elseif(($parity->value == 0 && $frequency->value == 1) || $frequency->value == 1){
						array_push($bredgilts, $bred);
					}
				}
				else{
					if($frequency->value == 1){
						array_push($bredgilts, $bred);
					}
				}
			}

			$gilts = [];
			$temp_gilts = [];
			foreach ($sows as $sow) {
				$frequency = $sow->getAnimalProperties()->where("property_id", 61)->first();
				if(!is_null($frequency)){
					if($frequency->value == 0){
						array_push($temp_gilts, $sow);
					}
				}
				else{
					array_push($temp_gilts, $sow);
				}
			}
			$gilts = array_diff($temp_gilts, $bredgilts);


			$noage_sows = [];
			$age_sows = [];
			foreach ($sows as $sow) {
				$iproperties = $sow->getAnimalProperties();
				foreach ($iproperties as $iproperty) {
					if($iproperty->property_id == 3){ // date farrowed
						if(!is_null($iproperty->value) && $iproperty->value != "Not specified"){
							$end_date = Carbon::parse($iproperty->value);
							$age = $now->diffInMonths($end_date);
							array_push($age_sows, $age);
						}
						else{
							array_push($noage_sows, $sow);
						}
					}
				}
			}

			// static::addFrequency();

			$drysows = count($sows) - (count($bredsows) + count($pregnantsows) + count($lactatingsows) + count($gilts) + count($bredgilts));
			
			// gets unique years of age at weaning
			$years = [];
			$tempyears = [];
			foreach ($groups as $group) {
				$properties = $group->getGroupingProperties();
				foreach ($properties as $property) {
					if($property->property_id == 6){ //date weaned
						if(!is_null($property) && $property->value != "Not specified"){
							$year = Carbon::parse($property->value)->year;
							array_push($tempyears, $year);
							$years = array_reverse(array_sort(array_unique($tempyears)));
						}
					}
				}
			}

			$months = ["December", "November", "October", "September", "August", "July", "June", "May", "April", "March", "February", "January"];


			$pdf = PDF::loadView('pigs.breederinventorypdf', compact('pigs', 'sows', 'boars', 'groups', 'frequency', 'breds', 'pregnantsows', 'lactatingsows', 'drysows', 'gilts', 'jrboars', 'srboars', 'now', 'noage_boars', 'years', 'months', 'age_boars', 'age_sows', 'noage_sows', 'bredsows', 'bredgilts'));

			return $pdf->download('breederinventory_'.$now->format('FY').'_'.$now.'.pdf');
		}

		public function getBreederInventoryPage(){ // function to display Breeder Inventory page
			set_time_limit(5000);
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$now = Carbon::now('Asia/Manila');

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
			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			// BOAR INVENTORY
			
			// sorts male pigs into jr and sr boars
			$jrboars = []; // less than 1 year old
			$srboars = []; // at least 1 year old
			$noage_boars = [];
			$age_boars = [];
			foreach ($boars as $boar) {
				$iproperties = $boar->getAnimalProperties();
				foreach ($iproperties as $iproperty) {
					if($iproperty->property_id == 3){ // date farrowed
						if(!is_null($iproperty->value) && $iproperty->value != "Not specified"){
							$end_date = Carbon::parse($iproperty->value);
							$age = $now->diffInMonths($end_date);
							if($age < 12){
								array_push($jrboars, $boar);
								array_push($age_boars, $age);
							}
							else{
								array_push($srboars, $boar);
								array_push($age_boars, $age);
							}
						}
						else{
							array_push($noage_boars, $boar);
						}
					}
				}
			}

			// SOW INVENTORY
			$breds = [];
			$pregnantsows = [];
			$lactatingsows = [];
			$templactating = [];
			foreach ($groups as $group) {
				$datebredprop = $group->getGroupingProperties()->where("property_id", 42)->first();
				$status = $group->getGroupingProperties()->where("property_id", 60)->first()->value;
				$datefarrowedprop = $group->getGroupingProperties()->where("property_id", 3)->first();
				if(!is_null($datebredprop)){
					$datebred = Carbon::parse($datebredprop->value);
					if($datebred->month == $now->month && $datebred->year == $now->year){
						if($now->gte($datebred)){
							if($status == "Bred"){
								$bred = $group->getMother();
								if($bred->status == "breeder"){
									array_push($breds, $bred);
								}
							}
						}
					}
				}
				if($status == "Pregnant"){
					$pregnant = $group->getMother();
					if($pregnant->status == "breeder"){
						array_push($pregnantsows, $pregnant);
					}
				}
				if(!is_null($datefarrowedprop) && $datefarrowedprop->value != "Not specified"){
					$datefarrowed = Carbon::parse($datefarrowedprop->value);
					if($now->gte($datefarrowed)){
						$dateweanedprop = $group->getGroupingProperties()->where("property_id", 6)->first();
						if(is_null($dateweanedprop)){
							$lactating = $group->getMother();
							if($lactating->status == "breeder"){
								array_push($templactating, $lactating);
							}
						}
					}
				}
			}
			$intersection = array_intersect($pregnantsows, array_unique($templactating));
			$lactatingsows = array_diff(array_unique($templactating), $intersection);
			// dd($breds, $pregnantsows, $lactatingsows);

			$bredsows = [];
			$bredgilts = [];
			foreach ($breds as $bred) {
				$parity = $bred->getAnimalProperties()->where("property_id", 48)->first();
				$frequency = $bred->getAnimalProperties()->where("property_id", 61)->first();
				if(!is_null($parity)){
					if($parity->value >= 1 || $frequency->value > 1){
						array_push($bredsows, $bred);
					}
					elseif(($parity->value == 0 && $frequency->value == 1) || $frequency->value == 1){
						array_push($bredgilts, $bred);
					}
				}
				else{
					if($frequency->value == 1){
						array_push($bredgilts, $bred);
					}
				}
			}

			$gilts = [];
			$temp_gilts = [];
			foreach ($sows as $sow) {
				$frequency = $sow->getAnimalProperties()->where("property_id", 61)->first();
				if(!is_null($frequency)){
					if($frequency->value == 0){
						array_push($temp_gilts, $sow);
					}
				}
				else{
					array_push($temp_gilts, $sow);
				}
			}
			$gilts = array_diff($temp_gilts, $bredgilts);


			$noage_sows = [];
			$age_sows = [];
			foreach ($sows as $sow) {
				$iproperties = $sow->getAnimalProperties();
				foreach ($iproperties as $iproperty) {
					if($iproperty->property_id == 3){ // date farrowed
						if(!is_null($iproperty->value) && $iproperty->value != "Not specified"){
							$end_date = Carbon::parse($iproperty->value);
							$age = $now->diffInMonths($end_date);
							array_push($age_sows, $age);
						}
						else{
							array_push($noage_sows, $sow);
						}
					}
				}
			}

			// static::addFrequency();

			$drysows = count($sows) - (count($bredsows) + count($pregnantsows) + count($lactatingsows) + count($gilts) + count($bredgilts));
			
			// gets unique years of age at weaning
			$years = [];
			$tempyears = [];
			foreach ($groups as $group) {
				$properties = $group->getGroupingProperties();
				foreach ($properties as $property) {
					if($property->property_id == 6){ //date weaned
						if(!is_null($property) && $property->value != "Not specified"){
							$year = Carbon::parse($property->value)->year;
							array_push($tempyears, $year);
							$years = array_reverse(array_sort(array_unique($tempyears)));
						}
					}
				}
			}

			$months = ["December", "November", "October", "September", "August", "July", "June", "May", "April", "March", "February", "January"];

			return view('pigs.breederinventory', compact('pigs', 'sows', 'boars', 'groups', 'frequency', 'breds', 'pregnantsows', 'lactatingsows', 'drysows', 'gilts', 'jrboars', 'srboars', 'now', 'noage_boars', 'years', 'months', 'age_boars', 'age_sows', 'noage_sows', 'bredsows', 'bredgilts'));
		}

		/*static function getMonthlyBredSows($year, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

			$monthlybredsows = [];
			foreach ($groups as $group) {
				$properties = $group->getGroupingProperties();
				foreach ($properties as $property) {
					if($property->property_id == 42){ //date bred
						if(!is_null($property) && $property->value != "Not specified"){
							$date_bred = Carbon::parse($property->value);
							if($date_bred->year == $year && $date_bred->format('F') == $month){
								array_push($monthlybredsows, $group->getMother()->registryid);
							}
						}
					}
				}
			}

			return count($monthlybredsows);
		}

		static function getMonthlyPregnantSows($year, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

			$monthlypregnantsows = [];
			foreach ($groups as $group) {
				$properties = $group->getGroupingProperties();
				foreach ($properties as $property) {
					if($property->property_id == 42){ //date bred
						if(!is_null($property) && $property->value != "Not specified"){
							$date_bred = Carbon::parse($property->value);
							$date = new Carbon('last day of '.$month.' '.$year);
							if($date->gte($date_bred) && $date_bred->addDays(114)->gte($date)){
								if($group->getGroupingProperties()->where("property_id", 60)->first()->value != "Recycled"){
									array_push($monthlypregnantsows, $group->getMother()->registryid);
								}
							}
						}
					}
				}
			}

			return count($monthlypregnantsows);
		}

		static function getMonthlyLactatingSows($year, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

			$monthlylactatingsows = [];
			foreach ($groups as $group) {
				$properties = $group->getGroupingProperties();
				foreach ($properties as $property) {
					if($property->property_id == 3){ //date farrowed
						if(!is_null($property) && $property->value != "Not specified"){
							$date = new Carbon('last day of '.$month.' '.$year);
							$datefarrowed = Carbon::parse($property->value);
							$dateweanedprop = $group->getGroupingProperties()->where("property_id", 6)->first();
							if(!is_null($dateweanedprop) && $dateweanedprop->value != "Not specified"){
								if($dateweanedprop->value != "Not specified"){
									$dateweaned = Carbon::parse($dateweanedprop->value);
									if($date->between($datefarrowed, $dateweaned)){
										array_push($monthlylactatingsows, $group->getMother()->registryid);
									}
								}
								else{
									$dateweaned = $dateweanedprop->value;
								}
							}
							else{
								if(($datefarrowed->year == $year && $datefarrowed->format('F') == $month) || $date->lte($datefarrowed->addDays(90))){
									array_push($monthlylactatingsows, $group->getMother()->registryid);
								}
							}
						}
					}
				}
			}

			return count($monthlylactatingsows);
		}

		static function getMonthlyDrySows($year, $month, $count){
			$dry = $count - (static::getMonthlyBredSows($year, $month) + static::getMonthlyPregnantSows($year, $month) + static::getMonthlyLactatingSows($year, $month));

			if($dry > 0){
				$drysows = $dry;
			}
			else{
				$drysows = 0;
			}

			return $drysows;
		}*/

		public function growerInventoryDownloadPDF($filter){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "active")->get();

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
			$now = Carbon::now('Asia/Manila');
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			// $filter = $now->year;

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
						if($sowproperty->property_id == 3){ //date farrowed
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
						if($boarproperty->property_id == 3){ //date farrowed
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

			$pdf = PDF::loadView('pigs.growerinventorypdf', compact('pigs', 'sows', 'boars', 'months', 'index', 'years', 'filter', 'monthlysows', 'monthlyboars', 'now'))->setPaper('a4', 'landscape');

			return $pdf->download('growerinventory_'.$filter.'_'.$now.'.pdf');

		}

		public function getGrowerInventoryPage($filter){ // function to display Grower Inventory page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "active")->get();

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
			$now = Carbon::now('Asia/Manila');
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			// $filter = $now->year;

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
						if($sowproperty->property_id == 3){ //date farrowed
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
						if($boarproperty->property_id == 3){ //date farrowed
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
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "active")->get();

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

			$filter = $request->year_grower_inventory;

			$current_year = $filter;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

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
						if($sowproperty->property_id == 3){ //date farrowed
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
						if($boarproperty->property_id == 3){ //date farrowed
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

		public function mortalityAndSalesDownloadPDF(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			
			$deadpigs = Mortality::join('animals', 'animals.id', '=', 'mortalities.animal_id')
								->where("mortalities.animaltype_id", 3)
								->where("mortalities.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$soldpigs = Sale::join('animals', 'animals.id', '=', 'sales.animal_id')
							->where("sales.animaltype_id", 3)
							->where("sales.breed_id", $breed->id)
							->where("animals.farm_id", $farm->id)
							->get();

			$removedpigs = RemovedAnimal::join('animals', 'animals.id', '=', 'removed_animals.animal_id')
							->where("removed_animals.animaltype_id", 3)
							->where("animals.farm_id", $farm->id)
							->where("removed_animals.breed_id", $breed->id)
							->get();

			$now = Carbon::now('Asia/Manila');

			// sorts pigs by status
			$currentdeadpigs = [];
			$currentsoldgrowers = [];
			$currentsoldbreeders = [];
			$currentremoved = [];

			foreach ($deadpigs as $deadpig) {
				$date_died = Carbon::parse($deadpig->datedied);
				if($date_died->month == $now->month && $date_died->year == $now->year){
					if($date_died->lte($now)){
						array_push($currentdeadpigs, $deadpig);
					}
				}
			}

			foreach ($soldpigs as $soldpig) {
				$date_sold = Carbon::parse($soldpig->datesold);
				if($date_sold->month == $now->month && $date_sold->year == $now->year){
					if($date_sold->lte($now)){
						if($soldpig->getStatus() == "sold breeder"){
							array_push($currentsoldbreeders, $soldpig);
						}
						elseif($soldpig->getStatus() == "sold grower"){
							array_push($currentsoldgrowers, $soldpig);
						}
					}
				}
			}

			foreach ($removedpigs as $removedpig) {
				$date_removed = Carbon::parse($removedpig->dateremoved);
				if($date_removed->month == $now->month && $date_removed->year == $now->year){
					if($date_removed->lte($now)){
						array_push($currentremoved, $removedpig);
					}
				}
			}


			$ages_dead = [];
			$ages_currentsoldbreeder = [];
			$ages_currentsoldgrower = [];
			$weights_currentsoldbreeder = [];
			$weights_currentsoldgrower = [];

			foreach ($currentdeadpigs as $currentdeadpig) {
				if($currentdeadpig->age != "Age unavailable"){
					array_push($ages_dead, $currentdeadpig->age/30);
				}
			}

			foreach ($currentsoldbreeders as $currentsoldbreeder) {
				if($currentsoldbreeder->age != "Age unavailable"){
					array_push($ages_currentsoldbreeder, $currentsoldbreeder->age/30);
				}
				if($currentsoldbreeder->weight != "Weight unavailable"){
					array_push($weights_currentsoldbreeder, $currentsoldbreeder->weight);
				}
			}

			foreach ($currentsoldgrowers as $currentsoldgrower) {
				if($currentsoldgrower->age != "Age unavailable"){
					array_push($ages_currentsoldgrower, $currentsoldgrower->age/30);
				}
				if($currentsoldgrower->weight != "Weight unavailable"){
					array_push($weights_currentsoldgrower, $currentsoldgrower->weight);
				}
			}

			$pdf = PDF::loadView('pigs.mortandsalespdf', compact('deadpigs', 'currentdeadpigs', 'soldpigs', 'currentsoldbreeders', 'currentsoldgrowers', 'removedpigs', 'currentremoved', 'ages_dead', 'ages_currentsoldbreeder', 'ages_currentsoldgrower', 'weights_currentsoldbreeder', 'weights_currentsoldgrower', 'now'));

			return $pdf->download('mortalityandsales_'.$now.'.pdf');

		}

		public function getMortalityAndSalesReportPage(){ // function to display Mortality and Sales Report page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();

			$deadpigs = Mortality::join('animals', 'animals.id', '=', 'mortalities.animal_id')
								->where("mortalities.animaltype_id", 3)
								->where("mortalities.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$soldpigs = Sale::join('animals', 'animals.id', '=', 'sales.animal_id')
							->where("sales.animaltype_id", 3)
							->where("sales.breed_id", $breed->id)
							->where("animals.farm_id", $farm->id)
							->get();

			$removedpigs = RemovedAnimal::join('animals', 'animals.id', '=', 'removed_animals.animal_id')
							->where("removed_animals.animaltype_id", 3)
							->where("animals.farm_id", $farm->id)
							->where("removed_animals.breed_id", $breed->id)
							->get();

			$now = Carbon::now('Asia/Manila');

			// sorts pigs by status
			$currentdeadpigs = [];
			$currentsoldgrowers = [];
			$currentsoldbreeders = [];
			$currentremoved = [];

			foreach ($deadpigs as $deadpig) {
				$date_died = Carbon::parse($deadpig->datedied);
				if($date_died->month == $now->month && $date_died->year == $now->year){
					if($date_died->lte($now)){
						array_push($currentdeadpigs, $deadpig);
					}
				}
			}

			foreach ($soldpigs as $soldpig) {
				$date_sold = Carbon::parse($soldpig->datesold);
				if($date_sold->month == $now->month && $date_sold->year == $now->year){
					if($date_sold->lte($now)){
						if($soldpig->getStatus() == "sold breeder"){
							array_push($currentsoldbreeders, $soldpig);
						}
						elseif($soldpig->getStatus() == "sold grower"){
							array_push($currentsoldgrowers, $soldpig);
						}
					}
				}
			}

			foreach ($removedpigs as $removedpig) {
				$date_removed = Carbon::parse($removedpig->dateremoved);
				if($date_removed->month == $now->month && $date_removed->year == $now->year){
					if($date_removed->lte($now)){
						array_push($currentremoved, $removedpig);
					}
				}
			}


			$ages_dead = [];
			$ages_currentsoldbreeder = [];
			$ages_currentsoldgrower = [];
			$weights_currentsoldbreeder = [];
			$weights_currentsoldgrower = [];

			foreach ($currentdeadpigs as $currentdeadpig) {
				if($currentdeadpig->age != "Age unavailable"){
					array_push($ages_dead, $currentdeadpig->age/30);
				}
			}

			foreach ($currentsoldbreeders as $currentsoldbreeder) {
				if($currentsoldbreeder->age != "Age unavailable"){
					array_push($ages_currentsoldbreeder, $currentsoldbreeder->age/30);
				}
				if($currentsoldbreeder->weight != "Weight unavailable"){
					array_push($weights_currentsoldbreeder, $currentsoldbreeder->weight);
				}
			}

			foreach ($currentsoldgrowers as $currentsoldgrower) {
				if($currentsoldgrower->age != "Age unavailable"){
					array_push($ages_currentsoldgrower, $currentsoldgrower->age/30);
				}
				if($currentsoldgrower->weight != "Weight unavailable"){
					array_push($weights_currentsoldgrower, $currentsoldgrower->weight);
				}
			}
			
			$months = ["December", "November", "October", "September", "August", "July", "June", "May", "April", "March", "February", "January"];
			// $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			// gets the unique years of death/sales/removed
			$years = [];
			$tempyears = [];

			foreach ($deadpigs as $deadpig) {
				$date_died = Carbon::parse($deadpig->datedied);
				array_push($tempyears, $date_died->year);
			}

			foreach ($soldpigs as $soldpig) {
				$date_sold = Carbon::parse($soldpig->datesold);
				array_push($tempyears, $date_sold->year);
			}

			foreach ($removedpigs as $removedpig) {
				$date_removed = Carbon::parse($removedpig->dateremoved);
				array_push($tempyears, $date_removed->year);
			}
		  $years = array_reverse(array_sort(array_unique($tempyears)));
		  

			return view('pigs.mortalityandsalesreport', compact('deadpigs', 'currentdeadpigs', 'soldpigs', 'currentsoldbreeders', 'currentsoldgrowers', 'removedpigs', 'currentremoved', 'ages_dead', 'ages_currentsoldbreeder', 'ages_currentsoldgrower', 'weights_currentsoldbreeder', 'weights_currentsoldgrower', 'now', 'years', 'months'));
		}

		static function getMonthlyMortality($year, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$deadpigs = Mortality::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();

			$monthlymortality = [];
			foreach ($deadpigs as $deadpig) {
				$date_died = Carbon::parse($deadpig->datedied);
				if($date_died->year == $year && $date_died->format('F') == $month){
					array_push($monthlymortality, $deadpig);
				}
			}

			return $monthlymortality;
		}

		static function getMonthlySales($year, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$soldpigs = Sale::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();

			$monthlysales = [];
			foreach ($soldpigs as $soldpig) {
				$date_sold = Carbon::parse($soldpig->datesold);
				if($date_sold->year == $year && $date_sold->format('F') == $month){
					array_push($monthlysales, $soldpig);
				}
			}

			return $monthlysales;
		}

		static function getMonthlyRemoved($year, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$removedpigs = RemovedAnimal::join('animals', 'animals.id', '=', 'removed_animals.animal_id')
										->where("removed_animals.animaltype_id", 3)
										->where("animals.farm_id", $farm->id)
										->where("removed_animals.breed_id", $breed->id)
										->get();

			$monthlyremoved = [];
			foreach ($removedpigs as $removedpig) {
				$date_removed = Carbon::parse($removedpig->dateremoved);
				if($date_removed->year == $year && $date_removed->format('F') == $month){
					array_push($monthlyremoved, $removedpig);
				}
			}
		
			return $monthlyremoved;
		}

		static function getMonthlyAverageAge($year, $month, $type){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$deadpigs = Mortality::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
			$soldpigs = Sale::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();

			$ages = [];
			if ($type == "dead"){
				foreach ($deadpigs as $deadpig) {
					$date_died = Carbon::parse($deadpig->datedied);
					if($date_died->year == $year && $date_died->format('F') == $month){
						if($deadpig->age != "Age unavailable"){
							array_push($ages, $deadpig->age/30);
						}
					}
				}
			}
			elseif ($type == "sold") {
				foreach ($soldpigs as $soldpig) {
					$date_sold = Carbon::parse($soldpig->datesold);
					if($date_sold->year == $year && $date_sold->format('F') == $month){
						if($soldpig->age != "Age unavailable"){
							array_push($ages, $soldpig->age/30);
						}
					}
				}
			}

			return $ages;
		}

		static function getMonthlyAverageWeightSold($year, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$soldpigs = Sale::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();

			$weights = [];
			foreach ($soldpigs as $soldpig) {
				$date_sold = Carbon::parse($soldpig->datesold);
				if($date_sold->year == $year && $date_sold->format('F') == $month){
					if($soldpig->weight != "Weight unavailable"){
						array_push($weights, $soldpig->weight);
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

		public function getDownloadableFilesPage(){
			$files = DB::table('downloadable_files')->get();

			return view('pigs.downloadables', compact('files'));
		}

		public function getGrowerRecordsPage(){ // function to display Grower Records page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "active")->get();

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

		static function addFrequency(){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();

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

			if(!is_null($pigs)){
				// gets all groups available
				$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

				// BOAR INVENTORY
				foreach ($boars as $boar) {	// adds frequency of boar service
					$frequencies = [];
					$frequency = 0;
					$freqproperty = $boar->getAnimalProperties()->where("property_id", 61)->first();

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
						$freqprop->property_id = 61;
						$freqprop->value = array_sum($frequencies);
						$freqprop->save();
					}
					else{
						$freqproperty->value = array_sum($frequencies);
						$freqproperty->save();
					}
				}

				foreach ($sows as $sow) { // adds frequency of sow usage
					$sowfrequencies = [];
					$sowfrequency = 0;
					$sowfreqproperty = $sow->getAnimalProperties()->where("property_id", 61)->first();

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
						$sowfreqprop->property_id = 61;
						$sowfreqprop->value = array_sum($sowfrequencies);
						$sowfreqprop->save();
					}
					else{
						$sowfreqproperty->value = array_sum($sowfrequencies);
						$sowfreqproperty->save();
					}
				}
			}
		}

		static function addPonderalIndices(){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();

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

		public function searchForMortalityAndSales(Request $request){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$q = $request->q;
			$deadpigs = Mortality::join('animals', 'animals.id', '=', 'mortalities.animal_id')
								->where("mortalities.animaltype_id", 3)
								->where("mortalities.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$soldpigs = Sale::join('animals', 'animals.id', '=', 'sales.animal_id')
							->where("sales.animaltype_id", 3)
							->where("sales.breed_id", $breed->id)
							->where("animals.farm_id", $farm->id)
							->get();

			$removedpigs = RemovedAnimal::join('animals', 'animals.id', '=', 'removed_animals.animal_id')
							->where("removed_animals.animaltype_id", 3)
							->where("animals.farm_id", $farm->id)
							->where("removed_animals.breed_id", $breed->id)
							->get();

			if($q != ' '){
				$mortalitysearch = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "active")
													->orWhere("status", "dead breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "removed breeder")
													->orWhere("status", "dead grower")
													->orWhere("status", "sold grower")
													->orWhere("status", "removed grower");
													})->where('registryid', 'LIKE', '%'.$q.'%')->get();

				if(count($mortalitysearch) > 0){
					return view('pigs.mortalityandsales', compact('soldpigs', 'deadpigs', 'removedpigs', 'years'))->withDetails($mortalitysearch)->withQuery($q);
				}
			}
			return view('pigs.mortalityandsales', compact('soldpigs', 'deadpigs', 'removedpigs', 'years'))->withMessage("No results found!");
		}

		public function searchBreeders(Request $request){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$q = $request->q;
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$archived_pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "dead breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "removed breeder");
													})->get();

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

			$archived_sows = [];
			$archived_boars = [];
			foreach ($archived_pigs as $archived_pig) {
				if(substr($archived_pig->registryid, -7, 1) == 'F'){
					array_push($archived_sows, $archived_pig);
				}
				if(substr($archived_pig->registryid, -7, 1) == 'M'){
					array_push($archived_boars, $archived_pig);
				}
			}

			if($q != ' '){
				$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "breeder")
													->orWhere("status", "dead breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "removed breeder");
													})->where('registryid', 'LIKE', '%'.$q.'%')->get();
				// dd($breeders);
				if(count($breeders) > 0){
					return view('pigs.breederrecords', compact('pigs', 'sows', 'boars', 'archived_sows', 'archived_boars'))->withDetails($breeders)->withQuery($q);
				}
			}
			return view('pigs.breederrecords', compact('pigs', 'sows', 'boars', 'archived_sows', 'archived_boars'))->withMessage("No breeders found!");
		}

		public function searchGrowers(Request $request){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$q = $request->q;
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "active")->get();

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

			if($q != ' '){
				$growers = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "active")->where('registryid', 'LIKE', '%'.$q.'%')->get();
				// dd($growers);
				if(count($growers) > 0){
					return view('pigs.growerrecords', compact('pigs', 'sows', 'boars'))->withDetails($growers)->withQuery($q);
				}
			}
			return view('pigs.growerrecords', compact('pigs', 'sows', 'boars'))->withMessage("No growers found!");
		}

		public function searchBreedingRecord(Request $request){	
			$q = $request->q;
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$family = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->whereNotNull("mother_id")
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->get();

			$groups = Grouping::join('animals', 'animals.id', '=', 'groupings.mother_id')->select('*')->selectRaw('groupings.id AS id')
								->where("groupings.breed_id", $breed->id)
								->where("animals.farm_id", $farm->id)
								->join('grouping_properties', 'groupings.id', 'grouping_properties.grouping_id')
								->where("grouping_properties.property_id", 42)
								->select('groupings.*', 'grouping_properties.*', 'groupings.id as id', 'grouping_properties.id as gp_id')
								->orderBy('grouping_properties.value', 'desc')
								->get();

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

			/*$temp = [];
			foreach ($family as $fam) {
				foreach ($sows as $sow) {
					if($fam->mother_id == $sow->id){
						$values = [];
						array_push($values, $fam->registryid);
						array_push($values, $fam->getGroupingProperties()->where("property_id", 60)->first()->value); //status
						array_push($values, $fam->id);
						array_push($values, $fam->getGroupingProperties()->where("property_id", 42)->first()->value); //date bred
						if(!is_null($fam->getGroupingProperties()->where("property_id", 6)->first())){
							array_push($values, $fam->getGroupingProperties()->where("property_id", 6)->first()->value);
						}
						array_push($temp, $values);
					}
				}
			}

			$available_temp = [];
			$available = [];
			foreach ($temp as $value) {
				if($value[1] == "Farrowed"){
					if(array_map('count', $temp) == 5){
						array_push($available_temp, $value[0]);
					}
				}
				elseif($value[1] == "Recycled"){
					array_push($available_temp, $value[0]);
				}
				elseif($value[1] == "Aborted"){
					array_push($available_temp, $value[0]);
				}
			}

			foreach ($sows as $sow) {
				$parity = $sow->getAnimalProperties()->where("property_id", 48)->first();
				if(!is_null($parity)){
					if($parity->value == 0){
						array_push($available_temp, $sow->registryid);
					}
				}
				else{
					array_push($available_temp, $sow->registryid);
				}
			}

			$available = array_unique($available_temp);*/

			// automatically updates mother's parity
			foreach ($groups as $group) {
				static::addParityMother($group->id);
			}

			static::addFrequency();

			// TO FOLLOW: this will be used for filtering results
			$now = Carbon::now('Asia/Manila');
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			if($q != ' '){
				$searchable = [];
				foreach ($groups as $group) {
					if(stripos($group->getMother()->registryid, $q) !== false || stripos($group->getFather()->registryid, $q) !== false || stripos(Carbon::parse($group->value)->format('j F, Y'), $q) !== false){
						array_push($searchable, $group);
					}
				}

				if(count($searchable) > 0){
					return view('pigs.breedingrecord', compact('pigs', 'sows', 'boars', 'family', 'years', 'available', 'groups'))->withDetails($searchable)->withQuery($q);
				}
			}

			return view('pigs.breedingrecord', compact('pigs', 'sows', 'boars', 'family', 'years', 'available', 'groups'))->withMessage("No breeding record found!");

		}

		public function getBreederRecordsPage(){ // function to display Breeder Records page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where("status", "breeder")->get();
			$archived_pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->where(function ($query) {
										$query->where("status", "dead breeder")
													->orWhere("status", "sold breeder")
													->orWhere("status", "removed breeder");
													})->get();

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

			$archived_sows = [];
			$archived_boars = [];
			foreach ($archived_pigs as $archived_pig) {
				if(substr($archived_pig->registryid, -7, 1) == 'F'){
					array_push($archived_sows, $archived_pig);
				}
				if(substr($archived_pig->registryid, -7, 1) == 'M'){
					array_push($archived_boars, $archived_pig);
				}
			}

			static::addPonderalIndices();

			return view('pigs.breederrecords', compact('pigs', 'sows', 'boars', 'archived_sows', 'archived_boars'));
		}

		public function getAddPigPage(){ // function to display Add Pig page
			return view('pigs.addpig');
		}

		public function getViewSowPage($id){ // function to display View Sow page
			$sow = Animal::find($id);
			$properties = $sow->getAnimalProperties();
			$photo = Uploads::where("animal_id", $id)->first();

			// computes current age
			$now = Carbon::now('Asia/Manila');
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
							else{
								$ageAtFirstMating = "";
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

			return view('pigs.viewsow', compact('sow', 'properties', 'age', 'ageAtWeaning', 'ageAtFirstMating', 'males', 'females', 'parity_born', 'age_grossmorpho', 'age_morphochars', 'photo'));
		}

		public function getViewBoarPage($id){ // function to display View Boar page
			$boar = Animal::find($id);
			$properties = $boar->getAnimalProperties();
			$photo = Uploads::where("animal_id", $id)->first();

			// computes current age
			$now = Carbon::now('Asia/Manila');
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
			$frequency = $boar->getAnimalProperties()->where("property_id", 61)->first();
			$dates_bred = [];
			if(!is_null($frequency)){
				if($frequency->value > 1){
					$groups = Grouping::where("father_id", $boar->id)->get();
					foreach ($groups as $group) {
						$groupproperties = $group->getGroupingProperties();
						foreach ($groupproperties as $groupproperty) {
							if($groupproperty->property_id == 42){ // date bred
								$date_bred = $groupproperty->value;
								array_push($dates_bred, $date_bred);
							}
						}
						// gets the first date of breeding
						$sorted_dates = array_sort($dates_bred);
						$keys = array_keys($sorted_dates);
						$date_bredboar = $sorted_dates[$keys[0]];
						if(!is_null($boar->getAnimalProperties()->where("property_id", 3)->first())){
							$bday = $boar->getAnimalProperties()->where("property_id", 3)->first()->value;
							if($bday != "Not specified"){
								$ageAtFirstMating = Carbon::parse($date_bredboar)->diffInMonths(Carbon::parse($bday));
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

			return view('pigs.viewboar', compact('boar', 'properties', 'age', 'ageAtWeaning', 'ageAtFirstMating', 'males', 'females', 'parity_born', 'age_grossmorpho', 'age_morphochars', 'photo'));
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
			
			return view('pigs.weightrecords', compact('animal', 'properties', 'age_weaned'));
		}

		public function getEditWeightRecordsPage($id){ // function to display Edit Weight Records page
			$animal = Animal::find($id);
			$properties = $animal->getAnimalProperties();

			$datefarrowedprop = $properties->where("property_id", 3)->first();
			$dateweanedprop = $properties->where("property_id", 6)->first();
			$bw45dprop = $properties->where("property_id", 32)->first();
			$bw60dprop = $properties->where("property_id", 33)->first();
			$bw90dprop = $properties->where("property_id", 34)->first();
			$bw150dprop = $properties->where("property_id", 35)->first();
			$bw180dprop = $properties->where("property_id", 36)->first();
			$dc45dprop = $properties->where("property_id", 37)->first();
			$dc60dprop = $properties->where("property_id", 38)->first();
			$dc90dprop = $properties->where("property_id", 39)->first();
			$dc150dprop = $properties->where("property_id", 40)->first();
			$dc180dprop = $properties->where("property_id", 41)->first();

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

			if(!is_null($bw45dprop)){
				if($bw45dprop->value != ""){
					if($datefarrowedprop->value != "Not specified"){
						$datefarrowed = Carbon::parse($datefarrowedprop->value);
						$dc45d = Carbon::parse($dc45dprop->value);
						$actual45d = $dc45d->diffInDays($datefarrowed);
					}
					else{
						$actual45d = "";
					}
				}
				else{
					$actual45d = "";
				}
			}
			else{
				$actual45d = "";
			}

			if(!is_null($bw60dprop)){
				if($bw60dprop->value != ""){
					if($datefarrowedprop->value != "Not specified"){
						$datefarrowed = Carbon::parse($datefarrowedprop->value);
						$dc60d = Carbon::parse($dc60dprop->value);
						$actual60d = $dc60d->diffInDays($datefarrowed);
					}
					else{
						$actual60d = "";
					}
				}
				else{
					$actual60d = "";
				}
			}
			else{
				$actual60d = "";
			}

			if(!is_null($bw90dprop)){
				if($bw90dprop->value != ""){
					if($datefarrowedprop->value != "Not specified"){
						$datefarrowed = Carbon::parse($datefarrowedprop->value);
						$dc90d = Carbon::parse($dc90dprop->value);
						$actual90d = $dc90d->diffInDays($datefarrowed);
					}
					else{
						$actual90d = "";
					}
				}
				else{
					$actual90d = "";
				}
			}
			else{
				$actual90d = "";
			}

			if(!is_null($bw150dprop)){
				if($bw150dprop->value != ""){
					if($datefarrowedprop->value != "Not specified"){
						$datefarrowed = Carbon::parse($datefarrowedprop->value);
						$dc150d = Carbon::parse($dc150dprop->value);
						$actual150d = $dc150d->diffInDays($datefarrowed);
					}
					else{
						$actual150d = "";
					}
				}
				else{
					$actual150d = "";
				}
			}
			else{
				$actual150d = "";
			}

			if(!is_null($bw180dprop)){
				if($bw180dprop->value != ""){
					if($datefarrowedprop->value != "Not specified"){
						$datefarrowed = Carbon::parse($datefarrowedprop->value);
						$dc180d = Carbon::parse($dc180dprop->value);
						$actual180d = $dc180d->diffInDays($datefarrowed);
					}
					else{
						$actual180d = "";
					}
				}
				else{
					$actual180d = "";
				}
			}
			else{
				$actual180d = "";
			}

			return view('pigs.editweightrecords', compact('animal', 'properties', 'age_weaned', 'actual45d', 'actual60d', 'actual90d', 'actual150d', 'actual180d'));
		}

		public function changeEarnotchSow(Request $request){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$sow = Animal::find($request->sow_id);
			$dob = $sow->getAnimalProperties()->where("property_id", 3)->first();
			$sex = $sow->getAnimalProperties()->where("property_id", 2)->first()->value;

			$choice = $request->change;
			if($choice == "yes"){
				if(!is_null($request->sow_new_id)){
					$temp_earnotch = $request->sow_new_id;
					if(strlen($temp_earnotch) == 6){
						$earnotch = $temp_earnotch;
					}
					else{
						$earnotch = str_pad($temp_earnotch, 6, "0", STR_PAD_LEFT);
					}
					if(!is_null($dob) && $dob->value != "Not specified"){
						$birthdayValue = Carbon::parse($dob->value);
						$registryid = $farm->code.$breed->breed."-".$birthdayValue->year.$sex.$earnotch;

						$new_id = new AnimalProperty;
						$new_id->animal_id = $sow->id;
						$new_id->property_id = 63;
						$new_id->value = $registryid;
						$new_id->save();

						$old_id = new AnimalProperty;
						$old_id->animal_id = $sow->id;
						$old_id->property_id = 64;
						$old_id->value = $sow->registryid;
						$old_id->save();

						$sow->registryid = $registryid;
						$sow->save();
					}
					else{
						$registryid = $farm->code.$breed->breed."-".$sex.$earnotch;

						$new_id = new AnimalProperty;
						$new_id->animal_id = $sow->id;
						$new_id->property_id = 63;
						$new_id->value = $registryid;
						$new_id->save();

						$old_id = new AnimalProperty;
						$old_id->animal_id = $sow->id;
						$old_id->property_id = 64;
						$old_id->value = $sow->registryid;
						$old_id->save();

						$sow->registryid = $registryid;
						$sow->save();
					}
				}
				else{
					$new_id = new AnimalProperty;
					$new_id->animal_id = $sow->id;
					$new_id->property_id = 63;
					$new_id->value = $sow->registryid;
					$new_id->save();

					$old_id = new AnimalProperty;
					$old_id->animal_id = $sow->id;
					$old_id->property_id = 64;
					$old_id->value = $sow->registryid;
					$old_id->save();
				}
			}
			

			return Redirect::back()->with('message','Operation Successful!');			
		}

		public function changeEarnotchBoar(Request $request){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$boar = Animal::find($request->boar_id);
			$dob = $boar->getAnimalProperties()->where("property_id", 3)->first();
			$sex = $boar->getAnimalProperties()->where("property_id", 2)->first()->value;

			$choice = $request->choice;
			if($choice == "yes"){
				if(!is_null($request->boar_new_id)){
					$temp_earnotch = $request->boar_new_id;
					if(strlen($temp_earnotch) == 6){
						$earnotch = $temp_earnotch;
					}
					else{
						$earnotch = str_pad($temp_earnotch, 6, "0", STR_PAD_LEFT);
					}
					if(!is_null($dob) && $dob->value != "Not specified"){
						$birthdayValue = Carbon::parse($dob->value);
						$registryid = $farm->code.$breed->breed."-".$birthdayValue->year.$sex.$earnotch;

						$new_id = new AnimalProperty;
						$new_id->animal_id = $boar->id;
						$new_id->property_id = 63;
						$new_id->value = $registryid;
						$new_id->save();

						$old_id = new AnimalProperty;
						$old_id->animal_id = $boar->id;
						$old_id->property_id = 64;
						$old_id->value = $boar->registryid;
						$old_id->save();

						$boar->registryid = $registryid;
						$boar->save();
					}
					else{
						$registryid = $farm->code.$breed->breed."-".$sex.$earnotch;

						$new_id = new AnimalProperty;
						$new_id->animal_id = $boar->id;
						$new_id->property_id = 63;
						$new_id->value = $registryid;
						$new_id->save();

						$old_id = new AnimalProperty;
						$old_id->animal_id = $boar->id;
						$old_id->property_id = 64;
						$old_id->value = $boar->registryid;
						$old_id->save();

						$boar->registryid = $registryid;
						$boar->save();
					}
				}
				else{
					$new_id = new AnimalProperty;
					$new_id->animal_id = $boar->id;
					$new_id->property_id = 63;
					$new_id->value = $boar->registryid;
					$new_id->save();

					$old_id = new AnimalProperty;
					$old_id->animal_id = $boar->id;
					$old_id->property_id = 63;
					$old_id->value = $boar->registryid;
					$old_id->save();
				}
			}
			

			return Redirect::back()->with('message','Operation Successful!');			
		}

		public function fetchBreedersAjax($breederid){ // function to add pigs as breeders onclick
			$pig = Animal::find($breederid);

			$pig->status = "breeder";
			$pig->save();
		}

		public function makeCandidateBreederAjax($growerid, $status){
			$pig = Animal::where("registryid", $growerid)->first();

			$statusprop = $pig->getAnimalProperties()->where("property_id", 60)->first();

			if(is_null($statusprop)){
				$pigstatus = new AnimalProperty;
				$pigstatus->animal_id = $pig->id;
				$pigstatus->property_id = 60;
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
				45d - 32
				60d - 33
				90d - 34
				150d - 35
				180d - 36
			*/
			$birth_weight_prop = $properties->where("property_id", 5)->first();
			$weaning_weight_prop = $properties->where("property_id", 7)->first();
			$weight_45d_prop = $properties->where("property_id", 32)->first();
			$weight_60d_prop = $properties->where("property_id", 33)->first();
			$weight_90d_prop = $properties->where("property_id", 34)->first();
			$weight_150d_prop = $properties->where("property_id", 35)->first();
			$weight_180d_prop = $properties->where("property_id", 36)->first();
			
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
					$date_weaned = Carbon::parse($properties->where("property_id", 6)->first()->value);
					$bday = Carbon::parse($properties->where("property_id", 3)->first()->value);
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
					$dateweanedprop = $properties->where("property_id", 6)->first();
					if(!is_null($dateweanedprop)){
						if($dateweanedprop->value != "Not specified"){
							$date_weaned = Carbon::parse($dateweanedprop->value);
							$bday = Carbon::parse($properties->where("property_id", 3)->first()->value);
							$age_weaned = $date_weaned->diffInDays($bday);
						}
						else{
							$age_weaned = 0;
						}
					}
					if($age_weaned != 0){
						if($number_of_days != $age_weaned){
							$adg_weaning = ($latest_weight-$weaning_weight_prop->value)/($number_of_days-$age_weaned);
						}
						else{
							$adg_weaning = 0;
						}
					}
					elseif($age_weaned == 0){
						$adg_weaning = "";
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

			return view('pigs.adg', compact('pig', 'properties', 'adg_birth', 'adg_weaning', 'number_of_days'));
		}
		
		public function changeStatusFromBred($id, Request $request){
			$group = Grouping::find($id);

			$status = $group->getGroupingProperties()->where("property_id", 60)->first();
			$status->value = $request->change_status_bred;
			$status->save();

			return Redirect::back()->with('message','Operation Successful!');
		}

		public function changeStatusFromPregnant($id, Request $request){
			$group = Grouping::find($id);

			$status = $group->getGroupingProperties()->where("property_id", 60)->first();
			$status->value = $request->change_status_pregnant;
			$status->save();

			return Redirect::back()->with('message','Operation Successful!');
		}

		public function addDateAborted(Request $request){
			$group = Grouping::find($request->group_id);


			$dateabortedprop = $group->getGroupingProperties()->where("property_id", 44)->first();
			if(is_null($dateabortedprop)){
				$date_aborted = new GroupingProperty;
				$date_aborted->grouping_id = $group->id;
				$date_aborted->property_id = 44;
				$date_aborted->value = $request->date_aborted;
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

			return Redirect::back()->with('message','Operation Successful!');

		}

		public function fetchWeighingOptionAjax($familyidvalue, $option){
			$group = Grouping::find($familyidvalue);

			$weighingoption_prop = $group->getGroupingProperties()->where("property_id", 54)->first();

			if(is_null($weighingoption_prop)){
				$weighing_option = new GroupingProperty;
				$weighing_option->grouping_id = $familyidvalue;
				$weighing_option->property_id = 54;
				$weighing_option->value = $option;
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
			$temp_earnotch = $request->offspring_earnotch;
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
				// adds new offspring
				$birthdayValue = Carbon::parse($request->date_farrowed)->format('Y-m-d');
				if(!is_null($request->offspring_earnotch) && !is_null($request->sex) && !is_null($request->birth_weight)){
					$offspring = new Animal;
					$farm = $this->user->getFarm();
					$breed = $farm->getBreed();
					$offspring->animaltype_id = 3;
					$offspring->farm_id = $farm->id;
					$offspring->breed_id = $breed->id;
					$offspring->status = "active";
					$registryid = $farm->code.$breed->breed."-".Carbon::parse($request->date_farrowed)->format('Y').$request->sex.$earnotch;
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
					$birthday->value = Carbon::parse($request->date_farrowed)->format('Y-m-d');
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
			}

			// adds date farrowed as a group property
			$datefarrowedgroupprop = $grouping->getGroupingProperties()->where("property_id", 3)->first();
			if(is_null($datefarrowedgroupprop)){
				$date_farrowed = new GroupingProperty;
				$date_farrowed->grouping_id = $grouping->id;
				$date_farrowed->property_id = 3;
				$date_farrowed->value = Carbon::parse($request->date_farrowed)->format('Y-m-d');
				$date_farrowed->save();
			}
			else{
				$datefarrowedgroupprop->value = Carbon::parse($request->date_farrowed)->format('Y-m-d');
				$datefarrowedgroupprop->save();
			}

			// changes status from Pregnant to Farrowed
			$status = GroupingProperty::where("property_id", 60)->where("grouping_id", $grouping->id)->first();
			$status->value = "Farrowed";
			$status->save();

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

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function addSowlitterRecordIndividualWeighing(Request $request){
			$grouping = Grouping::find($request->grouping_id);
			$members = $grouping->getGroupingMembers();
			$temp_earnotch = $request->offspring_earnotch;
			if(strlen($temp_earnotch) == 6){
				$earnotch = $temp_earnotch;
			}
			else{
				$earnotch = str_pad($temp_earnotch, 6, "0", STR_PAD_LEFT);
			}
			// adds new offspring
			$birthdayValue = Carbon::parse($request->date_farrowed)->format('Y-m-d');
			if(!is_null($request->offspring_earnotch) && !is_null($request->sex) && !is_null($request->birth_weight)){
				$offspring = new Animal;
				$farm = $this->user->getFarm();
				$breed = $farm->getBreed();
				$offspring->animaltype_id = 3;
				$offspring->farm_id = $farm->id;
				$offspring->breed_id = $breed->id;
				$offspring->status = "active";
				$registryid = $farm->code.$breed->breed."-".Carbon::parse($request->date_farrowed)->format('Y').$request->sex.$earnotch;
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
				$birthday->value = Carbon::parse($request->date_farrowed)->format('Y-m-d');
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
				$date_farrowed->value = Carbon::parse($request->date_farrowed)->format('Y-m-d');
				$date_farrowed->save();
			}
			else{
				$datefarrowedgroupprop->value = $request->date_farrowed;
				$datefarrowedgroupprop->save();
			}

			// changes status from Pregnant to Farrowed
			$status = GroupingProperty::where("property_id", 60)->where("grouping_id", $grouping->id)->first();
			$status->value = "Farrowed";
			$status->save();

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

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function addSowlitterRecordGroupWeighing(Request $request){
			$grouping = Grouping::find($request->grouping_id);
			$members = $grouping->getGroupingMembers();

			// adds new offspring
			$birthdayValue = Carbon::parse($request->date_farrowed)->format('Y-m-d');
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
				$farm = $this->user->getFarm();
				$breed = $farm->getBreed();
				$offspring->animaltype_id = 3;
				$offspring->farm_id = $farm->id;
				$offspring->breed_id = $breed->id;
				$offspring->status = "temporary";
				$offspring->registryid = $farm->code.$breed->breed."-".Carbon::parse($request->date_farrowed)->format('Y').$request->sex.$request->offspring_earnotch;
				$offspring->save();

				$birthday = new AnimalProperty;
				$birthday->animal_id = $offspring->id;
				$birthday->property_id = 3;
				$birthday->value = Carbon::parse($request->date_farrowed)->format('Y-m-d');
				$birthday->save();

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
				$date_farrowed->value = Carbon::parse($request->date_farrowed)->format('Y-m-d');
				$date_farrowed->save();
			}
			else{
				$datefarrowedgroupprop->value = Carbon::parse($request->date_farrowed)->format('Y-m-d');
				$datefarrowedgroupprop->save();
			}

			// changes status from Pregnant to Farrowed
			$status = GroupingProperty::where("property_id", 60)->where("grouping_id", $grouping->id)->first();
			$status->value = "Farrowed";
			$status->save();

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

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function editRegistryId(Request $request){
			$offspring = Animal::find($request->old_earnotch);
			$family = $offspring->getGrouping();
			$members = $family->getGroupingMembers();

			$offspringproperties = $offspring->getAnimalProperties();
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
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

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function editSex(Request $request){
			$offspring = Animal::find($request->animalid);

			$offspringproperties = $offspring->getAnimalProperties();
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
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

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function editBirthWeight(Request $request){
			$offspring = Animal::find($request->animalid);

			$bweight = $offspring->getAnimalProperties()->where("property_id", 5)->first();
			$bweightValue = $request->new_birth_weight;

			$bweight->value = $bweightValue;
			$bweight->save();

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function editWeaningWeight(Request $request){
			$offspring = Animal::find($request->animalid);

			$wweight = $offspring->getAnimalProperties()->where("property_id", 7)->first();
			$wweightValue = $request->new_weaning_weight;

			$wweight->value = $wweightValue;
			$wweight->save();

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function editTemporaryRegistryId(Request $request){
			$offspring = Animal::find($request->old_earnotch);
			$family = $offspring->getGrouping();
			$members = $family->getGroupingMembers();

			$offspringproperties = $offspring->getAnimalProperties();
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
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
				$registryid = $farm->code.$breed->breed."-".$birthdate->year.$sex.$earnotch;
				$offspring->registryid = $registryid;
				$offspring->status = "active";
				$offspring->save();

				$earnotchproperty = new AnimalProperty;
				$earnotchproperty->animal_id = $offspring->id;
				$earnotchproperty->property_id = 1;
				$earnotchproperty->value = $earnotch;
				$earnotchproperty->save();

				$registrationidproperty = new AnimalProperty;
				$registrationidproperty->animal_id = $offspring->id;
				$registrationidproperty->property_id = 4;
				$registrationidproperty->value = $registryid;
				$registrationidproperty->save();
			}

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function addWeaningWeights(Request $request){ // function to add weaning weights per offspring
			$grouping = Grouping::find($request->family_id);
			$offspring = Animal::find($request->offspring_id);

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

				$date_weaned_individual = new AnimalProperty;
				$date_weaned_individual->animal_id = $offspring->id;
				$date_weaned_individual->property_id = 6;
				$date_weaned_individual->value = $dateweanedprop->value;
				$date_weaned_individual->save();

				$weaningweight = new AnimalProperty;
				$weaningweight->animal_id = $offspring->id;
				$weaningweight->property_id = 7;
				$weaningweight->value = $request->weaning_weight;
				$weaningweight->save();
			}

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function fetchNewPigRecord(Request $request){ // function to add new pig
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = DB::Table('animals')->where("animaltype_id", 3)->where("breed_id", $breed->id)->pluck('registryid')->toArray();

			$temp_earnotch = $request->earnotch;
			$registrationid = "";
			if(strlen($temp_earnotch) > 6){
				$message = "Earnotch/ear tag is up to 6 characters only!";
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
				$newpig->status = $request->status_setter;
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

				$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("farm_id", $farm->id)->get();
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
				$message = "Successfully added new pig!";
				return view('pigs.addpig')->withMessage($message);
			}
			else{
				$message = "Registration ID already exists!";
				return view('pigs.addpig')->withError($message);
			}


		}

		public function fetchGrossMorphology(Request $request){ // function to add gross morphology data
			$animalid = $request->animal_id;

			// creates new properties
			$dcgross = new AnimalProperty;
			$hairtype = new AnimalProperty;
			$hairlength = new AnimalProperty;
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

			if(!is_null($request->display_photo)){
				$image = $request->file('display_photo');
				$input['image_name'] = $animal->id.'-'.$animal->registryid.'-display-photo'.'.'.$image->getClientOriginalExtension();
				$destination = public_path('/images');
				// $destination = base_path()."/images";
				$image->move($destination, $input['image_name']);

				DB::table('uploads')->insert(['animal_id' => $animal->id, 'animaltype_id' => 3, 'breed_id' => $animal->breed_id, 'filename' => $input['image_name']]);
			}

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

			return Redirect::back()->with('message','Animal record successfully saved');
		}

		public function fetchWeightRecords(Request $request){ // function to add weight records
			$animalid = $request->animal_id;
			$animal = Animal::find($animalid);
			$properties = $animal->getAnimalProperties();

			// used when date collected was not provided
			$bday = $properties->where("property_id", 3)->first();

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
			$photo = Uploads::where("animal_id", $animal->id)->first();

			$dcgross = $properties->where("property_id", 10)->first();
			if(is_null($request->date_collected_gross)){
				$dcgrossValue = new Carbon();
			}
			else{
				$dcgrossValue = $request->date_collected_gross;
			}
			$dcgross->value = $dcgrossValue;

			$hairtype = $properties->where("property_id", 11)->first();
			if(is_null($request->hair_type1)){
				$hairTypeValue = "Not specified";
			}
			else{
				$hairTypeValue = $request->hair_type1;
			}
			$hairtype->value = $hairTypeValue;

			$hairlength = $properties->where("property_id", 12)->first();
			if(is_null($request->hair_type2)){
				$hairLengthValue = "Not specified";
			}
			else{
				$hairLengthValue = $request->hair_type2;
			}
			$hairlength->value = $hairLengthValue;

			$coatcolor = $properties->where("property_id", 13)->first();
			if(is_null($request->coat_color)){
				$coatColorValue = "Not specified";
			}
			else{
				$coatColorValue = $request->coat_color;
			}
			$coatcolor->value = $coatColorValue;

			$colorpattern = $properties->where("property_id", 14)->first();
			if(is_null($request->color_pattern)){
				$colorPatternValue = "Not specified";
			}
			else{
				$colorPatternValue = $request->color_pattern;
			}
			$colorpattern->value = $colorPatternValue;

			$headshape = $properties->where("property_id", 15)->first();
			if(is_null($request->head_shape)){
				$headShapeValue = "Not specified";
			}
			else{
				$headShapeValue = $request->head_shape;
			}
			$headshape->value = $headShapeValue;

			$skintype = $properties->where("property_id", 16)->first();
			if(is_null($request->skin_type)){
				$skinTypeValue = "Not specified";
			}
			else{
				$skinTypeValue = $request->skin_type;
			}
			$skintype->value = $skinTypeValue;

			$eartype = $properties->where("property_id", 17)->first();
			if(is_null($request->ear_type)){
				$earTypeValue = "Not specified";
			}
			else{
				$earTypeValue = $request->ear_type;
			}
			$eartype->value = $earTypeValue;

			$tailtype = $properties->where("property_id", 18)->first();
			if(is_null($request->tail_type)){
				$tailTypeValue = "Not specified";
			}
			else{
				$tailTypeValue = $request->tail_type;
			}
			$tailtype->value = $tailTypeValue;

			$backline = $properties->where("property_id", 19)->first();
			if(is_null($request->backline)){
				$backlineValue = "Not specified";
			}
			else{
				$backlineValue = $request->backline;
			}
			$backline->value = $backlineValue;

			$othermarks = $properties->where("property_id", 20)->first();
			if(is_null($request->other_marks)){
				$otherMarksValue = "Not specified";
			}
			else{
				$otherMarksValue = $request->other_marks;
			}
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

			if(!is_null($photo)){
				if(!is_null($request->display_photo)){
					$image = $request->file('display_photo');
					$input['image_name'] = $animal->id.'-'.$animal->registryid.'-display-photo'.'.'.$image->getClientOriginalExtension();
					$destination = public_path('/images');
					// $destination = base_path()."/images";
					$image->move($destination, $input['image_name']);

					$photo->filename = $input['image_name'];
					$photo->save();
				}
			}
			else{
				if(!is_null($request->display_photo)){
					$image = $request->file('display_photo');
					$input['image_name'] = $animal->id.'-'.$animal->registryid.'display-photo'.'.'.$image->getClientOriginalExtension();
					$destination = public_path('/images');
					// $destination = base_path()."/images";
					$image->move($destination, $input['image_name']);

					DB::table('uploads')->insert(['animal_id' => $animal->id, 'animaltype_id' => 3, 'breed_id' => $animal->breed_id, 'filename' => $input['image_name']]);
				}
			}

			return Redirect::back()->with('message','Animal record successfully saved');
		}

		public function editMorphometricCharacteristics(Request $request){ // function to edit morphometric characteristics
			$animal = Animal::find($request->animal_id);
			$properties = $animal->getAnimalProperties();

			$dcmorpho = $properties->where("property_id", 21)->first();
			if(is_null($request->date_collected_morpho)){
				$dcmorphoValue = new Carbon();
			}
			else{
				$dcmorphoValue = $request->date_collected_morpho;
			}
			$dcmorpho->value = $dcmorphoValue;

			$earlength = $properties->where("property_id", 22)->first();
			if(is_null($request->ear_length)){
				$earLengthValue = "";
			}
			else{
				$earLengthValue = $request->ear_length;
			}
			$earlength->value = $earLengthValue;

			$headlength = $properties->where("property_id", 23)->first();
			if(is_null($request->head_length)){
				$headLengthValue = "";
			}
			else{
				$headLengthValue = $request->head_length;
			}
			$headlength->value = $headLengthValue;

			$snoutlength = $properties->where("property_id", 24)->first();
			if(is_null($request->snout_length)){
				$snoutLengthValue = "";
			}
			else{
				$snoutLengthValue = $request->snout_length;
			}
			$snoutlength->value = $snoutLengthValue;

			$bodylength = $properties->where("property_id", 25)->first();
			if(is_null($request->body_length)){
				$bodyLengthValue = "";
			}
			else{
				$bodyLengthValue = $request->body_length;
			}
			$bodylength->value = $bodyLengthValue;

			$heartgirth = $properties->where("property_id", 26)->first();
			if(is_null($request->heart_girth)){
				$heartGirthValue = "";
			}
			else{
				$heartGirthValue = $request->heart_girth;
			}
			$heartgirth->value = $heartGirthValue;

			$pelvicwidth = $properties->where("property_id", 27)->first();
			if(is_null($request->pelvic_width)){
				$pelvicWidthValue = "";
			}
			else{
				$pelvicWidthValue = $request->pelvic_width;
			}
			$pelvicwidth->value = $pelvicWidthValue;

			$taillength = $properties->where("property_id", 28)->first();
			if(is_null($request->tail_length)){
				$tailLengthValue = "";
			}
			else{
				$tailLengthValue = $request->tail_length;
			}
			$taillength->value = $tailLengthValue;

			$heightatwithers = $properties->where("property_id", 29)->first();
			if(is_null($request->height_at_withers)){
				$heightAtWithersValue = "";
			}
			else{
				$heightAtWithersValue = $request->height_at_withers;
			}
			$heightatwithers->value =  $heightAtWithersValue;

			$normalteats = $properties->where("property_id", 30)->first();
			if(is_null($request->number_normal_teats)){
				$normalTeatsValue = "";
			}
			else{
				$normalTeatsValue = $request->number_normal_teats;
			}
			$normalteats->value = $normalTeatsValue;

			$dcmorpho->save();
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

			$bweight = $properties->where("property_id", 5)->first();
			if(is_null($bweight)){
				if(is_null($request->birth_weight)){
					$bweightValue = "";
				}
				else{
					$bweightValue = $request->birth_weight;
				}
				$bweight_new = new AnimalProperty;
				$bweight_new->animal_id = $animal->id;
				$bweight_new->property_id = 5;
				$bweight_new->value = $bweightValue;
				$bweight_new->save();
			}
			else{
				if(is_null($request->birth_weight)){
					$bweightValue = "";
				}
				else{
					$bweightValue = $request->birth_weight;
				}
				$bweight->value = $bweightValue;
			}

			$wweight = $properties->where("property_id", 7)->first();
			if(is_null($wweight)){
				if(is_null($request->weaning_weight)){
					$wweightValue = "";
				}
				else{
					$wweightValue = $request->weaning_weight;
				}
				$wweight_new = new AnimalProperty;
				$wweight_new->animal_id = $animal->id;
				$wweight_new->property_id = 7;
				$wweight_new->value = $wweightValue;
				$wweight_new->save();
			}
			else{
				if(is_null($request->weaning_weight)){
					$wweightValue = "";
				}
				else{
					$wweightValue = $request->weaning_weight;
				}
				$wweight->value = $wweightValue;
			}

			$bw45d = $properties->where("property_id", 32)->first();
			if(is_null($bw45d)){
				if(is_null($request->body_weight_at_45_days)){
					$bw45dValue = "";
				}
				else{
					$bw45dValue = $request->body_weight_at_45_days;
				}
				$bw45d_new = new AnimalProperty;
				$bw45d_new->animal_id = $animal->id;
				$bw45d_new->property_id = 32;
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

			$bw60d = $properties->where("property_id", 33)->first();
			if(is_null($bw60d)){
				if(is_null($request->body_weight_at_60_days)){
					$bw60dValue = "";
				}
				else{
					$bw60dValue = $request->body_weight_at_60_days;
				}
				$bw60d_new = new AnimalProperty;
				$bw60d_new->animal_id = $animal->id;
				$bw60d_new->property_id = 33;
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

			$bw90d = $properties->where("property_id", 34)->first();
			if(is_null($bw90d)){
				if(is_null($request->body_weight_at_90_days)){
					$bw90dValue = "";
				}
				else{
					$bw90dValue = $request->body_weight_at_90_days;
				}
				$bw90d_new = new AnimalProperty;
				$bw90d_new->animal_id = $animal->id;
				$bw90d_new->property_id = 34;
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

			$bw150d = $properties->where("property_id", 35)->first();
			if(is_null($bw150d)){
				if(is_null($request->body_weight_at_150_days)){
					$bw150dValue = "";
				}
				else{
					$bw150dValue = $request->body_weight_at_150_days;
				}
				$bw150d_new = new AnimalProperty;
				$bw150d_new->animal_id = $animal->id;
				$bw150d_new->property_id = 35;
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

			$bw180d = $properties->where("property_id", 36)->first();
			if(is_null($bw180d)){
				if(is_null($request->body_weight_at_180_days)){
					$bw180dValue = "";
				}
				else{
					$bw180dValue = $request->body_weight_at_180_days;
				}
				$bw180d_new = new AnimalProperty;
				$bw180d_new->animal_id = $animal->id;
				$bw180d_new->property_id = 36;
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

			$bday = $properties->where("property_id", 3)->first();

			$dateweaned = $properties->where("property_id", 6)->first();
			if(is_null($dateweaned)){
				if(is_null($request->date_weaned)){
					if(!is_null($bday) && $bday->value != "Not specified"){
						$dateweanedValue = Carbon::parse($bday->value)->addDays(45)->toDateString();
					}
					else{
						$dateweanedValue = "";
					}
				}
				else{
					$dateweanedValue = $request->date_weaned;
				}
				$dateweaned_new = new AnimalProperty;
				$dateweaned_new->animal_id = $animal->id;
				$dateweaned_new->property_id = 6;
				$dateweaned_new->value = $dateweanedValue;
				$dateweaned_new->save();
			}
			else{
				if(is_null($request->date_weaned)){
					if(!is_null($bday) && $bday->value != "Not specified"){
						$dateweanedValue = Carbon::parse($bday->value)->addDays(45)->toDateString();
					}
					else{
						$dateweanedValue = "";
					}
				}
				else{
					$dateweanedValue = $request->date_weaned;
				}
				$dateweaned->value = $dateweanedValue;
			}

			$dc45d = $properties->where("property_id", 37)->first();
			if(is_null($dc45d)){
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
				$dc45d_new = new AnimalProperty;
				$dc45d_new->animal_id = $animal->id;
				$dc45d_new->property_id = 37;
				$dc45d_new->value = $dc45dValue;
				$dc45d_new->save();
			}
			else{
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
				$dc45d->value = $dc45dValue;
			}

			$dc60d = $properties->where("property_id", 38)->first();
			if(is_null($dc60d)){
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
				$dc60d_new = new AnimalProperty;
				$dc60d_new->animal_id = $animal->id;
				$dc60d_new->property_id = 38;
				$dc60d_new->value = $dc60dValue;
				$dc60d_new->save();
			}
			else{
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
				$dc60d->value = $dc60dValue;
			}

			$dc90d = $properties->where("property_id", 39)->first();
			if(is_null($dc90d)){
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
				$dc90d_new = new AnimalProperty;
				$dc90d_new->animal_id = $animal->id;
				$dc90d_new->property_id = 39;
				$dc90d_new->value = $dc90dValue;
				$dc90d_new->save();
			}
			else{
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
				$dc90d->value = $dc90dValue;
			}

			$dc150d = $properties->where("property_id", 40)->first();
			if(is_null($dc150d)){
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
				$dc150d_new = new AnimalProperty;
				$dc150d_new->animal_id = $animal->id;
				$dc150d_new->property_id = 40;
				$dc150d_new->value = $dc150dValue;
				$dc150d_new->save();
			}
			else{
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
				$dc150d->value = $dc150dValue;
			}

			$dc180d = $properties->where("property_id", 41)->first();
			if(is_null($dc180d)){
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
				$dc180d_new = new AnimalProperty;
				$dc180d_new->animal_id = $animal->id;
				$dc180d_new->property_id = 41;
				$dc180d_new->value = $dc180dValue;
				$dc180d_new->save();
			}
			else{
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
				$dc180d->value = $dc180dValue;
			}

			$bweight->save();
			$wweight->save();
			$bw45d->save();
			$bw60d->save();
			$bw90d->save();
			$bw150d->save();
			$bw180d->save();
			$dateweaned->save();
			$dc45d->save();
			$dc60d->save();
			$dc90d->save();
			$dc150d->save();
			$dc180d->save();

			return Redirect::back()->with('message','Animal record successfully saved');
		}

		public function addMortalityRecord(Request $request){ // function to add mortality record
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$dead = Animal::find($request->animal_id);

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

			DB::table('mortalities')->insert(['animal_id' => $dead->id, 'animaltype_id' => 3, 'breed_id' => $breed->id, 'datedied' => $dateDiedValue, 'cause' => $causeDeathValue, 'age' => $age]);

			return redirect()->route('farm.pig.mortality_and_sales');
		}

		public function addSalesRecord(Request $request){ // function to add sales record
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$sold = Animal::find($request->animal_id);

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

			DB::table('sales')->insert(['animal_id' => $sold->id, 'animaltype_id' => 3, 'breed_id' => $breed->id, 'datesold' => $dateSoldValue, 'weight' => $weightSoldValue, 'price' => $priceValue, 'age' => $age]);

			return redirect()->route('farm.pig.mortality_and_sales');
		}

		public function addRemovedAnimalRecord(Request $request){ // function to add removed (culled/donated) animal records
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$removed =  Animal::find($request->animal_id);

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

			DB::table('removed_animals')->insert(['animal_id' => $removed->id, 'animaltype_id' => 3, 'breed_id' => $breed->id, 'dateremoved' => $dateRemovedValue, 'reason' => $reasonRemovedValue, 'age' => $age]);


			return redirect()->route('farm.pig.mortality_and_sales');
		}

		public function addFarmProfile(Request $request){ // function to add farm profile
			$user = Auth::User();
			$farm = $user->getFarm();
			$breed = $farm->getBreed();
			$photo = Uploads::whereNull("animal_id")->whereNull("animaltype_id")->where("breed_id", $breed->id)->first();

			$farm->region = $request->region;
			$farm->province = $request->province;
			$farm->town = $request->town;
			$farm->barangay = $request->barangay;
			$user->phone = $request->phone_number;
			$farm->save();

			if(!is_null($photo)){
				if(!is_null($request->farm_picture)){
					$image = $request->file('farm_picture');
					$input['image_name'] = $farm->code.'-'.$user->name.'-display-photo'.'.'.$image->getClientOriginalExtension();
					$destination = public_path('/images');
					// $destination = base_path()."/images";
					$image->move($destination, $input['image_name']);

					$photo->filename = $input['image_name'];
					$photo->save();
				}
			}
			else{
				if(!is_null($request->farm_picture)){
					$image = $request->file('farm_picture');
					$input['image_name'] = $farm->code.'-'.$user->name.'-display-photo'.'.'.$image->getClientOriginalExtension();
					$destination = public_path('/images');
					// $destination = base_path()."/images";
					$image->move($destination, $input['image_name']);

					DB::table('uploads')->insert(['breed_id' => $breed->id, 'filename' => $input['image_name']]);
				}
			}

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  \App\Models\Farm  $farm
		 * @return \Illuminate\Http\Response
		 */


}
