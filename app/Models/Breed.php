<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Breed extends Model
{
    use SoftDeletes;
    
    protected $table = 'breeds';
    protected $fillable = [
        'breed',
        'animaltype_id'
    ];
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
