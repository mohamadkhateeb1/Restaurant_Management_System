<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
Route::group([
    'prefix' => 'Pges', //  Pages  رابط المسار يبدأ بـ 
    'middleware' => ['auth'],
    'as' => 'Pages.',
    /*
    الاسم سيكون 
    Pages. + اسم المسار المحدد (مثال: Pages.dashboard)
    */
], function () {

    // 2.1. مسار لوحة التحكم
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // 2.2. مسارات إدارة الموظفين (العرض، الإنشاء، التعديل، الحذف)
    // // إضافة مسار لإنشاء موظف جديد
    Route::resource('employee', EmployeesController::class);
    // Route::get('/employee', [EmployeesController::class, 'index'])->name('employee.index');
    // Route::get('/employee/create', [EmployeesController::class, 'create'])->name('employee.create');
    // Route::post('/employee/store', [EmployeesController::class, 'store'])->name('employee.store');
    // Route::get('/employee/{id}/edit', [EmployeesController::class, 'edit'])->name('employee.edit');
    // Route::put('/employee/{id}', [EmployeesController::class, 'update'])->name('employee.update');
    // Route::delete('/employee/{id}', [EmployeesController::class, 'destroy'])->name('employee.destroy');
    // Route::get('/employee/{id}/show', [EmployeesController::class, 'show'])->name('employee.show');
    //////////////////**************************//////////////////////////
    // 2.3. مسارات إدارة الأدوار والصلاحيات
    // Route::resource('role', \App\Http\Controllers\RolesRestaurantController::class);
});
// 2.3. مسارات إدارة الأدوار والصلاحيات
// Route::get('roles', [\App\Http\Controllers\RolesRestaurantController::class, 'index'])->name('roles.index');
// Route::get('roles/create', [\App\Http\Controllers\RolesRestaurantController::class, 'create'])->name('roles.create');
// Route::post('roles/store', [\App\Http\Controllers\RolesRestaurantController::class, 'store'])->name('roles.store');
// Route::get('roles/{rolesRestaurant}/edit', [\App\Http\Controllers\RolesRestaurantController::class, 'edit'])->name('roles.edit');
//     Route::put('roles/{rolesRestaurant}', [\App\Http\Controllers\RolesRestaurantController::class, 'update'])->name('roles.update');
//     Route::delete('roles/{id}', [\App\Http\Controllers\RolesRestaurantController::class, 'destroy'])->name('roles.destroy');


?>