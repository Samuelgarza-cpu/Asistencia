<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestBuildingMaterial extends Model
{
    protected $table = 'requests_building_materials';
    
    public $timestamps = false;
    
    protected $fillable = ['requests_id', 'buildingMaterials_id'];
    
    public function request(){
        return $this->belongsTo('Requisition');
    }

    public function buildingmaterial(){
        return $this->belongsTo('BuildingMaterial');
    }
}
