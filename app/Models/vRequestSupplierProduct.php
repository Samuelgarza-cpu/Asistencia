<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vRequestSupplierProduct extends Model
{
    protected $table = 'vrequests_suppliersProducts';
    
    public $timestamps = false;
    
    protected $fillable = ['qty', 'suppliersProducts_id', 'requests_id'];
    
    public function request(){
        return $this->belongsTo('Requisition');
    }

    public function supplierproducts(){
        return $this->belongsTo('SupplierProduct');
    }
}
