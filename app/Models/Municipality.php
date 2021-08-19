<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $table = 'municipalities';
    public $timestamps = false;
    protected $fillable = ['name', 'states_id'];

    public function state(){
        return $this->hasMany('State', 'states_id');
    }

    public function community(){
        return $this->belongsTo('Community');
    }
}
