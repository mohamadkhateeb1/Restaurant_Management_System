<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Inventory;
use App\Models\DineInOrderRestaurant;
use App\Models\TakeAwaysRestaurant;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. إحصائيات المبيعات (اليوم مقابل أمس)
        $todaySales = Invoice::whereDate('created_at', Carbon::today())->sum('amount_paid');
        $yesterdaySales = Invoice::whereDate('created_at', Carbon::yesterday())->sum('amount_paid');
        $salesChange = $yesterdaySales > 0 ? (($todaySales - $yesterdaySales) / $yesterdaySales) * 100 : 0;

        // 2. الطاولات والطلبات النشطة (بناءً على الحالات في الميغريشن)
        // الطاولات المفتوحة: أي طلب صالة لم يسدد بعد
        $openTables = DineInOrderRestaurant::where('status', '!=', 'paid')->count();
        
        // قيد التحضير: مجموع طلبات الصالة والسفري التي حالتها 'preparing'
        $preparingOrders = DineInOrderRestaurant::where('status', 'preparing')->count() + 
                           TakeAwaysRestaurant::where('status', 'preparing')->count();

        // 3. بيانات الرسم البياني للمبيعات (آخر 7 أيام)
        $salesData = Invoice::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(amount_paid) as total')
        )
        ->where('created_at', '>=', now()->subDays(6))
        ->groupBy('date')->orderBy('date')->get();

        // 4. بيانات الرسم البياني الدائري (توزيع صالة vs سفري)
        $dineInCount = Invoice::whereNotNull('dine_in_order_id')->count();
        $takeawayCount = Invoice::whereNotNull('takeaway_order_id')->count();

        // 5. إحصائيات عامة
        $lowStockCount = Inventory::whereColumn('quantity', '<=', 'min_quantity')->count();
        $activeEmployeesCount = Employee::count();
        $employees = Employee::where('super_admin', true)->latest()->take(5)->get();
        
        $users = Employee::latest()->take(5)->get(); // تم الإبقاء عليها كما في كودك

        // 6. الأصناف الأكثر طلباً (Top Items)
        $topItems = DB::table('order_items_restaurants')
                    ->join('items_restaurants', 'order_items_restaurants.item_id', '=', 'items_restaurants.id')
                    ->select('items_restaurants.item_name', DB::raw('COUNT(*) as total'))
                    ->groupBy('items_restaurants.id', 'items_restaurants.item_name')
                    ->orderByDesc('total')->take(5)->get();

        return view('Pages.dashboard', compact(
            'todaySales', 'salesChange', 'lowStockCount', 'activeEmployeesCount', 
            'employees', 'users', 'salesData', 'dineInCount', 'takeawayCount', 
            'topItems', 'openTables', 'preparingOrders'
        ));
    }
}