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
use Illuminate\Support\Facades\Redirect;
use DB;

use Illuminate\Http\Request;

class HelperController extends Controller
{
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

    public static function getWeightsPerYearOfBirth($year, $property_id){
     $pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

     $bornonyear = [];
     foreach ($pigs as $pig) {
         if(substr($pig->registryid, -10, 4) == $year){
          array_push($bornonyear, $pig);
        }
     }

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
}
