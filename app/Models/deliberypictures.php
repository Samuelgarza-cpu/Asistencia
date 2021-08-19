<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class deliberypictures extends Model
{
    protected $table = 'deliberypictures';
    protected $fillable = ['name', 'requests_id'];
}
