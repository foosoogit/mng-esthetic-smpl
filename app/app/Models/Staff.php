<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Foundation\Auth\Staff;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Staff extends User
{
    use HasFactory,Notifiable;

    protected $table = "staffs";

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
