<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLog extends Model
{
    protected $table = 'productslog';
    
    
    protected $fillable = ['suppliersProducts_id', 'price' ,'productName', 'supplierName'];
    
    public function supplierProduct(){
        return $this->belongsTo('SupplierProduct');
    }

}
