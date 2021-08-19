<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $table = 'communities';
    public $timestamps = false;
    protected $fillable = ['name', 'postalCode','type', 'zone', 'municipalities_id'];

    public function address(){
        return $this->hasMany('Address', 'communities_id');
    }
    
    public function municipaly(){
        return $this->belongsTo('Municipality');
    }
}
