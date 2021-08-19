<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestSupplierProduct extends Model
{
    protected $table = 'requests_suppliersProducts';
    
    public $timestamps = false;
    
    protected $fillable = ['qty', 'suppliersProducts_id', 'requests_id'];
    
    public function request(){
        return $this->belongsTo('Requisition');
    }

    public function supplierproducts(){
        return $this->belongsTo('SupplierProduct');
    }
}
