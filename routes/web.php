<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

    Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]// هذا يضيف دعم التوطين للمسارات
], function(){ //...


Route::get('/', function () {
    return view('Pages.Dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';
});