<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierProduct extends Model
{
    protected $table = 'suppliers_products';

    protected $fillable = [
        'price', 'products_id', 'suppliers_id', 'active'
    ];

    public function supplier(){
        return $this->belongsTo('Supplier');
    }

    public function product(){
        return $this->belongsTo('Product');
    }

    public function requestsupplierproduct(){
        return $this->hasMany('RequestSupplierProduct', 'suppliersProducts_id');
    }

    public function productlog(){
        return $this->hasMany('ProductLog', 'suppliersProducts_id');
    }
}
