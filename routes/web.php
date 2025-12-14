<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
Route::get('/', function () {
    return view('auth.login');
}); 

Route::group([
    'prefix' => 'Admin',
    'middleware' => ['auth'],
], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('Admin.dashboard');
});
// Route::get('employee', [EmployeesController::class, 'index'])->name('Admin.employee.index');
// Route::get('employees/create', [EmployeesController::class, 'create'])->name('admin.employees.create');

require __DIR__ . '/auth.php';
