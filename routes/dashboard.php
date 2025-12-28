<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TablesRestaurantController;
use App\Http\Controllers\CategoriesRestaurantController;
use App\Http\Controllers\ItemsRestaurantController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\InvetoryController;
use App\Http\Controllers\InvetoryTransactionsController;
use App\Http\Controllers\OrderItemsRestaurantController;
use App\Http\Controllers\ReportController;

Route::middleware(['auth:employee'])->group(function () {

    Route::group([
        'prefix' => 'Pges',
        'as' => 'Pages.',
    ], function () {

        // --- لوحة التحكم والإدارة ---
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // --- إدارة الموظفين ---
        Route::resource('employee', EmployeesController::class);

        // --- إدارة الصلاحيات والأدوار ---
        Route::resource('roles', RoleController::class);

        // --- تقارير النظام ---
        Route::resource('reports', ReportController::class);
        Route::get('reports/archive', [ReportController::class, 'archiveIndex'])->name('reports.archive');
        Route::get('reports/export-sales', [ReportController::class, 'exportSales'])->name('reports.exportSales');
        Route::get('reports/export-invoices', [ReportController::class, 'exportInvoices'])->name('reports.exportInvoices');
        Route::get('reports/export-inventory', [ReportController::class, 'exportInventory'])->name('reports.exportInventory'); // يجب أن يكون الرابط بسيطاً ولا يحتوي على {id}
        Route::get('/reports/daily/{date}', [ReportController::class, 'show'])->name('reports.show');

        // --- إدارة المخزون ---
        Route::resource('inventory', InvetoryController::class);
        Route::get('inventory/{id}/create-transaction', [InvetoryTransactionsController::class, 'create'])->name('inventory.transactions.create');
        Route::post('inventory/{id}/store-transaction', [InvetoryTransactionsController::class, 'store'])->name('inventory.transactions.store');

        // --- إدارة قوائم الطعام ---
        Route::delete('categories/bulk-destroy', [CategoriesRestaurantController::class, 'bulkDestroy'])->name('categories.bulkDestroy');
        Route::resource('categories', CategoriesRestaurantController::class);

        // --- إدارة فواتير الطلبات ---
        Route::resource('invoices', OrderItemsRestaurantController::class);

        // --- إدارة أصناف الطعام ---
        Route::delete('Items/bulk-destroy', [ItemsRestaurantController::class, 'bulkDestroy'])->name('Items.bulkDestroy');
        Route::resource('Items', ItemsRestaurantController::class);

        // --- مسارات النادل ---
        Route::group([
            'prefix' => 'waiter',
            'as' => 'waiter.',
        ], function () {
            Route::get('/', [WaiterController::class, 'index'])->name('index');
            Route::post('/draft/add', [WaiterController::class, 'addToDraft'])->name('addToDraft');
            Route::post('/draft/update', [WaiterController::class, 'updateDraft'])->name('updateDraft');
            Route::post('/store-order', [WaiterController::class, 'storeOrder'])->name('storeOrder');
            Route::post('/request-bill/{id}', [WaiterController::class, 'requestBill'])->name('requestBill');
        });

        // --- مسارات الكاشير  ---
        Route::get('/cashier/payments', [CashierController::class, 'index'])->name('cashier.index');
        Route::post('/cashier/pay-dinein', [CashierController::class, 'payDineIn'])->name('cashier.payDineIn');
        Route::post('/cashier/undo-takeaway', [CashierController::class, 'undoLastTakeaway'])->name('cashier.undoTakeaway');

        Route::get('/cashier/pos', [CashierController::class, 'create'])->name('cashier.create');
        Route::post('/cashier/store-takeaway', [CashierController::class, 'storeTakeaway'])->name('cashier.storeTakeaway');
        Route::post('/cashier/pos/add', [CashierController::class, 'addToSessionCart'])->name('cashier.addToCart');
        Route::post('/cashier/pos/remove/{id}', [CashierController::class, 'removeFromSessionCart'])->name('cashier.removeFromCart');
        Route::post('/cashier/pos/clear', [CashierController::class, 'clearSessionCart'])->name('cashier.clearCart');

        Route::get('/cashier/invoices', [CashierController::class, 'invoicesIndex'])->name('cashier.invoice');
        Route::get('/cashier/invoices/{id}', [CashierController::class, 'showInvoice'])->name('invoice.show');
        Route::get('/', [CashierController::class, 'invoicesIndex'])->name('index');

        // --- مسارات المطبخ  ---
        Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
        Route::get('/kitchen/orders', [KitchenController::class, 'getOrders'])->name('kitchen.getOrders');
        Route::post('/kitchen/update-status', [KitchenController::class, 'updateStatus'])->name('kitchen.updateStatus');

        // --- إدارة الطاولات ---
        Route::delete('tables/bulk-destroy', [TablesRestaurantController::class, 'bulkDestroy'])->name('Tables.bulkDestroy');
        Route::resource('Tables', TablesRestaurantController::class);
    });
});
