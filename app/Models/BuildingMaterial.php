<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildingMaterial extends Model
{
    protected $table = 'buildingMaterials';
    
    public $timestamps = false;
    
    protected $fillable = ['name'];
    
    public function requestbuildingmaterial(){
        return $this->hasMany('RequestBuildingMaterial', 'buildingMaterial_id');
    }
}
