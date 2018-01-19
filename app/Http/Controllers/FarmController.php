<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Farm;
use App\Models\Animal;
use App\Models\Property;
use App\Models\AnimalType;
use App\Models\AnimalProperty;
use App\Models\Breed;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


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
          return view('pigs.dashboard', compact('user', 'farm'));
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

    public function getAddSowRecordPage(){
      return view('pigs.addsow');
    }

    public function getAddBoarRecordPage(){
      return view('pigs.addboar');
    }

    public function getAddSowLitterRecordPage(){
      return view('pigs.addsowlitter');
    }

    public function getAnimalRecordPage(){

      return view('pigs.animalrecords');
    }

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
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

    public function getPageAddToFamily(){
      return view('poultry.chicken.breeder.addtofamily');
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

    /*
      @TODO Fix Date in request sent
    */

    public function addReplacementIndividualRecord(Request $request){
      $now = new Carbon;
      $animal = new Animal;
      $farm = $this->user->getFarm();
      $breed = $farm->getBreed();
      $animaltype = $farm->getFarmType();
      $registryid = $farm->code.'-'.$now->year.$request->gender.$request->generation.$request->line.$request->family.$request->individual_id;

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
        $replacement = Animal::where('status', 'replacement')->get();
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
      $replacement = Animal::where('status', 'replacement')->get();
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
      $replacement = Animal::where('status', 'replacement')->get();
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
