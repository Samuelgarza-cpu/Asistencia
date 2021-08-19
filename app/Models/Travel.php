<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    protected $table = 'travels';
    public $timestamps = false;
    protected $fillable = ['departure_date', 'return_date', 'destination_place', 'requests_id'];
    
    public function request(){
        return $this->belongsTo('Requisition');
    }
}
