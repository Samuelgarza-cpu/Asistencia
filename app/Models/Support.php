<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $table = 'supports';
    public $timestamps = false;
    protected $hidden = ['code'];
    protected $fillable = ['name','code', 'active'];

    public function supports_products(){
        return $this->hasMany('SupportProduct', 'supports_id');
    }
    
    public function departmentinstitutesupportproduct(){
        return $this->hasMany('InsDepSupPro', 'supportsProducts_id');
 }

}
