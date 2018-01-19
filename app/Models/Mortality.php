<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mortality extends Model
{

  public function mortalities()
  {
    return $this->belongsTo('App\Models\Animal');
  }
  
}
