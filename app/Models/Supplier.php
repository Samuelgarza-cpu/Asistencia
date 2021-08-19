<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    public $timestamps = false;
    protected $fillable = ['companyname','RFC','email','description','active', 'department'];
    
    
    public function supplier_products(){
        return $this->hasMany('SupplierProduct', 'suppliers_id');
    }

    public function supplier_phone_numbers(){
        return $this->hasMany('SupplierPhoneNumber', 'suppliers_id');
    }

    public function address_supplier(){
        return $this->hasMany('AddressSupplier', 'suppliers_id');
    }
}
