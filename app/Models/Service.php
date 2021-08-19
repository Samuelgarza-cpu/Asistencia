<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    
    public $timestamps = false;
    
    protected $fillable = ['name'];
    
    public function requestservices(){
        return $this->hasMany('RequestService', 'services_id');
    }
}
