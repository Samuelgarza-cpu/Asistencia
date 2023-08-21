<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    protected $table = 'personalData';
    public $timestamps = false;
    protected $fillable = ['curp', 'name', 'lastName', 'secondLastName', 'age','addresses_id', 'familiar','sermedico'];
    public function extpersonalData(){
        return $this->hasMany('ExtPersonalData', 'personalData_id');
    }

    public function requestpersonaldata(){
        return $this->hasMany('RequestPersonalData', 'personalData_id');
    }

    public function address(){
        return $this->belongsTo('Address');
    }
}
