<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPersonalData extends Model
{
    protected $table = 'requests_personal_data';
    
    public $timestamps = false;
    
    protected $fillable = ['requests_id', 'personalData_id', 'familiar'];
    
    public function request(){
        return $this->belongsTo('Requisition');
    }

    public function personaldata(){
        return $this->belongsTo('PersonalData');
    }
}
