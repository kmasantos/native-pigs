<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}