<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class RemovedAnimal extends Model
{
	protected $table = 'removed_animals';
  public $timestamps = false;
  protected $fillable = [
    'dateremoved',
    'reason',
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

  public function getDateRemoved(){
    return $this->dateremoved;
  }

  public function getReason(){
    return $this->reason;
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

  public function setDateRemoved($dateremoved){
    $this->dateremoved = $dateremoved;
  }

  public function setReason($reason){
    $this->reason = $reason;
  }

  public function setAge($age){
    $this->age = $age;
  }

  public function getRegistryId(){
    return Animal::find($this->animal_id)->registryid;
  }

  public function getStatus(){
    return Animal::find($this->animal_id)->status;
  }

}
