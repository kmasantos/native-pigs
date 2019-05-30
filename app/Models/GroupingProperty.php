<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupingProperty extends Model
{
  protected $table = 'grouping_properties';
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

  public function groupings()
  {
    return $this->belongsTo('App\Models\Grouping');
  }

}
