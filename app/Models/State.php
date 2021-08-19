<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';
    public $timestamps = false;
    protected $fillable = ['name'];
    public function municipality(){
        return $this->hasMany('Municipality', 'states_id');
    }

}
