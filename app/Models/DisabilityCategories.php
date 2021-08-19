<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisabilityCategories extends Model
{
    protected $table = 'disability_categories';
    public $timestamps = false;
    protected $fillable = ['name', 'active'];
}
