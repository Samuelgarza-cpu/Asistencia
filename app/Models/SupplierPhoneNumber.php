<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPhoneNumber extends Model
{
    protected $table = 'suppliers_phoneNumbers';
    public $timestamps = false;
    protected $fillable = ['phoneNumbers_id', 'suppliers_id','ext','description'];

    public function supplier(){
        return $this->belongsTo('Supplier');
    }
}
