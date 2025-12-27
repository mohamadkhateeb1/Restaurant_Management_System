<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cachier extends Model
{
    protected $table = 'cachiers';
    protected $fillable = ['name', 'email', 'password'];
}
