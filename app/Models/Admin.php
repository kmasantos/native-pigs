<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $timestamps = false;
    protected $table = 'admins';

    public function users()
    {
        return $this->morphMany(User::class, 'userable');
    }
    

}
