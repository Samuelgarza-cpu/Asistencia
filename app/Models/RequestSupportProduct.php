<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestSupportProduct extends Model
{
    protected $table = 'requests_supports_products';
    public $timestamps = false;
    
    protected $fillable = ['request_id', 'supports_products_id', 'suppliers_products_id'];

    public function request(){
        return $this->belongsTo('Requisition');
    }

    public function support_product(){
        return $this->belongsTo('SupportProduct');
    }
}
