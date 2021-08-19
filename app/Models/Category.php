<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    
    public $timestamps = false;
    
    protected $fillable = ['name', 'active'];
    
    public function product(){
        return $this->hasMany('Product', 'products_id');
    }

    public function supportproduct(){
        return $this->hasMany('SupportProduct', 'categories_id');
    }
}
