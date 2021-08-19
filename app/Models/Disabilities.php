<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disabilities extends Model
{
    protected $table = 'disabilities';
    public $timestamps = false;
    protected $fillable = ['name', 'disabilitycategories_id','active'];
}
