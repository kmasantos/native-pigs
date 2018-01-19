<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AnimalProperty;

class Animal extends Model
{

  protected $table = 'animals';
  protected $fillable = [
      'registryid',
      'status'
  ];

  /*
    Eloquent ORM
  */
  public function farms(){
    return $this->belongsTo('App\Models\Farm');
  }

  public function animaltype()
  {
      return $this->belongsTo('App\Models\AnimalType');
  }

  public function breeds()
  {
    return $this->belongsTo('App\Models\Breed');
  }

  public function groupings()
  {
    return $this->hasMany('App\Models\Grouping');
  }

  public function animalproperties()
  {
    return $this->belongsTo('App\Models\AnimalProperty');
  }

  public function sales()
  {
    return $this->hasOne('App\Models\Sale');
  }

  public function weights()
  {
    return $this->hasMany('App\Models\Weight');
  }

  public function mortalities()
  {
    return $this->hasOne('App\Models\Mortality');
  }


  /*
    Model Functions
  */
  public function getAnimalType(){
    return $this->animaltype_id;
  }
  public function getFarmId(){
    return $this->farm_id;
  }

  public function getBreedId(){
    return $this->breed_id;
  }

  public function getStatus()
  {
    return $this->status;
  }

  public function setAnimalType($animaltype_id){
      $this->animaltype = $animaltype_id;
  }

  public function setBreed($breed_id){
      $this->breed_id = $breed_id;
  }

  public function setFarm($farm_id){
    $this->farm_id = $farm_id;
  }

  public function setStatus($status)
  {
    $this->status = $status;
  }

  public function getAnimalProperties()
  {
    $properties = AnimalProperty::where('animal_id', $this->id)->get();
    return $properties;
  }

}
