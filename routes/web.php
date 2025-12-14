<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;

Route::get('/', function () {
    return view('auth.login');
}); 

Route::group([
    'prefix' => 'Admin', //  Admin  رابط المسار يبدأ بـ 
    'middleware' => ['auth'],
    'as' => 'Admin.', 
    /*
    الاسم سيكون 
    Admin. + اسم المسار المحدد (مثال: Admin.dashboard)
    */ 
], function () {
    
    // 2.1. مسار لوحة التحكم
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// 2.2. مسارات إدارة الموظفين (العرض، الإنشاء، التعديل، الحذف)
    Route::get('/employees', [EmployeesController::class, 'index'])->name('employee.index');
    // إضافة مسار لإنشاء موظف جديد
    Route::get('/employees/create', [EmployeesController::class, 'create'])->name('employee.create');
    Route::post('/employees/store', [EmployeesController::class, 'store'])->name('employee.store');
    Route::get('/employees/{id}/edit', [EmployeesController::class, 'edit'])->name('employee.edit');
    Route::put('/employees/{id}', [EmployeesController::class, 'update'])->name('employee.update');
    Route::delete('/employees/{id}', [EmployeesController::class, 'destroy'])->name('employee.destroy');
    Route::get('/employees/{id}/show', [EmployeesController::class, 'show'])->name('employee.show');

});

require __DIR__ . '/auth.php';