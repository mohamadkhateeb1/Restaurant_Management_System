<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function() {

    // 1. الصفحة الرئيسية (Welcome) - متاحة للجميع بدون تسجيل دخول
    Route::get('/', function () {
        return view('welcome'); // تأكد أن اسم الملف welcome.blade.php
    })->name('welcome');

    // 2. مسارات تسجيل الدخول (Breeze)
    require __DIR__ . '/auth.php';

    // 3. مسارات لوحة التحكم (المحمية)
    Route::middleware(['auth:employee'])->group(function () {
        
        // مسار الداشبورد الأساسي
     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // استدعاء باقي مسارات الداشبورد من ملف خارجي
        require __DIR__ . '/dashboard.php';
    });

});