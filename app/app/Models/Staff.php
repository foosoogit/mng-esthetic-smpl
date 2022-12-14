<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

//class Staff extends Authenticatable
class Staff extends User
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "staffs";
    protected $guard = 'staff';

    protected $fillable = [
		'email', 'password',
	];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
