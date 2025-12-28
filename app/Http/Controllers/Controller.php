<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    // بقاء الـ Traits كما هي لضمان عمل وظائف التحقق والصلاحيات الافتراضية
    use AuthorizesRequests, ValidatesRequests;
}