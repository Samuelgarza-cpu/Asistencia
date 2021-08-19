<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportProduct extends Model
{
    protected $table = 'supports_products';
    public $timestamps = false;
    
    protected $fillable = ['supports_id', 'categories_id', 'active'];

    public function support(){
        return $this->belongsTo('Support');
    }

    public function product(){
        return $this->belongsTo('Category');
    }
}
