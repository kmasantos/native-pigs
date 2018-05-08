<?php

namespace App\Models;
use App\Models\AnimalType;
use App\Models\Breed;
use DB;

use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{

  protected $table = 'farms';
  public $timestamps = false;
  protected $fillable = [
      'name', 'code', 'address'
  ];

  public function animals()
  {
    return $this->hasMany('App\Models\Animal');
  }

  public function users()
  {
    return $this->hasMany('App\Models\User', 'farmable_id');
  }

  public function animaltypes()
  {
    return $this->belongsToMany('App\Models\AnimalType', 'farm_animaltypes', 'farm_id', 'animaltype_id')->withPivot('farm_animaltypes');
  }

  public function breeds()
  {
    return $this->hasOne('App\Models\Breed');
  }

  public function getFarmType()
  {
    $pivot = DB::table('farm_animaltypes')->where('farm_id', '=', $this->id)->first();
    $animaltype = AnimalType::where('id', $pivot->animaltype_id)->first();
    return $animaltype;

  }

  public function getBreed()
  {
    $breed = Breed::where('id', $this->breedable_id)->first();
    return $breed;
  }


}
