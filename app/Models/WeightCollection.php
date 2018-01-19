<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeightCollection extends Model
{
  public function weights()
  {
    return $this->belongsTo('App\Models\Animal');
  }
}
