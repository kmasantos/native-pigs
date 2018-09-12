<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class Sale extends Model
{

	protected $table = 'sales';
  public $timestamps = false;
  protected $fillable = [
    'datesold',
    'weight',
    'price',
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

  public function getDateSold(){
    return $this->datesold;
  }

  public function getWeight(){
    return $this->weight;
  }

  public function getPrice(){
    return $this->price;
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

  public function setDateSold($datesold){
    $this->datesold = $datesold;
  }

  public function setWeight($weight){
    $this->weight = $weight;
  }

  public function setPrice($price){
    $this->price = $price;
  }

  public function setAge($age){
    $this->age = $age;
  }

  public function getRegistryId(){
    return Animal::find($this->animal_id)->registryid;
  }

}
