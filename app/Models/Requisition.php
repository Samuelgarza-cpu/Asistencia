<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    
    protected $table= 'requests';
    protected $fillable = ['folio', 'type', 'description', 'petitioner', 'image', 'users_id', 'usersAuth_id', 'status_id', 'curpPetitioner', 'beneficiary', 'supports_id', 'categories_id', 'date', 'departments_institutes_id'];
       
    public function status(){
        return $this->belongsTo('Status');
    }

    public function user(){
        return $this->belongsTo('User');
    }

    public function userauth(){
        return $this->belongsTo('User');
    }

    public function economicdata(){
        return $this->hasMany('EconomicData', 'requests_id');
    }

    public function familysituation(){
        return $this->hasMany('FamilySituation', 'requests_id');
    }

    public function lifecondition(){
        return $this->hasMany('LifeCondition', 'requests_id');
    }

    public function travel(){
        return $this->hasMany('Travel', 'requests_id');
    }
    
    public function document(){
        return $this->hasMany('Document', 'requests_id');
    }

    public function requestsupplierproduct(){
        return $this->hasMany('RequestSupplierProduct', 'requests_id');
    }

    public function requestbuildingmaterial(){
        return $this->hasMany('RequestBuildingMaterial', 'requests_id');
    }

    public function requestservice(){
        return $this->hasMany('RequestService', 'requests_id');
    }

    public function requestfurniture(){
        return $this->hasMany('RequestFurniture', 'requests_id');
    }

    public function requestintdepsuppro(){
        return $this->hasMany('RequestIntDepSupPro', 'requests_id');
    }

    public function requestpersonaldata(){
        return $this->hasMany('RequestPersonalData', 'requests_id');
    }
}
