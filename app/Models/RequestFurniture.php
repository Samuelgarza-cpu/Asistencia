<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestFurniture extends Model
{
    protected $table = 'requests_furnitures';
    
    public $timestamps = false;
    
    protected $fillable = ['requests_id', 'furnitures_id'];
    
    public function request(){
        return $this->belongsTo('Requisition');
    }

    public function furniture(){
        return $this->belongsTo('Furniture');
    }
}
