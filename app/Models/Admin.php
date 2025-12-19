<?php

namespace App\Models;
use App\Concems\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // تأكد من هذا السطر
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasRoles,Notifiable;
    protected $fillable=[
        'name',
        'email',
        'username',
        'password',
        'phone_number',
        'super_admin',
        'status',
    ];
}
