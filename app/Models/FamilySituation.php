<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilySituation extends Model
{
    protected $table = 'familySituations';
    public $timestamps = false;
    protected $fillable = ['name', 'lastname', 'secondlastname','age','relationship','civilStatus','scholarship','employments_id','requests_id'];

    public function employment(){
        return $this->belongsTo('Employment');
    }

    public function request(){
        return $this->belongsTo('Requisition');
    }
}