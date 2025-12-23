<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TablesRestaurantController;
use App\Http\Controllers\CategoriesRestaurantController;
use App\Http\Controllers\ItemsRestaurantController;
use App\Http\Controllers\DineInOrderRestaurantController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\WaiterController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::middleware(['auth:employee'])->group(function () {

    // 1. مجموعة الصفحات العامة (Pages)
    Route::group([
        'prefix' => 'Pges',
        'as' => 'Pages.',
    ], function () {

        // --- لوحة التحكم ---
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // --- إدارة الموارد الأساسية ---
        Route::resource('employee', EmployeesController::class);
        Route::resource('roles', RoleController::class);

        // --- إدارة التصنيفات ---
        Route::delete('categories/bulk-destroy', [CategoriesRestaurantController::class, 'bulkDestroy'])->name('categories.bulkDestroy');
        Route::resource('categories', CategoriesRestaurantController::class);

        // --- إدارة الأصناف ---
        Route::delete('Items/bulk-destroy', [ItemsRestaurantController::class, 'bulkDestroy'])->name('Items.bulkDestroy');
        Route::resource('Items', ItemsRestaurantController::class);

        // --- تعديل مسارات النادل (Waiter) لتصبح "متل الخلق" ---
        Route::group([
            'prefix' => 'waiter',
            'as' => 'waiter.',
        ], function () {
            Route::get('/', [WaiterController::class, 'index'])->name('index'); 
            
            // إضافة وحذف من المسودة (Session)
            Route::post('/draft/add', [WaiterController::class, 'addToDraft'])->name('addToDraft');
            Route::post('/draft/update', [WaiterController::class, 'updateDraft'])->name('updateDraft');
            
            // إرسال للمطبخ وطلب الحساب
            Route::post('/store-order', [WaiterController::class, 'storeOrder'])->name('storeOrder');
            Route::post('/request-bill/{id}', [WaiterController::class, 'requestBill'])->name('requestBill');
        });

        // مسارات الكاشير - قسم المحاسبة ودفع الفواتير
        Route::get('/cashier/payments', [CashierController::class, 'index'])->name('cashier.index');
        Route::post('/cashier/pay-dinein', [CashierController::class, 'payDineIn'])->name('cashier.payDineIn');

        // مسارات الكاشير - قسم طلب جديد (POS)
        Route::get('/cashier/pos', [CashierController::class, 'create'])->name('cashier.create');
        Route::post('/cashier/store-takeaway', [CashierController::class, 'storeTakeaway'])->name('cashier.storeTakeaway');
        Route::post('/cashier/pos/add', [CashierController::class, 'addToSessionCart'])->name('cashier.addToCart');
        Route::post('/cashier/pos/remove/{id}', [CashierController::class, 'removeFromSessionCart'])->name('cashier.removeFromCart');
        Route::post('/cashier/pos/clear', [CashierController::class, 'clearSessionCart'])->name('cashier.clearCart');
        // مسارات سجل الفواتير
        Route::get('/', [CashierController::class, 'invoicesIndex'])->name('index');
        Route::get('/cashier/invoices/{id}', [CashierController::class, 'showInvoice'])->name('invoice.show');
        Route::get('/cashier/invoices', [CashierController::class, 'invoicesIndex'])->name('cashier.invoice');
        
        // --- مسارات المطبخ (Kitchen) ---
        Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
        Route::get('/kitchen/orders', [KitchenController::class, 'getOrders'])->name('kitchen.getOrders');
        Route::post('/kitchen/update-status', [KitchenController::class, 'updateStatus'])->name('kitchen.updateStatus');
    });

    // 2. مجموعة إدارة الطاولات
    Route::group([
        'prefix' => 'Pages',
        'as' => 'Pages.',
    ], function () {
        Route::delete('tables/bulk-destroy', [TablesRestaurantController::class, 'bulkDestroy'])->name('Tables.bulkDestroy');
        Route::resource('Tables', TablesRestaurantController::class);
    });


});