<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    public $timestamps = false;
    protected $hidden = [
        'code'
    ];
    protected $fillable = ['name','code'];
    
    public function departments_institutes(){
        return $this->hasMany('DepartmentInstitute', 'departments_id');
    }
}
