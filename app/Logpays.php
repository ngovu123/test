<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logpays extends Model
{
    protected $table ='logpays';

    public function users()
    {
        return $this->hasMany('App\User','u_id');
    }
}
