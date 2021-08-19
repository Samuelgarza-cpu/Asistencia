<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    protected $table = 'employments';
    public $timestamps = false;
    protected $fillable = ['name'];
    public function extpersonal_Data(){
        return $this->hasMany('ExtPersonalData', 'employments_id');
    }

    
    public function familysituation(){
        return $this->hasMany('FamilySituation', 'employments_id');
    }
}
