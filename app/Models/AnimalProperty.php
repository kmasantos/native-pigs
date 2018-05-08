<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalProperty extends Model
{
  protected $table = 'animal_properties';
  protected $fillable = [
    'value',
  ];

  public function properties()
  {
    return $this->hasMany('App\Models\Property');
  }

  public function animals()
  {
    return $this->hasMany('App\Models\Animal');
  }

}
