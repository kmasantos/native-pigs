<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Breed;

class AnimalType extends Model
{
    public $timestamps = false;
    protected $table = 'animal_types';

    public function animals()
   {
       return $this->hasMany('App\Models\Animal');
   }

   public function breeds()
   {
     return $this->hasMany('App\Models\Breed');
   }

   public function farms()
   {
     return $this->belongsToMany('App\Models\Farm', 'farm_animaltypes', 'animaltype_id', 'farm_id');
   }


}
