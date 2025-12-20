<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TablesRestaurantController;
use App\Http\Controllers\CategoriesRestaurantController;

/*
|--------------------------------------------------------------------------
| مسارات لوحة التحكم (محمية بـ Middleware Auth)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {// بداية مجموعة المسارات المحمية بالمصادقة

    // 1. مجموعة الصفحات العامة (Pges)
    Route::group([
        'prefix' => 'Pges', 
        'as' => 'Pages.',
    ], function () {

        // لوحة التحكم
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // إدارة الموظفين
        Route::resource('employee', EmployeesController::class);

        // إدارة الأدوار والصلاحيات
        Route::resource('roles', RoleController::class);

        // إدارة التصنيفات (Categories)
        // ملاحظة: مسار الحذف الجماعي يجب أن يكون قبل الـ Resource
        Route::delete('categories/bulk-destroy', [CategoriesRestaurantController::class, 'bulkDestroy'])->name('categories.bulkDestroy');
        Route::resource('categories', CategoriesRestaurantController::class);
    });

    // 2. مجموعة إدارة الطاولات (إصلاح شامل)
    Route::group([
        'prefix' => 'Pages', 
        'as' => 'Pages.',
    ], function () {
        Route::resource('Tables', TablesRestaurantController::class);
    });
});
//هاد مشان احذف كل الطاولات الي عندي
Route::delete('tables/bulk-destroy', [TablesRestaurantController::class, 'bulkDestroy'])->name('Pages.Tables.bulkDestroy');