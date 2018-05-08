<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Farm;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'photo', 'isadmin', 'lastseen'
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function farmable()
    {
        return $this->belongsTo('App\Models\Farm', 'farmable_id');
    }

    public function getFarm(){
      $farm = Farm::where('id', $this->farmable_id)->first();
      return $farm;
    }


}
