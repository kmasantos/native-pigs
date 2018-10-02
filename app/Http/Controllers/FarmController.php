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

					// static::addFrequency();
					
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

			return view('pigs.pedigree', compact('animal', 'registrationid', 'user', 'breed', 'sex', 'birthday', 'birthweight', 'group', 'malelitters', 'femalelitters', 'groupingmembers', 'parity', 'father_registryid', 'father_birthday', 'father_birthweight', 'father_group', 'father_malelitters', 'father_femalelitters', 'father_groupingmembers', 'father_parity', 'father_grandfather_registryid', 'father_grandfather_birthday', 'father_grandfather_birthweight', 'father_grandfather_group', 'father_grandfather_malelitters', 'father_grandfather_femalelitters', 'father_grandfather_groupingmembers', 'father_grandfather_parity', 'father_grandfather_greatgrandfather_registryid', 'father_grandfather_greatgrandfather_birthday', 'father_grandfather_greatgrandfather_birthweight', 'father_grandfather_greatgrandmother_registryid', 'father_grandfather_greatgrandmother_birthday', 'father_grandfather_greatgrandmother_birthweight', 'father_grandmother_registryid', 'father_grandmother_birthday', 'father_grandmother_birthweight', 'father_grandmother_group', 'father_grandmother_malelitters', 'father_grandmother_femalelitters', 'father_grandmother_groupingmembers', 'father_grandmother_parity', 'father_grandmother_greatgrandfather_registryid', 'father_grandmother_greatgrandfather_birthday', 'father_grandmother_greatgrandfather_birthweight', 'father_grandmother_greatgrandmother_registryid', 'father_grandmother_greatgrandmother_birthday', 'father_grandmother_greatgrandmother_birthweight', 'mother_registryid', 'mother_birthday', 'mother_birthweight', 'mother_group', 'mother_malelitters', 'mother_femalelitters', 'mother_groupingmembers', 'mother_parity', 'mother_grandfather_registryid', 'mother_grandfather_birthday', 'mother_grandfather_birthweight', 'mother_grandfather_group', 'mother_grandfather_malelitters', 'mother_grandfather_femalelitters', 'mother_grandfather_groupingmembers', 'mother_grandfather_parity', 'mother_grandfather_greatgrandfather_registryid', 'mother_grandfather_greatgrandfather_birthday', 'mother_grandfather_greatgrandfather_birthweight', 'mother_grandfather_greatgrandmother_registryid', 'mother_grandfather_greatgrandmother_birthday', 'mother_grandfather_greatgrandmother_birthweight', 'mother_grandmother_registryid', 'mother_grandmother_birthday', 'mother_grandmother_birthweight', 'mother_grandmother_group', 'mother_grandmother_malelitters', 'mother_grandmother_femalelitters', 'mother_grandmother_groupingmembers', 'mother_grandmother_parity', 'mother_grandmother_greatgrandfather_registryid', 'mother_grandmother_greatgrandfather_birthday', 'mother_grandmother_greatgrandfather_birthweight', 'mother_grandmother_greatgrandmother_registryid', 'mother_grandmother_greatgrandmother_birthday', 'mother_grandmother_greatgrandmother_birthweight'));
		}

		public static function findPig(Request $request){
			$temp_earnotch = $request->earnotch;
			$user = Auth::User();
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
			$earnotch = "temp";
			$registrationid = "temp";
			$animalid = 0;
			$earnotch_length = strlen($temp_earnotch);

			if($earnotch_length == 6){
				$earnotch = $temp_earnotch;
			}
			else{
				$earnotch = str_pad($temp_earnotch, 6, "0", STR_PAD_LEFT);
			}

			foreach ($pigs as $pig) {
				if(substr($pig->registryid, -6, 6) == $earnotch){
					$registrationid = $pig->registryid;
					$animalid = $pig->id;
				}
			}

			$animal = Animal::find($animalid);
	
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

			return view('pigs.pedigree', compact('animal', 'registrationid', 'user', 'breed', 'sex', 'birthday', 'birthweight', 'group', 'malelitters', 'femalelitters', 'groupingmembers', 'parity', 'father_registryid', 'father_birthday', 'father_birthweight', 'father_group', 'father_malelitters', 'father_femalelitters', 'father_groupingmembers', 'father_parity', 'father_grandfather_registryid', 'father_grandfather_birthday', 'father_grandfather_birthweight', 'father_grandfather_group', 'father_grandfather_malelitters', 'father_grandfather_femalelitters', 'father_grandfather_groupingmembers', 'father_grandfather_parity', 'father_grandfather_greatgrandfather_registryid', 'father_grandfather_greatgrandfather_birthday', 'father_grandfather_greatgrandfather_birthweight', 'father_grandfather_greatgrandmother_registryid', 'father_grandfather_greatgrandmother_birthday', 'father_grandfather_greatgrandmother_birthweight', 'father_grandmother_registryid', 'father_grandmother_birthday', 'father_grandmother_birthweight', 'father_grandmother_group', 'father_grandmother_malelitters', 'father_grandmother_femalelitters', 'father_grandmother_groupingmembers', 'father_grandmother_parity', 'father_grandmother_greatgrandfather_registryid', 'father_grandmother_greatgrandfather_birthday', 'father_grandmother_greatgrandfather_birthweight', 'father_grandmother_greatgrandmother_registryid', 'father_grandmother_greatgrandmother_birthday', 'father_grandmother_greatgrandmother_birthweight', 'mother_registryid', 'mother_birthday', 'mother_birthweight', 'mother_group', 'mother_malelitters', 'mother_femalelitters', 'mother_groupingmembers', 'mother_parity', 'mother_grandfather_registryid', 'mother_grandfather_birthday', 'mother_grandfather_birthweight', 'mother_grandfather_group', 'mother_grandfather_malelitters', 'mother_grandfather_femalelitters', 'mother_grandfather_groupingmembers', 'mother_grandfather_parity', 'mother_grandfather_greatgrandfather_registryid', 'mother_grandfather_greatgrandfather_birthday', 'mother_grandfather_greatgrandfather_birthweight', 'mother_grandfather_greatgrandmother_registryid', 'mother_grandfather_greatgrandmother_birthday', 'mother_grandfather_greatgrandmother_birthweight', 'mother_grandmother_registryid', 'mother_grandmother_birthday', 'mother_grandmother_birthweight', 'mother_grandmother_group', 'mother_grandmother_malelitters', 'mother_grandmother_femalelitters', 'mother_grandmother_groupingmembers', 'mother_grandmother_parity', 'mother_grandmother_greatgrandfather_registryid', 'mother_grandmother_greatgrandfather_birthday', 'mother_grandmother_greatgrandfather_birthweight', 'mother_grandmother_greatgrandmother_registryid', 'mother_grandmother_greatgrandmother_birthday', 'mother_grandmother_greatgrandmother_birthweight'));
		}

		public function fetchParityAjax($familyidvalue, $parityvalue){ // function to save parity onchange
			$grouping = Grouping::find($familyidvalue);
			$paritypropgroup = $grouping->getGroupingProperties()->where("property_id", 48)->first();

			$paritypropgroup->value = $parityvalue;
			$paritypropgroup->save();
		}

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
					$preweaningmortprop->value = round(((count($offsprings)-$weaned)/count($offsprings))*100, 4);
					$preweaningmortprop->save();
				}
			}

			static::addParityMother($family->id);


			return view('pigs.sowlitterrecord', compact('family', 'offsprings', 'properties', 'countMales', 'countFemales', 'aveBirthWeight', 'weaned', 'aveWeaningWeight'));
		}

		public function getBreedingRecordPage(){ // function to display Breeding Record page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();
			$family = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

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

			static::addFrequency();

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
			$deadpigs = Mortality::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
			$soldpigs = Sale::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
			$removedpigs = RemovedAnimal::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
			$growers = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "active")->get();
			$breeders = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();

			// TO FOLLOW: this will be used for filtering results
			$now = Carbon::now();
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			return view('pigs.mortalityandsales', compact('pigs', 'growers', 'breeders', 'soldpigs', 'deadpigs', 'removedpigs', 'years'));
		}

		public static function getNumPigsBornOnYear($year, $filter){ // function to get number of pigs born on specific year
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
							$bday = $pig->getAnimalProperties()->where("property_id", 3)->first()->value;
							$age = Carbon::parse($date_collected)->diffInMonths(Carbon::parse($bday));
							array_push($ages_collected, $age);
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

			return view('pigs.morphocharsreport', compact('pigs', 'filter', 'sows', 'boars', 'earlengths', 'headlengths', 'snoutlengths', 'bodylengths', 'heartgirths', 'pelvicwidths', 'ponderalindices', 'taillengths', 'heightsatwithers', 'normalteats', 'earlengths_sd', 'headlengths_sd', 'snoutlengths_sd', 'bodylengths_sd', 'heartgirths_sd', 'pelvicwidths_sd', 'ponderalindices_sd', 'taillengths_sd', 'heightsatwithers_sd', 'normalteats_sd', 'years', 'ages_collected', 'ages_collected_all', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars'));
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

			return view('pigs.morphocharsreport', compact('pigs', 'filter', 'sows', 'boars', 'earlengths', 'headlengths', 'snoutlengths', 'bodylengths', 'heartgirths', 'pelvicwidths', 'ponderalindices', 'taillengths', 'heightsatwithers', 'normalteats', 'earlengths_sd', 'headlengths_sd', 'snoutlengths_sd', 'bodylengths_sd', 'heartgirths_sd', 'pelvicwidths_sd', 'ponderalindices_sd', 'taillengths_sd', 'heightsatwithers_sd', 'normalteats_sd', 'years', 'ages_collected', 'ages_collected_all', 'alive', 'sold', 'dead', 'removed', 'sowsalive', 'soldsows', 'deadsows', 'removedsows', 'boarsalive', 'soldboars', 'deadboars', 'removedboars'));
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
				// age computation
				$firstbredsowsage = Carbon::parse($date_bredsow)->diffInMonths($bday_sow);
				array_push($firstbredsowsages, $firstbredsowsage);
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
									$bday_boar = Carbon::parse($bredboarproperty->value);
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
					}
				}
				// age computation
				$firstbredboarsage = Carbon::parse($date_bredboar)->diffInMonths($bday_boar);
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

			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

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
				$lsbavalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 50)->first()->value;
				array_push($lsba, $lsbavalue);
				$numbermalesvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 51)->first()->value;
				array_push($numbermales, $numbermalesvalue);
				$numberfemalesvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 52)->first()->value;
				array_push($numberfemales, $numberfemalesvalue);
				$stillbornvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 45)->first()->value;
				array_push($stillborn, $stillbornvalue);
				$mummifiedvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 46)->first()->value;
				array_push($mummified, $mummifiedvalue);
				$litterbwvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 55)->first()->value;
				array_push($litterbirthweights, $litterbwvalue);
				$avebwvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 56)->first()->value;
				array_push($avebirthweights, $avebwvalue);
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
						$adjww = ($wwprop->value*45)/$age;
						array_push($adjweaningweight, $adjww);
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
			set_time_limit(3600);
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

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
				$lsbavalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 50)->first()->value;
				array_push($lsba, $lsbavalue);
				$numbermalesvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 51)->first()->value;
				array_push($numbermales, $numbermalesvalue);
				$numberfemalesvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 52)->first()->value;
				array_push($numberfemales, $numberfemalesvalue);
				$stillbornvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 45)->first()->value;
				array_push($stillborn, $stillbornvalue);
				$mummifiedvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 46)->first()->value;
				array_push($mummified, $mummifiedvalue);
				$litterbwvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 55)->first()->value;
				array_push($litterbirthweights, $litterbwvalue);
				$avebwvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 56)->first()->value;
				array_push($avebirthweights, $avebwvalue);
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
						$adjww = ($wwprop->value*45)/$age;
						array_push($adjweaningweight, $adjww);
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
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

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
				$lsbavalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 50)->first()->value;
				array_push($lsba, $lsbavalue);
				$numbermalesvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 51)->first()->value;
				array_push($numbermales, $numbermalesvalue);
				$numberfemalesvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 52)->first()->value;
				array_push($numberfemales, $numberfemalesvalue);
				$stillbornvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 45)->first()->value;
				array_push($stillborn, $stillbornvalue);
				$mummifiedvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 46)->first()->value;
				array_push($mummified, $mummifiedvalue);
				$litterbwvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 55)->first()->value;
				array_push($litterbirthweights, $litterbwvalue);
				$avebwvalue = $groupwiththisparity->getGroupingProperties()->where("property_id", 56)->first()->value;
				array_push($avebirthweights, $avebwvalue);
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
						$adjww = ($wwprop->value*45)/$age;
						array_push($adjweaningweight, $adjww);
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

		public function getSowProductionPerformancePage($id){ // function to display Sow Production Performance page
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
			if(count($parities) >= 1){
				for($i = 0, $n = count($unsorted_farrowings); $i < $n; $i++){
					array_push($dates_farrowed, array_shift($temp_dates));
				}

				for($i = 1, $n = count($dates_farrowed); $i < $n; $i++){
					array_push($farrowing_intervals_text, "From Parity ".$i." to Parity ".($i+1).": ".$dates_farrowed[$i]->diffInDays($dates_farrowed[$i-1])."");
					$farrowing_intervals[] = $dates_farrowed[$i]->diffInDays($dates_farrowed[$i-1]);
				}

				$average = array_sum($farrowing_intervals)/count($farrowing_intervals);
				$farrowing_index =  365/$average;
			}

			return view('pigs.sowproductionperformance', compact('sow', 'properties', 'usage', 'parities', 'removed_first', 'farrowing_intervals_text', 'farrowing_index'));
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

		public function getBoarProductionPerformancePage($id){ // function to display Boar Production Performance page
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
					if(!is_null($thisoffspring->getAnimalProperties()->where("property_id", 6)->first())){
						$dateweanedprop = $thisoffspring->getAnimalProperties()->where("property_id", 6)->first();
						$bdayprop = $thisoffspring->getAnimalProperties()->where("property_id", 3)->first();
						if(!is_null($bdayprop) && $bdayprop->value != "Not specified"){
							$bday = $bdayprop->value;
						}
						$age = Carbon::parse($dateweanedprop->value)->diffInDays(Carbon::parse($bday));
						array_push($ageweaned, $age);
						$wwprop = $thisoffspring->getAnimalProperties()->where("property_id", 7)->first();
						$adjww = ($wwprop->value*45)/$age;
						array_push($adjweaningweight, $adjww);
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

		public function getMonthlyPerformanceReportPage(){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

			$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			// default filter is the current year
			$now = Carbon::now();
			$current_year = $now->year;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			$filter = $now->year;

			return view('pigs.monthlyperformance', compact('months', 'now', 'years', 'filter'));
		}

		public function filterMonthlyPerformance(Request $request){
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

			$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			// default filter is the current year
			$filter = $request->year_monthly_performance;

			$now = Carbon::now();
			$current_year = $filter;
			$range = range($current_year-10, $current_year+10);
			$years = array_combine($range, $range);

			return view('pigs.monthlyperformance', compact('months', 'now', 'years', 'filter'));
		}

		static function getMonthlyBred($filter, $month){
			$farm = Auth::User()->getFarm();
			$breed = $farm->getBreed();
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

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
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

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
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

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
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

			$lsbavalues = [];
			foreach ($groups as $group) {
				$groupingproperties = $group->getGroupingProperties();
				foreach ($groupingproperties as $groupingproperty) {
					if($groupingproperty->property_id == 3){ //date farrowed
						if(!is_null($groupingproperty) && $groupingproperty->value != "Not specified"){
							$datefarrowed = Carbon::parse($groupingproperty->value);
							if($datefarrowed->year == $filter && $datefarrowed->format('F') == $month){
								$lsba = $group->getGroupingProperties()->where("property_id", 50)->first()->value;
								array_push($lsbavalues, $lsba);
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
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

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
			$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

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
			
			// sorts male pigs into jr and sr boars
			$jrboars = []; // less than 1 year old
			$srboars = []; // at least 1 year old
			$noage = [];
			foreach ($boars as $boar) {
				$iproperties = $boar->getAnimalProperties();
				foreach ($iproperties as $iproperty) {
					if($iproperty->property_id == 3){ // date farrowed
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
			$templactating = [];
			foreach ($groups as $group) {
				$gproperties = $group->getGroupingProperties();
				foreach ($gproperties as $gproperty) {
					if($gproperty->property_id == 42){ // date bred
						if(Carbon::parse($gproperty->value)->month == $now->month && Carbon::parse($gproperty->value)->year == $now->year){
							if(Carbon::parse($gproperty->value)->lte($now)){
								if($group->getGroupingProperties()->where("property_id", 60)->first()->value == "Bred"){
									$bred = $group->getMother();
									if($bred->status == "breeder"){
										array_push($breds, $bred);
									}
								}
							}
						}
						if($now->gte(Carbon::parse($gproperty->value)) && Carbon::parse($gproperty->value)->addDays(114)->gte($now)){
							$pregnant = $group->getMother();
							if($pregnant->status == "breeder"){
								array_push($pregnantsows, $pregnant);
							}
						}
					}
					if($gproperty->property_id == 60){ //status
						if($gproperty->value == "Pregnant"){
							$pregnant = $group->getMother();
							if($pregnant->status == "breeder"){
								array_push($pregnantsows, $pregnant);
							}
						}
					}
					if($gproperty->property_id == 3){ // date farrowed
						if($now->gte(Carbon::parse($gproperty->value))){
							if(is_null($group->getGroupingProperties()->where("property_id", 6)->first())){
								$lactating = $group->getMother();
								if($lactating->status == "breeder"){
									array_push($templactating, $lactating);
								}
							}
						}
					}
				}
			}
			$intersection = array_intersect($pregnantsows, array_unique($templactating));
			$lactatingsows = array_diff(array_unique($templactating), $intersection);

			// sorts female pigs into gilts and sows which were bred at least once
			$gilts = [];
			$bredsows = [];
			foreach ($sows as $sow) {
				$iproperties = $sow->getAnimalProperties();
				foreach ($iproperties as $iproperty) {
					if($iproperty->property_id == 61){ // frequency
						if($iproperty->value == 0){
							array_push($gilts, $sow);
						}
					}
				}
			}

			// static::addFrequency();

			$drysows = count($sows) - (count($breds) + count($pregnantsows) + count($lactatingsows) + count($gilts));
			

			return view('pigs.breederinventory', compact('pigs', 'sows', 'boars', 'groups', 'frequency', 'breds', 'pregnantsows', 'lactatingsows', 'drysows', 'gilts', 'jrboars', 'srboars', 'now', 'noage'));
		}

		public function getGrowerInventoryPage(){ // function to display Grower Inventory page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where(function ($query) {
										$query->where("status", "active")
													->orWhere("status", "sold grower")
													->orWhere("status", "dead grower")
													->orWhere("status", "removed grower");
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

		public function getMortalityAndSalesReportPage(){ // function to display Mortality and Sales Report page
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$deadpigs = Mortality::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
			$soldpigs = Sale::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
			$removedpigs = RemovedAnimal::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();
			$now = Carbon::now();

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
			
			$months = ["December", "November", "October", "September", "August", "July", "June", "May", "April", "March", "Febraury", "January"];
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
			$removedpigs = RemovedAnimal::where("animaltype_id", 3)->where("breed_id", $breed->id)->get();

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

		static function addFrequency(){
			$farm = Auth::User()->getFarm();
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

			if(!is_null($pigs)){
				// gets all groups available
				$groups = Grouping::whereNotNull("mother_id")->where("breed_id", $breed->id)->get();

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
			$pigs = Animal::where("animaltype_id", 3)->where("breed_id", $breed->id)->where("status", "breeder")->get();

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

			static::addPonderalIndices();

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
			}

			return view('pigs.viewsow', compact('sow', 'properties', 'age', 'ageAtWeaning', 'ageAtFirstMating', 'males', 'females', 'groups'));
		}

		public function getViewBoarPage($id){ // function to display View Boar page
			$boar = Animal::find($id);
			$properties = $boar->getAnimalProperties();

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
					$date_weaned = Carbon::parse($properties->where("property_id", 6)->first()->value);
					$bday = Carbon::parse($properties->where("property_id", 3)->first()->value);
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
				$birthday->value = $request->date_farrowed;
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
				$date_farrowed->value = $request->date_farrowed;
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
			$birthdayValue = new Carbon($request->date_farrowed);
			if(!is_null($request->offspring_earnotch) && !is_null($request->sex) && !is_null($request->birth_weight)){
				$offspring = new Animal;
				$farm = $this->user->getFarm();
				$breed = $farm->getBreed();
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
				$birthday->value = $request->date_farrowed;
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
				$date_farrowed->value = $request->date_farrowed;
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
			$birthdayValue = new Carbon($request->date_farrowed);
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
				$offspring->registryid = $farm->code.$breed->breed."-".$birthdayValue->year.$request->sex.$request->offspring_earnotch;
				$offspring->save();

				$birthday = new AnimalProperty;
				$birthday->animal_id = $offspring->id;
				$birthday->property_id = 3;
				$birthday->value = $request->date_farrowed;
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
				$date_farrowed->value = $request->date_farrowed;
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

		public function editTemporaryRegistryId(Request $request){
			$offspring = Animal::find($request->old_earnotch);

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

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function addWeaningWeights(Request $request){ // function to add weaning weights per offspring
			$grouping = Grouping::find($request->family_id);
			$offspring = Animal::where("registryid", $request->offspring_id)->first();

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
			$temp_earnotch = $request->earnotch;
			if(strlen($temp_earnotch) == 6){
				$earnotch = $temp_earnotch;
			}
			else{
				$earnotch = str_pad($temp_earnotch, 6, "0", STR_PAD_LEFT);
			}
			$sex = $request->sex;
			$birthdayValue = new Carbon($request->date_farrowed);
			$newpig = new Animal;
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
			$newpig->animaltype_id = 3;
			$newpig->farm_id = $farm->id;
			$newpig->breed_id = $breed->id;
			$newpig->status = $request->status_setter;

			if(is_null($request->date_farrowed)){
				$registryid = $farm->code.$breed->breed."-".$sex.$earnotch;

				$newpig->registryid = $registryid;
			}
			else{
				$registryid = $farm->code.$breed->breed."-".$birthdayValue->year.$sex.$earnotch;

				$newpig->registryid = $registryid;
			}
			$newpig->save();

			$earnotchproperty = new AnimalProperty;
			$earnotchproperty->animal_id = $newpig->id;
			$earnotchproperty->property_id = 1;
			$earnotchproperty->value = $earnotch;
			$earnotchproperty->save();

			$registrationidproperty = new AnimalProperty;
			$registrationidproperty->animal_id = $newpig->id;
			$registrationidproperty->property_id = 4;
			$registrationidproperty->value = $registryid;
			$registrationidproperty->save();

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

			$sex = new AnimalProperty;
			$sex->animal_id = $newpig->id;
			$sex->property_id = 2;
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
			$birthweight->property_id = 5;
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

			if(!is_null($request->dam) && !is_null($request->sire)){
				$grouping = new Grouping;

				foreach ($pigs as $pig) { // searches database for pig with same earnotch
					if(substr($pig->registryid, -6, 6) == $request->dam){
						$grouping->registryid = $pig->registryid;
						$grouping->mother_id = $pig->id;
						$founddam = 1;
					}
					if(substr($pig->registryid, -6, 6) == $request->sire){
						$grouping->father_id = $pig->id;
						$foundsire = 1;
					}
				}

				// if dam and/or father are not in the database, it will just be the new pig's property
				if($founddam != 1){
					$dam = new AnimalProperty;
					$dam->animal_id = $newpig->id;
					$dam->property_id = 8;
					$dam->value = $farm->code.$breed->breed."-"."F".$request->dam;
					$dam->save();

					$grouping->registryid = $damanimal->value;
					$grouping->mother_id = null;
				}
				if($foundsire != 1){
					$sire = new AnimalProperty;
					$sire->animal_id = $newpig->id;
					$sire->property_id = 9;
					$sire->value = $farm->code.$breed->breed."-"."M".$request->sire;
					$sire->save();
					$grouping->father_id = null;
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

						$date_weaned = new GroupingProperty;
						$date_weaned->grouping_id = $grouping->id;
						$date_weaned->property_id = 6;
						$date_weaned->value = $dateWeanedValue;
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

			// used when date collected was not provided
			$bday = $animal->getAnimalProperties()->where("property_id", 3)->first();

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
				$bw60dValue = "";
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
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
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

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		public function addSalesRecord(Request $request){ // function to add sales record
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
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

			return Redirect::back()->with('message','Operation Successful!');
		}

		public function addRemovedAnimalRecord(Request $request){ // function to add removed (culled/donated) animal records
			$farm = $this->user->getFarm();
			$breed = $farm->getBreed();
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

			DB::table('removed_animals')->insert(['animal_id' => $removed->id, 'animaltype_id' => 3, 'breed_id' => $breed->id, 'dateremoved' => $dateRemovedValue, 'reason' => $request->reason_removed, 'age' => $age]);


			return Redirect::back()->with('message','Operation Successful!');
		}

		public function addFarmProfile(Request $request){ // function to add farm profile
			$user = Auth::User();
			$farm = $user->getFarm();
			$breed = $farm->getBreed();

			$farm->region = $request->region;
			$farm->province = $request->province;
			$farm->town = $request->town;
			$farm->barangay = $request->barangay;
			$user->phone = $request->phone_number;
			$farm->save();

			return Redirect::back()->with('message', 'Operation Successful!');
		}

		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  \App\Models\Farm  $farm
		 * @return \Illuminate\Http\Response
		 */


}
