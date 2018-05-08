<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'properties';
    public $timestamps = false;

    public function groupings()
    {
      return $this->belongsTo('App\Models\Grouping');
    }

    public function animalproperties()
    {
      return $this->belongsTo('App\Models\AnimalProperty');
    }


}
