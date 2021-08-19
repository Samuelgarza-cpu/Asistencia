<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = false;
    protected $fillable = ['name', 'code', 'categories_id'];

    public function supplier_products(){
        return $this->hasMany('SupplierProduct', 'products_id');
    }

    public function categories(){
        return $this->belongsTo('Category');
    }
}
