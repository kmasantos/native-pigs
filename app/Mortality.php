<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class Mortality extends Model
{
	protected $table = 'mortalities';
  public $timestamps = false;
  protected $fillable = [
    'datedied',
    'cause',
    'age'
  ];

  public function animals()
  {
    return $this->belongsTo('App\Models\Animal');
  }

  public function animaltype()
  {
      return $this->belongsTo('App\Models\AnimalType');
  }

  public function breeds()
  {
    return $this->belongsTo('App\Models\Breed');
  }

  public function getAnimalType(){
    return $this->animaltype_id;
  }

  public function getBreed(){
    return $this->breed_id;
  }

  public function getDateDied(){
    return $this->datedied;
  }

  public function getCause(){
    return $this->cause;
  }

  public function getAge(){
    return $this->age;
  }

  public function setAnimalType($animaltype_id){
    $this->animaltype_id = $animaltype_id;
  }

  public function setBreed($breed_id){
    $this->breed_id = $breed_id;
  }

  public function setDateDied($datedied){
    $this->datedied = $datedied;
  }

  public function setCause($cause){
    $this->cause = $cause;
  }

  public function setAge($age){
    $this->age = $age;
  }

  public function getRegistryId(){
    return Animal::find($this->animal_id)->registryid;
  }
  
}
