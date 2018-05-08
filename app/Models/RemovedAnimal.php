<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RemovedAnimal extends Model
{

  public function removedanimals()
  {
    return $this->belongsTo('App\Models\Animal');
  }
  
}
