<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeightCollection extends Model
{
	protected $table = 'weight_collections';
  public $timestamps = false;
  protected $fillable = [
    'weight'
  ];
  public function animals()
  {
    return $this->belongsTo('App\Models\Animal');
  }
}
