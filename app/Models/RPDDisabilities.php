<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RPDDisabilities extends Model
{
    protected $table = 'RPD_disabilities';
    public $timestamps = false;

    protected $fillable = ['disability_id', 'disabilitycategories_id', 'requestsPersonalData_id'];

}
