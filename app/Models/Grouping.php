<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grouping extends Model
{
    protected $table = 'groupings';
    public $timestamps = false;
    protected $fillable = [
      'members'
    ];

    public function animals()
    {
      return $this->belongsTo('App\Models\Animal');
    }

    public function groupingmembers()
    {
      return $this->hasMany('App\Models\GroupingMember');
    }

    public function properties()
    {
      return $this->hasMany('App\Models\GroupingProperty');
    }

    public function getGroupingProperties()
    {
      $properties = GroupingProperty::where('grouping_id', $this->id)->get();
      return $properties;
    }

    public function getMother()
    {
      $mother = Animal::find($this->mother_id);
      return $mother;
    }

    public function getFather()
    {
      $father = Animal::find($this->father_id);
      return $father;
    }

    public function getGroupingMembers()
    {
      $members = GroupingMember::where('grouping_id', $this->id)->get();
      return $members;
    }
}
