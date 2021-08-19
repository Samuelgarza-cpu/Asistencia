<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
    public $timestamps = false;
    protected $fillable = ['street', 'internalNumber', 'externalNumber', 'communities_id'];
   
    public function addresses_suppliers(){
        return $this->hasMany('AddressSupplier', 'addresses_id');
    }

    
    public function personaldata(){
        return $this->hasMany('PersonalData', 'addresses_id');
    }

    public function department_institute(){
        return $this->hasMany('DepartmentInsitute', 'addresses_id');
    }

    public function community(){
        return $this->belongsTo('Community');
    }
}
