<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtPersonalData extends Model
{
    protected $table = 'extpersonal_data';
    public $timestamps = false;
    protected $fillable = ['civilStatus', 'scholarShip','number', 'personal_data_id', 'employments_id'];
    public function personal_Data(){
        return $this->belongsTo('PersonalData');
    }

    public function employment(){
        return $this->belongsTo('Employment');
    }
}
