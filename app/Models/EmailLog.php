<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $table = 'emaillog';
    
    protected $fillable = ['sender', 'recipient' ,'status', 'descriptionStatus'];
    
}
