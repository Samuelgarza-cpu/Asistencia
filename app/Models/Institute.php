<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $table = 'institutes';
    public $timestamps = false;
    protected $fillable = ['name','active'];
    public function phone_number_personal_data(){
        return $this->hasMany('DepartmentIntitute', 'institutes_id');
    }
}
