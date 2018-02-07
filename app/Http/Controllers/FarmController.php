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

          $sowcount = count($sows);
          $boarcount = count($boars);
          
          return view('pigs.dashboard', compact('user', 'farm', 'pigs', 'sows', 'boars', 'sowcount', 'boarcount'));
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

    /*
    public function getAddSowRecordPage(){
      return view('pigs.addsow');
    }

    public function getAddBoarRecordPage(){
      return view('pigs.addboar');
    }
    */

    public function getAddSowLitterRecordPage($id){
      $family = Grouping::find($id);
      $properties = $family->getGroupingProperties();
      $offsprings = $family->getGroupingMembers();
      // $pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();
      // $family = Grouping::whereNotNull("mother_id")->get();

      // $sows = [];
      // $boars = [];
      // foreach($pigs as $pig){
      //   if(substr($pig->registryid, -6, 1) == 'F'){
      //     array_push($sows, $pig);
      //   }
      //   if(substr($pig->registryid, -6, 1) == 'M'){
      //     array_push($boars, $pig);
      //   }
      // }

      // foreach ($family as $group) {
      //   $gproperties = $group->getGroupingProperties();
      //   $offsprings = $group->getGroupingMembers();
      // }

      // // dd($iproperties);

      return view('pigs.sowlitterrecord', compact('family', 'offsprings', 'properties'));
    }

    public function getMatingRecordPage(){
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

      foreach ($family as $group) {
        $properties = $group->getGroupingProperties();
      }

      return view('pigs.matingrecord', compact('pigs', 'sows', 'boars', 'family', 'properties', 'mothers', 'fathers'));
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

      return view('pigs.mortalityandsales', compact('pigs', 'breeders', 'sold', 'dead', 'removed', 'age'));
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

    public function getViewSowPage($id){
      $sow = Animal::find($id);
      $properties = $sow->getAnimalProperties();
      // dd($properties);

      $now = Carbon::now();
      $end_date = Carbon::parse($properties->where("property_id", 25)->first()->value);

      //dd($now, $end_date);
      $age = $now->diffInMonths($end_date);

      return view('pigs.viewsow', compact('sow', 'properties', 'age'));
    }

    public function getViewBoarPage($id){
      $boar = Animal::find($id);
      $properties = $boar->getAnimalProperties();

      $now = Carbon::now();
      $end_date = Carbon::parse($properties->where("property_id", 25)->first()->value);

      //dd($now, $end_date);
      $age = $now->diffInMonths($end_date);

      return view('pigs.viewboar', compact('boar', 'properties', 'age'));
    }

    public function getGrossMorphologyPage($id){
      $animal = Animal::find($id);
      $properties = $animal->getAnimalProperties();

      return view('pigs.grossmorphology', compact('animal', 'properties'));
    }

    public function getMorphometricCharsPage($id){
      $animal = Animal::find($id);
      $properties = $animal->getAnimalProperties();

      return view('pigs.morphometriccharacteristics', compact('animal', 'properties'));
    }

    public function getWeightRecordsPage($id){
      $animal = Animal::find($id);
      $properties = $animal->getAnimalProperties();

      return view('pigs.weightrecords', compact('animal', 'properties'));
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

    public function addMatingRecord(Request $request){
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

    /*
    public function addOffspring(Request $request){
      $now = new Carbon;
      $offspring = new Animal;
      $farm = $this->user->getFarm();
      $breed = $farm->getBreed();
      $offspring->animaltype_id = 3;
      $offspring->farm_id = $farm->id;
      $offspring->breed_id = $breed->id;
      $offspring->status = "breeder";
      $offspring->registryid = $farm->code."-".$now->year.$request->sex.$request->offspring_earnotch;
      $offspring->save();

      $sex = new AnimalProperty;
      $sex->animal_id = $offspring->id;
      $sex->property_id = 27;
      $sex->value = $request->sex;
      $sex->save();

      if(is_null($request->litter_remarks)){
        $remarksValue = "None";
      }
      else{
        $remarksValue = $request->litter_remarks;
      }

      $remarks = new AnimalProperty;
      $remarks->animal_id = $offspring->id;
      $remarks->property_id = 52;
      $remarks->value = $remarksValue;
      $remarks->save();

      $birthweight = new AnimalProperty;
      $birthweight->animal_id = $offspring->id;
      $birthweight->property_id = 53;
      $birthweight->value = $request->birth_weight;
      $birthweight->save();

      $weaningweight = new AnimalProperty;
      $weaningweight->animal_id = $offspring->id;
      $weaningweight->property_id = 54;
      $weaningweight->value = $request->weaning_weight;
      $weaningweight->save();

      $groupingmember = new GroupingMember;
      $groupingmember->grouping_id = $grouping->id;
      $groupingmember->animal_id = $offspring->id;
      $groupingmember->save();

      return Redirect::back()->with('message','Operation Successful!');
    }
    */
  
    public function addSowLitterRecord(Request $request){
      $grouping = Grouping::find($request->grouping_id);

      $birthday = new Carbon($request->date_farrowed);
      $offspring = new Animal;
      $farm = $this->user->getFarm();
      $breed = $farm->getBreed();
      $offspring->animaltype_id = 3;
      $offspring->farm_id = $farm->id;
      $offspring->breed_id = $breed->id;
      $offspring->status = "active";
      $offspring->registryid = $farm->code.$breed->breed."-".$birthday->year.$request->sex.$request->offspring_earnotch;
      $offspring->save();

      $sex = new AnimalProperty;
      $sex->animal_id = $offspring->id;
      $sex->property_id = 27;
      $sex->value = $request->sex;
      $sex->save();

      /*
      if(is_null($request->litter_remarks)){
        $remarksValue = "None";
      }
      else{
        $remarksValue = $request->litter_remarks;
      }

      $remarks = new AnimalProperty;
      $remarks->animal_id = $offspring->id;
      $remarks->property_id = 52;
      $remarks->value = $remarksValue;
      $remarks->save();
      */

      $birthweight = new AnimalProperty;
      $birthweight->animal_id = $offspring->id;
      $birthweight->property_id = 53;
      $birthweight->value = $request->birth_weight;
      $birthweight->save();

      $weaningweight = new AnimalProperty;
      $weaningweight->animal_id = $offspring->id;
      $weaningweight->property_id = 54;
      $weaningweight->value = $request->weaning_weight;
      $weaningweight->save();

      $groupingmember = new GroupingMember;
      $groupingmember->grouping_id = $grouping->id;
      $groupingmember->animal_id = $offspring->id;
      $groupingmember->save();

      $date_farrowed = new GroupingProperty;
      $date_farrowed->grouping_id = $grouping->id;
      $date_farrowed->property_id = 25;
      $date_farrowed->value = $request->date_farrowed;
      $date_farrowed->datecollected = new Carbon();
      $date_farrowed->save();

      $date_weaned = new GroupingProperty;
      $date_weaned->grouping_id = $grouping->id;
      $date_weaned->property_id = 61;
      $date_weaned->value = $request->date_weaned;
      $date_weaned->datecollected = new Carbon();
      $date_weaned->save();

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
      $ponderalindex = new AnimalProperty;
      $normalteats = new AnimalProperty;

      // $agefirstmating->animal_id = $boar_id;
      // $agefirstmating->property_id = 37;
      // $agefirstmating->value =  $request->age_at_first_mating;

      // $finalweight->animal_id = $sow_id;
      // $finalweight->property_id = 38;
      // $finalweight->value = $finalWeightValue;

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


      if(is_null($request->body_length) || is_null($request->body_weight_at_180_days)){
        $ponderalIndexValue = "";
      }
      else{
        $ponderalIndexValue = $request->body_weight_at_180_days/(($request->body_length/100)**3);
      }

      $ponderalindex->animal_id = $animalid;
      $ponderalindex->property_id = 43;
      $ponderalindex->value = $ponderalIndexValue;

      $animal = Animal::find($animalid);

      if($animal->getAnimalProperties()->where("property_id", 27)->first()->value == 'F'){
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
      }

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
      $ponderalindex->save();

      $animal->morphometric = 1;
      $animal->save();

      return Redirect::back()->with('message','Animal record successfully saved');
    }

    public function fetchWeightRecords(Request $request){
      $animalid = $request->animal_id;

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
        $dc45dValue = new Carbon();
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
        $dc60dValue = new Carbon();
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
        $dc90dValue = new Carbon();
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
        $dc180dValue = new Carbon();
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

      $cause_death = new AnimalProperty;
      $cause_death->animal_id = $dead->id;
      $cause_death->property_id = 71;
      $cause_death->value = $request->cause_death;
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

      $weight_sold = new AnimalProperty;
      $weight_sold->animal_id = $sold->id;
      $weight_sold->property_id = 57;
      $weight_sold->value = $request->weight_sold;
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

    /*
    public function getRecords($request, $animal)
    {
      $hairtype = $request->hairtype1.",".$request->hairtype2.",".$request->hairtype3;
      $tusks = $request->tusks;
      $snout = $request->snout;
      $coat = $request->coat;
      $pattern = $request->pattern;
      $headshape = $request->headshape;
      $skintype = $request->skin;
      $eartype = $request->eartype;
      $earorientation = $request->earorientation;
      $tailtype = $request->tailtype;
      $backline = $request->backline;
      $othermarks = $request->othermarks;

      $agefirstmating = $request->agefirstmating;
      $weightprior = $request->weightprior;
      $weighteight = $request->weighteight;
      $headlength = $request->headlength;
      $bodylength = $request->bodylength;
      $pelvic = $request->pelvic;
      $heartgirth = $request->hearthgirth;
      $ponderalindex = $request->ponderalindex;
      $normalteats = $request->normalteats;

      if(!is_null($hairtype)){
        $hairtypeprop = new AnimalProperty;
        $hairtypeprop->animal_id = $animal->id;
        $hairtypeprop->property_id = Property::where('name', $request->hairtypelabel)->first()->id;
        $hairtypeprop->value = $hairtype;
        $hairtypeprop->save();
      }

      if(!is_null($tusks)){
        $tuskprop = new AnimalProperty;
        $tuskprop->animal_id = $animal->id;
        $tuskprop->property_id = Property::where('name', $request->tusklabel)->first()->id;
        $tuskprop->value = $tusks;
        $tuskprop->save();
      }

      if(!is_null($snout)){
        $snoutprop = new AnimalProperty;
        $snoutprop->animal_id = $animal->id;
        $snoutprop->property_id = Property::where('name', $request->snoutshapelabel)->first()->id;
        $snoutprop->value = $snout;
        $snoutprop->save();
      }

      if(!is_null($coat)){
        $coatprop = new AnimalProperty;
        $coatprop->animal_id = $animal->id;
        $coatprop->property_id = Property::where('name', $request->coatcolorlabel)->first()->id;
        $coatprop->value = $coat;
        $coatprop->save();
      }

      if(!is_null($pattern)){
        $patternprop = new AnimalProperty;
        $patternprop->animal_id = $animal->id;
        $patternprop->property_id = Property::where('name', $request->colorpatternlabel)->first()->id;
        $patternprop->value = $pattern;
        $patternprop->save();
      }

      if(!is_null($headshape)){
        $headshapeprop = new AnimalProperty;
        $headshapeprop->animal_id = $animal->id;
        $headshapeprop->property_id = Property::where('name', $request->headshapelabel)->first()->id;
        $headshapeprop->value = $headshape;
        $headshapeprop->save();
      }

      if(!is_null($skintype)){
        $skintypeprop = new AnimalProperty;
        $skintypeprop->animal_id = $animal->id;
        $skintypeprop->property_id = Property::where('name', $request->skintypelabel)->first()->id;
        $skintypeprop->value = $skintype;
        $skintypeprop->save();
      }

      if(!is_null($eartype)){
        $eartypeprop = new AnimalProperty;
        $eartypeprop->animal_id = $animal->id;
        $eartypeprop->property_id = Property::where('name', $request->eartypelabel)->first()->id;
        $eartypeprop->value = $eartype;
        $eartypeprop->save();
      }

      if(!is_null($earorientation)){
        $earorientationprop = new AnimalProperty;
        $earorientationprop->animal_id = $animal->id;
        $earorientationprop->property_id = Property::where('name', $request->earorientationlabel)->first()->id;
        $earorientationprop->value = $earorientation;
        $earorientationprop->save();
      }

      if(!is_null($tailtype)){
        $tailtypeprop = new AnimalProperty;
        $tailtypeprop->animal_id = $animal->id;
        $tailtypeprop->property_id = Property::where('name', $request->tailtypelabel)->first()->id;
        $tailtypeprop->value = $tailtype;
        $tailtypeprop->save();
      }

      if(!is_null($backline)){
        $backlineprop = new AnimalProperty;
        $backlineprop->animal_id = $animal->id;
        $backlineprop->property_id = Property::where('name', $request->backlinelabel)->first()->id;
        $backlineprop->value = $backline;
        $backlineprop->save();
      }

      if(!is_null($othermarks)){
        $othermarksprop = new AnimalProperty;
        $othermarksprop->animal_id = $animal->id;
        $othermarksprop->property_id = Property::where('name', $request->othermarkslabel)->first()->id;
        $othermarksprop->value = $othermarks;
        $othermarksprop->save();
      }

      if(!is_null($agefirstmating)){
        $agefirstmatingprop = new AnimalProperty;
        $agefirstmatingprop->animal_id = $animal->id;
        $agefirstmatingprop->property_id = Property::where('name', $request->ageatmatelabel)->first()->id;
        $agefirstmatingprop->value = $agefirstmating;
        $agefirstmatingprop->save();
      }

      if(!is_null($weightprior)){
        $weightpriorprop = new AnimalProperty;
        $weightpriorprop->animal_id = $animal->id;
        $weightpriorprop->property_id = Property::where('name', $request->bweighttofirstlabel)->first()->id;
        $weightpriorprop->value = $weightprior;
        $weightpriorprop->save();
      }

      if(!is_null($weighteight)){
        $weighteightprop = new AnimalProperty;
        $weighteightprop->animal_id = $animal->id;
        $weighteightprop->property_id = Property::where('name', $request->bweightfinallabel)->first()->id;
        $weighteightprop->value = $weighteight;
        $weighteightprop->save();
      }

      if(!is_null($headlength)){
        $headlengthprop = new AnimalProperty;
        $headlengthprop->animal_id = $animal->id;
        $headlengthprop->property_id = Property::where('name', $request->hlengthlabel)->first()->id;
        $headlengthprop->value = $headlength;
        $headlengthprop->save();
      }

      if(!is_null($bodylength)){
        $bodylengthprop = new AnimalProperty;
        $bodylengthprop->animal_id = $animal->id;
        $bodylengthprop->property_id = Property::where('name', $request->blengthlabel)->first()->id;
        $bodylengthprop->value = $bodylength;
        $bodylengthprop->save();
      }

      if(!is_null($pelvic)){
        $pelvicprop = new AnimalProperty;
        $pelvicprop->animal_id = $animal->id;
        $pelvicprop->property_id = Property::where('name', $request->pwidthlabel)->first()->id;
        $pelvicprop->value = $pelvic;
        $pelvicprop->save();
      }

      if(!is_null($heartgirth)){
        $heartgirthprop = new AnimalProperty;
        $heartgirthprop->animal_id = $animal->id;
        $heartgirthprop->property_id = Property::where('name', $request->hgirthlabel)->first()->id;
        $heartgirthprop->value = $heartgirth;
        $heartgirthprop->save();
      }

      if(!is_null($ponderalindex)){
        $ponderalindexprop = new AnimalProperty;
        $ponderalindexprop->animal_id = $animal->id;
        $ponderalindexprop->property_id = Property::where('name', $request->pindexlabel)->first()->id;
        $ponderalindexprop->value = $ponderalindex;
        $ponderalindexprop->save();
      }

    }
    */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */

    /*
    public function addSowRecord(Request $request){
      $normalteats = $request->normalteats;
      // dd($hairtype.$tusks.$snout.$coat.$pattern.$headshape.$skintype.$eartype.$earorientation.$tailtype.$backline.$othermarks);
      // dd(!is_null($hairtype) , !is_null($tusks), !is_null($snout), !is_null($normalteats));

      $animal = new Animal;
      $farm = $this->user->getFarm();
      $animaltype = $farm->getFarmType();
      $breed = $farm->getBreed();
      $animal->animaltype_id = $animaltype->id;
      $animal->farm_id = $farm->id;
      $animal->breed_id = $breed->id;
      $animal->registryid = $farm->code."-".$request->yearofbirth."F".$request->earnotchnumber;
      $animal->save();

      $this->getRecords($request, $animal);

      if(!is_null($normalteats)){
        $normalteatsprop = new AnimalProperty;
        $normalteatsprop->animal_id = $animal->id;
        $normalteatsprop->property_id = Property::where('name', $request->normalteatslabel)->first()->id;
        $normalteatsprop->value = $normalteats;
        $normalteatsprop->save();
      }

      return Redirect::back()->with('message','Sow record successfully saved');

    }

    public function addBoarRecord(Request $request){
      $animal = new Animal;
      $farm = $this->user->getFarm();
      $animaltype = $farm->getFarmType();
      $breed = $farm->getBreed();
      $animal->animaltype_id = $animaltype->id;
      $animal->farm_id = $farm->id;
      $animal->breed_id = $breed->id;
      $animal->registryid = $farm->code."-".$request->yearofbirth."M".$request->earnotchnumber;
      $animal->save();

      $this->getRecords($request, $animal);
      return Redirect::back()->with('message','Boar record successfully saved');
    }
    */

    //Functions for Chicken & Duck

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
