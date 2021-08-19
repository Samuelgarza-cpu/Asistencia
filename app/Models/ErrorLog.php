<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $table = 'errorslog';
    
    protected $fillable = ['users_id', 'description','owner'];


    public function user(){
        return $this->belongsTo('User');
    }
}