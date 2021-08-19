<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LifeCondition extends Model
{
    protected $table = 'lifeConditions';
    public $timestamps = false;
    protected $fillable = ['typeHouse', 'number_rooms', 'requests_id'];
    
    public function request(){
        return $this->belongsTo('Requisition');
    }
}
