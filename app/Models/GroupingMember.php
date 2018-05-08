<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AnimalProperty;

class GroupingMember extends Model
{
    protected $table = 'grouping_members';

    public function animals()
    {
      return $this->belongsTo('App\Models\Animal');
    }

    public function groupings()
    {
      return $this->belongsTo('App\Models\Grouping');
    }

    public function animalproperties()
    {
    	return $this->hasMany('App\Models\AnimalProperties');
    }

    public function getAnimalProperties()
    {
      $properties = AnimalProperty::where('animal_id', $this->animal_id)->get();
      return $properties;
    }

    public function getChild()
    {
    	$child = Animal::find($this->animal_id);
    	return $child;
    }
}