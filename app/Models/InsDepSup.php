<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsDepSup extends Model
{
    protected $table = 'ins_dep_sup';
    public $timestamps = false;
    
    protected $fillable = ['supports_id', 'departmentsInstitutes_id'];
    
    public function supports(){
        return $this->belongsTo('Support');
    }

    public function departmentinstitute(){
        return $this->belongsTo('DepartmentInstitute');
    }
}
