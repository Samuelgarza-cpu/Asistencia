<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressSupplier extends Model
{
    protected $table = 'addresses_suppliers';
    public $timestamps = false;
    protected $fillable = ['addresses_id', 'suppliers_id'];

    public function supplier(){
        return $this->belongsTo('Supplier');
    }

    public function address(){
        return $this->belongsTo('Address');
    }
}
