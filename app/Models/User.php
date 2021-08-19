<?php

namespace App\Models;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'email', 'signature', 'active', 'owner', 'roles_id', 'departments_institutes_id', 'token'
    ];
    /** 
     * the database table used by the model.
    *@var string
    */
    protected $table= 'users';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rol(){
        return $this->belongsTo('Role');
    }

    public function department(){
        return $this->belongsTo('Department');
    }

    public function request(){
        return $this->hasMany('Requisition', 'users_id');
    }

    public function requestAuth(){
        return $this->hasMany('Requisition', 'users_auth_id');
    }
}
