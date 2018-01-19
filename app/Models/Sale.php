<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

  public function sales()
  {
    return $this->belongsTo('App\Models\Animal');
  }

}
