<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestService extends Model
{
    protected $table = 'requests_services';
    
    public $timestamps = false;
    
    protected $fillable = ['requests_id', 'services_id'];
    
    public function request(){
        return $this->belongsTo('Requisition');
    }

    public function service(){
        return $this->belongsTo('Service');
    }
}
