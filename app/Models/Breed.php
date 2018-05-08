<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    protected $table = 'breeds';
    public $timestamps = false;
    public function animaltypes()
    {
      return $this->belongsTo('App\Models\Breed');
    }

    public function animals()
    {
      return $this->hasMany('App\Models\Animal');
    }

    public function farms()
    {
      return $this->belongsTo('App\Models\Farm');
    }
    
}
