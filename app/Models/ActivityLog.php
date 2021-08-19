<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activities_log';
    protected $fillable = ['users_id', 'description','owner'];
}
