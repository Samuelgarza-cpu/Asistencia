<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EconomicData extends Model
{
    protected $table = 'economicData';
    public $timestamps = false;
    protected $fillable = ['income', 'expense', 'requests_id'];

    public function request(){
        return $this->belongsTo('Requisition');
    }
}
