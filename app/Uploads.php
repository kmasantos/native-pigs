<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class Uploads extends Model
{
  protected $table = 'uploads';
  public $timestamps = false;
  protected $fillable = [
    'directory'
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

  public function getFilename(){
    return $this->filename;
  }

  public function setAnimalType($animaltype_id){
    $this->animaltype_id = $animaltype_id;
  }

  public function setBreed($breed_id){
    $this->breed_id = $breed_id;
  }

  public function getRegistryId(){
    return Animal::find($this->animal_id)->registryid;
  }

}
