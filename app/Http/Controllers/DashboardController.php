<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Inventory;
use App\Models\DineInOrderRestaurant;
use App\Models\TakeAwaysRestaurant;
use App\Models\TablesRestaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Employee::class);
        $todaySales = Invoice::whereDate('created_at', Carbon::today())->sum('amount_paid');
        $yesterdaySales = Invoice::whereDate('created_at', Carbon::yesterday())->sum('amount_paid');

        $openTablesCount = DineInOrderRestaurant::where('status', '!=', 'paid')->count();
        $preparingOrders = DineInOrderRestaurant::where('status', 'preparing')->count() +
            TakeAwaysRestaurant::where('status', 'preparing')->count();

        $tablesMap = TablesRestaurant::select('table_number', 'status')->get();

        $salesData = Invoice::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(amount_paid) as total')
        )
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')->orderBy('date')->get();

        $dineInCount = Invoice::whereNotNull('dine_in_order_id')->count();
        $takeawayCount = Invoice::whereNotNull('takeaway_order_id')->count();

        // 6. إحصائيات عامة والمخزن
        $lowStockCount = Inventory::whereColumn('quantity', '<=', 'min_quantity')->count();
        $activeEmployeesCount = Employee::count();
        $employees = Employee::where('super_admin', true)->latest()->take(5)->get();

        $topItems = DB::table('order_items_restaurants')
            ->join('items_restaurants', 'order_items_restaurants.item_id', '=', 'items_restaurants.id')
            ->leftJoin('invoices', function ($join) {
                $join->on('order_items_restaurants.take_away_order_id', '=', 'invoices.takeaway_order_id')
                    ->orOn('order_items_restaurants.dine_in_order_id', '=', 'invoices.dine_in_order_id');
            })
            ->whereNotNull('invoices.id')
            ->select('items_restaurants.item_name', DB::raw('SUM(order_items_restaurants.quantity) as total'))
            ->groupBy('items_restaurants.id', 'items_restaurants.item_name')
            ->orderByDesc('total')->take(5)->get();

        return view('Pages.dashboard', compact(
            'todaySales',
            'lowStockCount',
            'activeEmployeesCount',
            'employees',
            'salesData',
            'dineInCount',
            'takeawayCount',
            'topItems',
            'openTablesCount',
            'preparingOrders',
            'tablesMap'
        ));
    }
}
