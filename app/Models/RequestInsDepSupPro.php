<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestInsDepSupPro extends Model
{
    protected $table = 'requests_ins_dep_sup_pro';
    
    public $timestamps = false;
    
    protected $fillable = ['requests_id', 'products_id', 'qty', 'price'];
    
    public function request(){
        return $this->belongsTo('Requisition');
    }

    public function insdepsuppro(){
        return $this->belongsTo('InsDepSupPro');
    }
}
