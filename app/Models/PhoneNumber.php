<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    protected $table = 'phoneNumbers';
    public $timestamps = false;
    protected $fillable = ['number'];
    
    public function supplier_phonenumbers(){
        return $this->hasMany('SupplierPhoneNumber', 'phoneNumbers_id');
    }

}
